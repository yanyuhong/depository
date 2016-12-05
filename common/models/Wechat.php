<?php

namespace common\models;

use common\tools\Encrypt;
use common\tools\Time;
use Yii;

/**
 * This is the model class for table "wechat".
 *
 * @property integer $wechat_id
 * @property integer $wechat_charge_id
 * @property string $wechat_out_trade_no
 * @property string $wechat_body
 * @property string $wechat_detail
 * @property integer $wechat_total_fee
 * @property string $wechat_spbill_create_ip
 * @property string $wechat_time_start
 * @property string $wechat_time_expire
 * @property string $wechat_trade_type
 * @property string $wechat_transaction_id
 * @property string $wechat_trade_state
 * @property string $wechat_openid
 * @property string $wechat_bank_type
 * @property integer $wechat_cash_fee
 * @property string $wechat_time_end
 * @property string $wechat_response
 * @property string $wechat_updated_at
 *
 * @property Charge $wechatCharge
 * @property WechatRefund[] $wechatRefunds
 */
class Wechat extends \yii\db\ActiveRecord
{

    const WECHAT_STATE_SUCCESS = "SUCCESS"; //订单状态:支付成功
    const WECHAT_STATE_REFUND = "REFUND"; //订单状态:转入退款
    const WECHAT_STATE_NOTPAY = "NOTPAY"; //订单状态:未支付
    const WECHAT_STATE_CLOSED = "CLOSED"; //订单状态:已关闭
    const WECHAT_STATE_REVOKED = "REVOKED"; //订单状态:已撤销
    const WECHAT_STATE_USERPAYING = "USERPAYING"; //订单状态:用户支付中
    const WECHAT_STATE_PAYERROR = "PAYERROR"; //订单状态:支付失败

    public $stateList = [
        self::WECHAT_STATE_SUCCESS => Charge::CHARGE_STATUS_SUCCESS,
        self::WECHAT_STATE_REFUND => Charge::CHARGE_STATUS_SUCCESS,
        self::WECHAT_STATE_NOTPAY => Charge::CHARGE_STATUS_WAIT,
        self::WECHAT_STATE_CLOSED => Charge::CHARGE_STATUS_CLOSE,
        self::WECHAT_STATE_REVOKED => Charge::CHARGE_STATUS_CLOSE,
        self::WECHAT_STATE_USERPAYING => Charge::CHARGE_STATUS_WAIT,
        self::WECHAT_STATE_PAYERROR => Charge::CHARGE_STATUS_CLOSE,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wechat_charge_id', 'wechat_out_trade_no', 'wechat_body', 'wechat_total_fee', 'wechat_spbill_create_ip', 'wechat_trade_type'], 'required'],
            [['wechat_charge_id', 'wechat_total_fee', 'wechat_cash_fee'], 'integer'],
            [['wechat_detail', 'wechat_response'], 'string'],
            [['wechat_updated_at'], 'safe'],
            [['wechat_out_trade_no', 'wechat_trade_state'], 'string', 'max' => 32],
            [['wechat_body', 'wechat_openid'], 'string', 'max' => 128],
            [['wechat_spbill_create_ip', 'wechat_time_start', 'wechat_time_expire', 'wechat_trade_type', 'wechat_bank_type', 'wechat_time_end'], 'string', 'max' => 16],
            [['wechat_transaction_id'], 'string', 'max' => 64],
            [['wechat_charge_id'], 'unique'],
            [['wechat_out_trade_no'], 'unique'],
            [['wechat_charge_id'], 'exist', 'skipOnError' => true, 'targetClass' => Charge::className(), 'targetAttribute' => ['wechat_charge_id' => 'charge_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wechat_id' => 'Wechat ID',
            'wechat_charge_id' => 'Wechat Charge ID',
            'wechat_out_trade_no' => 'Wechat Out Trade No',
            'wechat_body' => 'Wechat Body',
            'wechat_detail' => 'Wechat Detail',
            'wechat_total_fee' => 'Wechat Total Fee',
            'wechat_spbill_create_ip' => 'Wechat Spbill Create Ip',
            'wechat_time_start' => 'Wechat Time Start',
            'wechat_time_expire' => 'Wechat Time Expire',
            'wechat_trade_type' => 'Wechat Trade Type',
            'wechat_transaction_id' => 'Wechat Transaction ID',
            'wechat_trade_state' => 'Wechat Trade State',
            'wechat_openid' => 'Wechat Openid',
            'wechat_bank_type' => 'Wechat Bank Type',
            'wechat_cash_fee' => 'Wechat Cash Fee',
            'wechat_time_end' => 'Wechat Time End',
            'wechat_response' => 'Wechat Response',
            'wechat_updated_at' => 'Wechat Updated At',
        ];
    }

    //=======
    //next is model function
    /**
     * @param $charge Charge
     */
    public function initNew($charge)
    {
        $this->wechat_charge_id = $charge->charge_id;
        $this->wechat_out_trade_no = Encrypt::md5Str($charge->charge_id, 'wechat');
        $this->wechat_body = $charge->charge_title;
        $this->wechat_detail = $charge->charge_detail;
        $this->wechat_total_fee = $charge->charge_amount * 100;
        $this->wechat_spbill_create_ip = $charge->charge_spbill_ip;
        $this->wechat_time_start = Time::now("YmdHis");
        $this->wechat_time_expire = Time::after($charge->charge_express, "YmdHis");
        $this->wechat_trade_type = "APP";
    }

    public function pay(){
        $wechat_sdk = new \common\components\Wechat($this->wechatCharge->chargeOperation->operationChannel);
        $orderMap = $wechat_sdk->getOrderMap($this);
        return $orderMap;
    }

    public function query(){
        if (in_array($this->wechat_trade_state, ["", self::WECHAT_STATE_NOTPAY, self::WECHAT_STATE_USERPAYING])) {
            $wechat_sdk = new \common\components\Wechat($this->wechatCharge->chargeOperation->operationChannel);
            $wechat_sdk->queryTrade($this);
        }
        $this->wechatCharge->updateStatus();
        return true;
    }

    public function close(){
        if(in_array($this->wechat_trade_state, ["", self::WECHAT_STATE_NOTPAY, self::WECHAT_STATE_USERPAYING])){
            $wechat_sdk = new \common\components\Wechat($this->wechatCharge->chargeOperation->operationChannel);
            return $wechat_sdk->close($this);
        }
        return false;
    }

    public function updateStatus($result)
    {
        $this->wechat_transaction_id = isset($result['transaction_id'])?$result['transaction_id']:null;
        $this->wechat_trade_state = isset($result['trade_state'])?$result['trade_state']:null;
        $this->wechat_openid = isset($result['openid'])?$result['openid']:null;
        $this->wechat_bank_type = isset($result['bank_type'])?$result['bank_type']:null;
        $this->wechat_cash_fee = isset($result['cash_fee'])?$result['cash_fee']:null;
        $this->wechat_time_end = isset($result['time_end'])?$result['time_end']:null;
        $this->wechat_response = serialize($result);

        if ($this->update()) {
            $this->wechatCharge->updateStatus();
        }
    }

    //=======
    //next is find function
    public static function findByOutTradeNo($trade_no){
        return static::find()
            ->where(['wechat_out_trade_no' => $trade_no])
            ->one();
    }
    //=======
    //next is fk function
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWechatCharge()
    {
        return $this->hasOne(Charge::className(), ['charge_id' => 'wechat_charge_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWechatRefunds()
    {
        return $this->hasMany(WechatRefund::className(), ['wechat_refund_wechat_id' => 'wechat_id']);
    }
}
