<?php

namespace common\models;

use common\tools\Encrypt;
use Yii;

/**
 * This is the model class for table "wechat_refund".
 *
 * @property integer $wechat_refund_id
 * @property integer $wechat_refund_refund_id
 * @property integer $wechat_refund_wechat_id
 * @property string $wechat_refund_out_refund_no
 * @property integer $wechat_refund_refund_fee
 * @property string $wechat_refund_out_refund_id
 * @property string $wechat_refund_status
 * @property string $wechat_refund_response
 *
 * @property Refund $wechatRefundRefund
 * @property Wechat $wechatRefundWechat
 */
class WechatRefund extends \yii\db\ActiveRecord
{

    const WECHAT_REFUND_STATUS_REPORT = "REPORT";//状态:已同步
    const WECHAT_REFUND_STATUS_WAIT = "WAIT";//状态:余额不足
    const WECHAT_REFUND_STATUS_SUCCESS = "SUCCESS";//状态:退款成功
    const WECHAT_REFUND_STATUS_FAIL = "FAIL";//状态:退款失败
    const WECHAT_REFUND_STATUS_PROCESSING = "PROCESSING";//状态:退款处理中
    const WECHAT_REFUND_STATUS_CHANGE = "CHANGE";//状态:转入代发

    public $statusList = [
        self::WECHAT_REFUND_STATUS_REPORT => Refund::REFUND_STATUS_RECEIVE,
        self::WECHAT_REFUND_STATUS_WAIT => Refund::REFUND_STATUS_WAIT,
        self::WECHAT_REFUND_STATUS_SUCCESS => Refund::REFUND_STATUS_SUCCESS,
        self::WECHAT_REFUND_STATUS_FAIL => Refund::REFUND_STATUS_FAIL,
        self::WECHAT_REFUND_STATUS_PROCESSING => Refund::REFUND_STATUS_PROCESS,
        self::WECHAT_REFUND_STATUS_CHANGE => Refund::REFUND_STATUS_FAIL
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_refund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wechat_refund_refund_id', 'wechat_refund_wechat_id', 'wechat_refund_out_refund_no', 'wechat_refund_refund_fee'], 'required'],
            [['wechat_refund_refund_id', 'wechat_refund_wechat_id', 'wechat_refund_refund_fee'], 'integer'],
            [['wechat_refund_response'], 'string'],
            [['wechat_refund_out_refund_no', 'wechat_refund_out_refund_id'], 'string', 'max' => 32],
            [['wechat_refund_status'], 'string', 'max' => 16],
            [['wechat_refund_refund_id'], 'unique'],
            [['wechat_refund_out_refund_no'], 'unique'],
            [['wechat_refund_refund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Refund::className(), 'targetAttribute' => ['wechat_refund_refund_id' => 'refund_id']],
            [['wechat_refund_wechat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wechat::className(), 'targetAttribute' => ['wechat_refund_wechat_id' => 'wechat_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wechat_refund_id' => 'Wechat Refund ID',
            'wechat_refund_refund_id' => 'Wechat Refund Refund ID',
            'wechat_refund_wechat_id' => 'Wechat Refund Wechat ID',
            'wechat_refund_out_refund_no' => 'Wechat Refund Out Refund No',
            'wechat_refund_refund_fee' => 'Wechat Refund Refund Fee',
            'wechat_refund_out_refund_id' => 'Wechat Refund Out Refund ID',
            'wechat_refund_status' => 'Wechat Refund Status',
            'wechat_refund_response' => 'Wechat Refund Response',
        ];
    }
    //========
    //next is model function
    public function initNew($refund, $wechat, $amount)
    {
        $this->wechat_refund_refund_id = $refund;
        $this->wechat_refund_wechat_id = $wechat;
        $this->wechat_refund_refund_fee = $amount * 100;
        $this->wechat_refund_out_refund_no = Encrypt::md5Str($refund, 'wechatRefund');
    }

    public function refund(){
        $wechat_sdk = new \common\components\Wechat($this->wechatRefundRefund->refundOperation->operationChannel);
        $response = $wechat_sdk->refund($this);
        if($response){
            if(isset($response['result_code']) && $response['result_code'] == "SUCCESS"){
                $this->wechat_refund_out_refund_id = $response['refund_id'];
                $this->wechat_refund_status = self::WECHAT_REFUND_STATUS_REPORT;
            }else{
                if(isset($response['err_code']) && $response['err_code'] == "NOTENOUGH"){
                    $this->wechat_refund_status = self::WECHAT_REFUND_STATUS_WAIT;
                }
            }
        }

        if($this->update()){
            $this->wechatRefundRefund->updateStatus();
            return true;
        }
        return false;
    }

    public function query(){
        if(in_array($this->wechat_refund_status,["",self::WECHAT_REFUND_STATUS_REPORT])){
            $wechat_sdk = new \common\components\Wechat($this->wechatRefundRefund->refundOperation->operationChannel);
            $response = $wechat_sdk->refundQuery($this);
        }
        $this->wechatRefundRefund->updateStatus();
        return true;
    }

    public function updateStatus($result){
        $this->wechat_refund_out_refund_id = $result['refund_id_0'];
        $this->wechat_refund_status = $result['refund_status_0'];
        $this->wechat_refund_response = serialize($result);
        if($this->update()){
            $this->wechatRefundRefund->updateStatus();
        }
    }

    //========
    //next is fk function
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWechatRefundRefund()
    {
        return $this->hasOne(Refund::className(), ['refund_id' => 'wechat_refund_refund_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWechatRefundWechat()
    {
        return $this->hasOne(Wechat::className(), ['wechat_id' => 'wechat_refund_wechat_id']);
    }
}
