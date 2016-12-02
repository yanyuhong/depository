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
 * @property string $charge_spbill_ip
 *
 * @property Alipay $alipay
 * @property Account $chargeAccount
 * @property Operation $chargeOperation
 * @property Refund[] $refunds
 * @property Wechat $wechat
 */
class Charge extends \yii\db\ActiveRecord
{
    const CHARGE_GOODS_TYPE_VIRTUAL = 1; //商品类型:虚拟商品
    const CHARGE_GOODS_TYPE_ACTUAL = 2; //商品类型:实物商品

    const CHARGE_TYPE_WECHAT_APP = 1;//支付方式:微信app
    const CHARGE_TYPE_ALIPAY = 3;//支付方式:支付宝

    const CHARGE_STATUS_RECEIVE = 1;//充值状态:接收
    const CHARGE_STATUS_WAIT = 2;//充值状态:等待支付
    const CHARGE_STATUS_SUCCESS = 3;//充值状态:成功
    const CHARGE_STATUS_CLOSE = 4;//充值状态:关闭

    public static $goodsTypeList = [
        self::CHARGE_GOODS_TYPE_VIRTUAL, self::CHARGE_GOODS_TYPE_ACTUAL
    ];

    public $statusList = [
        self::CHARGE_STATUS_RECEIVE => Operation::OPERATION_STATUS_RECEIVE,
        self::CHARGE_STATUS_WAIT => Operation::OPERATION_STATUS_PROCESS,
        self::CHARGE_STATUS_SUCCESS => Operation::OPERATION_STATUS_SUCCESS,
        self::CHARGE_STATUS_CLOSE => Operation::OPERATION_STATUS_FAIL,
    ];

    public static $paymentList = [
        "wechat" => [
            'type' => 1,
            'name' => "微信app",
        ],
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

    public function rules()
    {
        return [
            [['charge_operation_id', 'charge_account_id', 'charge_amount', 'charge_title', 'charge_detail', 'charge_goods_type', 'charge_express', 'charge_express_time'], 'required'],
            [['charge_operation_id', 'charge_account_id', 'charge_type', 'charge_status', 'charge_goods_type', 'charge_express'], 'integer'],
            [['charge_amount'], 'number'],
            [['charge_express_time'], 'safe'],
            [['charge_title', 'charge_detail'], 'string', 'max' => 255],
            [['charge_spbill_ip'], 'string', 'max' => 16],
            [['charge_operation_id'], 'unique'],
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
            'charge_spbill_ip' => 'Charge Spbill Ip',
        ];
    }

    //=======
    //next is model function
    public function initNew($operation, $account, $type, $amount, $title, $detail, $goodsType, $express, $spbillIp)
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
        $this->charge_spbill_ip = $spbillIp;
    }

    public function getPayData()
    {
        switch ($this->charge_type) {
            case self::CHARGE_TYPE_WECHAT_APP:
                $wechat = new Wechat();
                $wechat->initNew($this);
                if ($wechat->save()) {
                    $orderMap = $wechat->pay();
                    return $orderMap;
                }
                break;
            case self::CHARGE_TYPE_ALIPAY:
                $alipay = new Alipay();
                $alipay->initNew($this);
                if ($alipay->save()) {
                    $orderString = $alipay->pay();
                    return (string)$orderString;
                }
                break;
        }
        return false;
    }

    public function query()
    {
        if (in_array($this->charge_status, [self::CHARGE_STATUS_RECEIVE, self::CHARGE_STATUS_WAIT])) {
            switch ($this->charge_type) {
                case self::CHARGE_TYPE_ALIPAY:
                    $this->alipay->query();
                    break;
                case self::CHARGE_TYPE_WECHAT_APP:
                    $this->wechat->query();
                    break;
            }
        }
        $this->chargeOperation->updateStatus();
        return true;
    }

    public function updateStatus()
    {
        switch ($this->charge_type) {
            case self::CHARGE_TYPE_ALIPAY:
                if ($this->alipay->alipay_trade_status) {
                    $this->charge_status = $this->alipay->statusList[$this->alipay->alipay_trade_status];
                }
                break;
            case self::CHARGE_TYPE_WECHAT_APP:
                if ($this->wechat->wechat_trade_state) {
                    $this->charge_status = $this->wechat->stateList[$this->wechat->wechat_trade_state];
                }
                break;
        }

        if ($this->update()) {
            if ($this->charge_status == self::CHARGE_STATUS_SUCCESS) {
                $this->chargeAccount->addAmount($this->charge_operation_id, $this->charge_amount);
            }
            $this->chargeOperation->updateStatus();
        }
    }

    public function close()
    {
        if (in_array($this->charge_status, [self::CHARGE_STATUS_RECEIVE, self::CHARGE_STATUS_WAIT])) {
            switch ($this->charge_type) {
                case self::CHARGE_TYPE_WECHAT_APP:
                    return $this->wechat->close();
                    break;
                case self::CHARGE_TYPE_ALIPAY:
                    return $this->alipay->close();
                    break;
            }
        }
        return false;
    }

    public function getFinishTime()
    {
        switch ($this->charge_type) {
            case self::CHARGE_TYPE_ALIPAY:
                return $this->alipay->alipay_send_pay_date;
                break;
            case self::CHARGE_TYPE_WECHAT_APP:
                if ($this->wechat->wechat_time_end) {
                    return Time::format($this->wechat->wechat_time_end);
                }
                break;
        }
        return null;
    }

    public function getMessage()
    {
        switch ($this->charge_type) {
            case self::CHARGE_TYPE_ALIPAY:
                if ($this->alipay->alipay_response) {
                    $response = unserialize($this->alipay->alipay_response);
                    return isset($response->sub_msg) ? $response->sub_msg : null;
                }
                break;
            case self::CHARGE_TYPE_WECHAT_APP:
                if ($this->wechat->wechat_response) {
                    if (isset(unserialize($this->wechat->wechat_response)['trade_state_desc'])) {
                        return unserialize($this->wechat->wechat_response)['trade_state_desc'];
                    }
                }
                break;
        }
        return null;
    }

    public function getRefundAmount()
    {
        $amount = Refund::findByChargeStatus($this->charge_id,
            [Refund::REFUND_STATUS_RECEIVE, Refund::REFUND_STATUS_PROCESS, Refund::REFUND_STATUS_WAIT, Refund::REFUND_STATUS_SUCCESS]
        )->sum('refund_amount');
        return $amount;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWechat()
    {
        return $this->hasOne(Wechat::className(), ['wechat_charge_id' => 'charge_id']);
    }
}
