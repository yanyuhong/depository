<?php

namespace common\models;

use common\tools\Encrypt;
use Yii;

/**
 * This is the model class for table "alipay_refund".
 *
 * @property integer $alipay_refund_id
 * @property integer $alipay_refund_refund_id
 * @property integer $alipay_refund_alipay_id
 * @property string $alipay_refund_out_request_no
 * @property string $alipay_refund_amount
 * @property string $alipay_refund_sub_code
 * @property string $alipay_refund_pay_time
 * @property string $alipay_refund_send_back_fee
 * @property string $alipay_refund_response
 *
 * @property Alipay $alipayRefundAlipay
 * @property Refund $alipayRefundRefund
 */
class AlipayRefund extends \yii\db\ActiveRecord
{
    const ALIPAY_REFUND_CODE_WAIT = "WAIT";
    const ALIPAY_REFUND_CODE_SUCCESS = "SUCCESS";
    const ALIPAY_REFUND_CODE_FAIL = "FAIL";

    public $statusList = [
        self::ALIPAY_REFUND_CODE_WAIT => Refund::REFUND_STATUS_WAIT,
        self::ALIPAY_REFUND_CODE_SUCCESS => Refund::REFUND_STATUS_SUCCESS,
        self::ALIPAY_REFUND_CODE_FAIL => Refund::REFUND_STATUS_FAIL
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alipay_refund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alipay_refund_refund_id', 'alipay_refund_alipay_id', 'alipay_refund_out_request_no', 'alipay_refund_amount'], 'required'],
            [['alipay_refund_refund_id', 'alipay_refund_alipay_id'], 'integer'],
            [['alipay_refund_amount', 'alipay_refund_send_back_fee'], 'number'],
            [['alipay_refund_pay_time'], 'safe'],
            [['alipay_refund_response'], 'string'],
            [['alipay_refund_out_request_no', 'alipay_refund_sub_code'], 'string', 'max' => 64],
            [['alipay_refund_out_request_no'], 'unique'],
            [['alipay_refund_refund_id'], 'unique'],
            [['alipay_refund_alipay_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alipay::className(), 'targetAttribute' => ['alipay_refund_alipay_id' => 'alipay_id']],
            [['alipay_refund_refund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Refund::className(), 'targetAttribute' => ['alipay_refund_refund_id' => 'refund_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alipay_refund_id' => 'Alipay Refund ID',
            'alipay_refund_refund_id' => 'Alipay Refund Refund ID',
            'alipay_refund_alipay_id' => 'Alipay Refund Alipay ID',
            'alipay_refund_out_request_no' => 'Alipay Refund Out Request No',
            'alipay_refund_amount' => 'Alipay Refund Amount',
            'alipay_refund_sub_code' => 'Alipay Refund Sub Code',
            'alipay_refund_pay_time' => 'Alipay Refund Pay Time',
            'alipay_refund_send_back_fee' => 'Alipay Refund Send Back Fee',
            'alipay_refund_response' => 'Alipay Refund Response',
        ];
    }
    //=======
    //next is model function
    public function initNew($refund, $alipay, $amount)
    {
        $this->alipay_refund_refund_id = $refund;
        $this->alipay_refund_alipay_id = $alipay;
        $this->alipay_refund_out_request_no = Encrypt::md5Str($refund, 'alipayRefund');
        $this->alipay_refund_amount = $amount;
    }

    public function refund()
    {
        $alipay_sdk = new \common\components\Alipay($this->alipayRefundRefund->refundOperation->operationChannel);
        $response = $alipay_sdk->refund($this);
        if ($response) {
            if ($response->code == '10000') {
                if (!isset($response->sub_code) && isset($response->fund_change) && $response->fund_change == 'Y') {
                    $this->alipay_refund_sub_code = self::ALIPAY_REFUND_CODE_SUCCESS;
                } elseif ($response->sub_code == "ACQ.SELLER_BALANCE_NOT_ENOUGH") {
                    $this->alipay_refund_sub_code = self::ALIPAY_REFUND_CODE_WAIT;
                } else {
                    $this->alipay_refund_sub_code = self::ALIPAY_REFUND_CODE_FAIL;
                }
            } else {
                $this->alipay_refund_sub_code = self::ALIPAY_REFUND_CODE_FAIL;
            }
            $this->alipay_refund_pay_time = isset($response->gmt_refund_pay) ? $response->gmt_refund_pay : null;
            $this->alipay_refund_send_back_fee = isset($response->refund_fee) ? $response->refund_fee : null;
            $this->alipay_refund_response = serialize($response);
            if ($this->update()) {
                $this->alipayRefundRefund->updateStatus();
                if ($this->alipay_refund_sub_code != self::ALIPAY_REFUND_CODE_FAIL) {
                    return true;
                }
            }
        }
        return false;
    }

    //========
    //next is fk function
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlipayRefundAlipay()
    {
        return $this->hasOne(Alipay::className(), ['alipay_id' => 'alipay_refund_alipay_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlipayRefundRefund()
    {
        return $this->hasOne(Refund::className(), ['refund_id' => 'alipay_refund_refund_id']);
    }
}
