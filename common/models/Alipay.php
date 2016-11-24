<?php

namespace common\models;

use common\tools\Encrypt;
use Yii;

/**
 * This is the model class for table "alipay".
 *
 * @property integer $alipay_id
 * @property integer $alipay_charge_id
 * @property string $alipay_out_trade_no
 * @property string $alipay_body
 * @property string $alipay_subject
 * @property string $alipay_timeout_express
 * @property string $alipay_total_amount
 * @property string $alipay_goods_type
 * @property string $alipay_trade_no
 * @property string $alipay_buyer_logon_id
 * @property string $alipay_trade_status
 * @property string $alipay_receipt_amount
 * @property string $alipay_buyer_pay_amount
 * @property string $alipay_point_amount
 * @property string $alipay_invoice_amount
 * @property string $alipay_send_pay_date
 * @property string $alipay_response
 * @property string $alipay_updated_at
 *
 * @property Charge $alipayCharge
 */
class Alipay extends \yii\db\ActiveRecord
{

    private $goodsTypeList = [
        Charge::CHARGE_GOODS_TYPE_VIRTUAL => '0',
        Charge::CHARGE_GOODS_TYPE_ACTUAL => '1',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alipay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alipay_charge_id', 'alipay_out_trade_no', 'alipay_subject', 'alipay_total_amount'], 'required'],
            [['alipay_charge_id'], 'integer'],
            [['alipay_total_amount', 'alipay_receipt_amount', 'alipay_buyer_pay_amount', 'alipay_point_amount', 'alipay_invoice_amount'], 'number'],
            [['alipay_send_pay_date', 'alipay_updated_at'], 'safe'],
            [['alipay_response'], 'string'],
            [['alipay_out_trade_no', 'alipay_trade_no'], 'string', 'max' => 64],
            [['alipay_body', 'alipay_buyer_logon_id'], 'string', 'max' => 128],
            [['alipay_subject'], 'string', 'max' => 255],
            [['alipay_timeout_express'], 'string', 'max' => 8],
            [['alipay_goods_type'], 'string', 'max' => 2],
            [['alipay_trade_status'], 'string', 'max' => 32],
            [['alipay_charge_id'], 'unique'],
            [['alipay_out_trade_no'], 'unique'],
            [['alipay_charge_id'], 'exist', 'skipOnError' => true, 'targetClass' => Charge::className(), 'targetAttribute' => ['alipay_charge_id' => 'charge_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alipay_id' => 'Alipay ID',
            'alipay_charge_id' => 'Alipay Charge ID',
            'alipay_out_trade_no' => 'Alipay Out Trade No',
            'alipay_body' => 'Alipay Body',
            'alipay_subject' => 'Alipay Subject',
            'alipay_timeout_express' => 'Alipay Timeout Express',
            'alipay_total_amount' => 'Alipay Total Amount',
            'alipay_goods_type' => 'Alipay Goods Type',
            'alipay_trade_no' => 'Alipay Trade No',
            'alipay_buyer_logon_id' => 'Alipay Buyer Logon ID',
            'alipay_trade_status' => 'Alipay Trade Status',
            'alipay_receipt_amount' => 'Alipay Receipt Amount',
            'alipay_buyer_pay_amount' => 'Alipay Buyer Pay Amount',
            'alipay_point_amount' => 'Alipay Point Amount',
            'alipay_invoice_amount' => 'Alipay Invoice Amount',
            'alipay_send_pay_date' => 'Alipay Send Pay Date',
            'alipay_response' => 'Alipay Response',
            'alipay_updated_at' => 'Alipay Updated At',
        ];
    }

    //========
    //next is model function

    /**
     * @param $charge Charge
     */
    public function initNew($charge){
        $this->alipay_charge_id = $charge->charge_id;
        $this->alipay_out_trade_no = Encrypt::md5Str($charge->charge_id, 'Alipay');
        $this->alipay_body = $charge->charge_detail;
        $this->alipay_subject = $charge->charge_title;
        $this->alipay_timeout_express = ((int)(($charge->charge_express + 30)/60)) . 'm';
        $this->alipay_total_amount = $charge->charge_amount;
        $this->alipay_goods_type = $this->goodsTypeList[$charge->charge_goods_type];
    }

    public function pay(){
        $alipay_sdk = new \common\components\Alipay($this->alipayCharge->chargeOperation->operationChannel);
        $orderString = $alipay_sdk->getOrderString($this);
        return $orderString;
    }

    //========
    //next is fk function

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlipayCharge()
    {
        return $this->hasOne(Charge::className(), ['charge_id' => 'alipay_charge_id']);
    }
}
