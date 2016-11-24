<?php

namespace common\models;

use common\tools\Time;
use Yii;

/**
 * This is the model class for table "charge".
 *
 * @property integer $charge_id
 * @property integer $charge_operation_id
 * @property integer $charge_account_id
 * @property integer $charge_type
 * @property integer $charge_status
 * @property string $charge_amount
 * @property string $charge_title
 * @property string $charge_detail
 * @property integer $charge_goods_type
 * @property integer $charge_express
 * @property string $charge_express_time
 *
 * @property Alipay $alipay
 * @property Account $chargeAccount
 * @property Operation $chargeOperation
 * @property Refund[] $refunds
 */
class Charge extends \yii\db\ActiveRecord
{
    const CHARGE_GOODS_TYPE_VIRTUAL = 1; //商品类型:虚拟商品
    const CHARGE_GOODS_TYPE_ACTUAL = 2; //商品类型:实物商品

    const CHARGE_TYPE_ALIPAY = 3;//支付方式:支付宝app

    public static $goodsTypeList = [
        self::CHARGE_GOODS_TYPE_VIRTUAL, self::CHARGE_GOODS_TYPE_ACTUAL
    ];

    public static $paymentList = [
        "alipay" => [
            'type' => 3,
            'name' => "支付宝",
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charge_operation_id', 'charge_account_id', 'charge_amount', 'charge_title', 'charge_detail', 'charge_goods_type', 'charge_express', 'charge_express_time'], 'required'],
            [['charge_operation_id', 'charge_account_id', 'charge_type', 'charge_status', 'charge_goods_type', 'charge_express'], 'integer'],
            [['charge_amount'], 'number'],
            [['charge_express_time'], 'safe'],
            [['charge_title', 'charge_detail'], 'string', 'max' => 255],
            [['charge_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['charge_account_id' => 'account_id']],
            [['charge_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['charge_operation_id' => 'operation_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'charge_id' => 'Charge ID',
            'charge_operation_id' => 'Charge Operation ID',
            'charge_account_id' => 'Charge Account ID',
            'charge_type' => 'Charge Type',
            'charge_status' => 'Charge Status',
            'charge_amount' => 'Charge Amount',
            'charge_title' => 'Charge Title',
            'charge_detail' => 'Charge Detail',
            'charge_goods_type' => 'Charge Goods Type',
            'charge_express' => 'Charge Express',
            'charge_express_time' => 'Charge Express Time',
        ];
    }

    //=======
    //next is model function
    public function initNew($operation, $account, $type, $amount, $title, $detail, $goodsType, $express)
    {
        $this->charge_operation_id = $operation;
        $this->charge_account_id = $account;
        $this->charge_type = $type;
        $this->charge_amount = $amount;
        $this->charge_title = $title;
        $this->charge_detail = $detail;
        $this->charge_goods_type = $goodsType;
        $this->charge_express = $express;
        $this->charge_express_time = Time::after($express);
    }

    public function getPayData(){
        switch ($this->charge_type){
            case self::CHARGE_TYPE_ALIPAY:
                $alipay = new Alipay();
                $alipay->initNew($this);
                if($alipay->save()){
                    $orderString = $alipay->pay();
                    return [
                        "orderString" => (string)$orderString
                    ];
                }
                break;
        }
        return false;
    }

    //=======
    //next is fk
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlipay()
    {
        return $this->hasOne(Alipay::className(), ['alipay_charge_id' => 'charge_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChargeOperation()
    {
        return $this->hasOne(Operation::className(), ['operation_id' => 'charge_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChargeAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'charge_account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefunds()
    {
        return $this->hasMany(Refund::className(), ['refund_charge_id' => 'charge_id']);
    }
}
