<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "refund".
 *
 * @property integer $refund_id
 * @property integer $refund_operation_id
 * @property integer $refund_charge_id
 * @property string $refund_amount
 * @property integer $refund_status
 *
 * @property AlipayRefund $alipayRefund
 * @property Charge $refundCharge
 * @property Operation $refundOperation
 * @property WechatRefund $wechatRefund
 */
class Refund extends \yii\db\ActiveRecord
{

    const REFUND_STATUS_RECEIVE = 1;//退款状态:接收
    const REFUND_STATUS_PROCESS = 2;//退款状态:处理中
    const REFUND_STATUS_WAIT = 3;//退款状态:渠道余额不足
    const REFUND_STATUS_SUCCESS = 4;//退款状态:成功
    const REFUND_STATUS_FAIL = 5;//退款状态:失败

    public $statusList = [
        self::REFUND_STATUS_RECEIVE => Operation::OPERATION_STATUS_RECEIVE,
        self::REFUND_STATUS_PROCESS => Operation::OPERATION_STATUS_PROCESS,
        self::REFUND_STATUS_WAIT => Operation::OPERATION_STATUS_PROCESS,
        self::REFUND_STATUS_SUCCESS => Operation::OPERATION_STATUS_SUCCESS,
        self::REFUND_STATUS_FAIL => Operation::OPERATION_STATUS_FAIL,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_operation_id', 'refund_charge_id', 'refund_amount', 'refund_status'], 'required'],
            [['refund_operation_id', 'refund_charge_id', 'refund_status'], 'integer'],
            [['refund_amount'], 'number'],
            [['refund_operation_id'], 'unique'],
            [['refund_charge_id'], 'exist', 'skipOnError' => true, 'targetClass' => Charge::className(), 'targetAttribute' => ['refund_charge_id' => 'charge_id']],
            [['refund_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['refund_operation_id' => 'operation_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_id' => 'Refund ID',
            'refund_operation_id' => 'Refund Operation ID',
            'refund_charge_id' => 'Refund Charge ID',
            'refund_amount' => 'Refund Amount',
            'refund_status' => 'Refund Status',
        ];
    }
    //========
    //next is model function
    public function initNew($operation, $charge, $amount)
    {
        $this->refund_operation_id = $operation;
        $this->refund_charge_id = $charge;
        $this->refund_amount = $amount;
        $this->refund_status = self::REFUND_STATUS_RECEIVE;
    }

    public function submitRefund()
    {
        switch ($this->refundCharge->charge_type) {
            case Charge::CHARGE_TYPE_WECHAT_APP:
                $wechat_refund = new WechatRefund();
                $wechat_refund->initNew(
                    $this->refund_id,
                    $this->refundCharge->wechat->wechat_id,
                    $this->refund_amount
                );
                if ($wechat_refund->save()) {
                    return $wechat_refund->refund();
                }
                break;
            case Charge::CHARGE_TYPE_ALIPAY:
                $alipay_refund = new AlipayRefund();
                $alipay_refund->initNew(
                    $this->refund_id,
                    $this->refundCharge->alipay->alipay_id,
                    $this->refund_amount
                );
                if ($alipay_refund->save()) {
                    return $alipay_refund->refund();
                }
                break;
        }
        return false;
    }

    public function query()
    {
        if (in_array($this->refund_status, [self::REFUND_STATUS_RECEIVE, self::REFUND_STATUS_PROCESS])) {
            switch ($this->refundCharge->charge_type) {
                case Charge::CHARGE_TYPE_ALIPAY:

                    break;
                case Charge::CHARGE_TYPE_WECHAT_APP:
                    $this->wechatRefund->query();
                    break;
            }
        }
        $this->refundOperation->updateStatus();
        return true;
    }

    public function updateStatus()
    {
        switch ($this->refundCharge->charge_type) {
            case Charge::CHARGE_TYPE_ALIPAY:
                if ($this->alipayRefund->alipay_refund_sub_code) {
                    $this->refund_status = $this->alipayRefund->statusList[$this->alipayRefund->alipay_refund_sub_code];
                }
                break;
            case Charge::CHARGE_TYPE_WECHAT_APP:
                if ($this->wechatRefund->wechat_refund_status) {
                    $this->refund_status = $this->wechatRefund->statusList[$this->wechatRefund->wechat_refund_status];
                }
                break;
        }

        if ($this->update()) {
            if ($this->refund_status == self::REFUND_STATUS_SUCCESS) {
                $this->refundCharge->chargeAccount->outAmount($this->refund_operation_id, $this->refund_amount);
            }elseif($this->refund_status == self::REFUND_STATUS_FAIL){
                $this->refundCharge->chargeAccount->freezeAmount($this->refund_operation_id, -$this->refund_amount);
            }
            $this->refundOperation->updateStatus();
        }
    }

    public function getFinishTime()
    {
        switch ($this->refundCharge->charge_type) {
            case Charge::CHARGE_TYPE_ALIPAY:
                return $this->alipayRefund->alipay_refund_pay_time;
                break;
            case Charge::CHARGE_TYPE_WECHAT_APP:
                return null;
                break;
        }
        return null;
    }

    public function getMessage()
    {
        switch ($this->refundCharge->charge_type) {
            case Charge::CHARGE_TYPE_ALIPAY:
                if ($this->alipayRefund->alipay_refund_response) {
                    $response = unserialize($this->alipayRefund->alipay_refund_response);
                    return isset($response->sub_msg) ? $response->sub_msg : null;
                }
                break;
            case Charge::CHARGE_TYPE_WECHAT_APP:
                if ($this->wechatRefund->wechat_refund_response) {
                    if (isset(unserialize($this->wechatRefund->wechat_refund_response)['err_code_des'])) {
                        return unserialize($this->wechatRefund->wechat_refund_response)['err_code_des'];
                    }
                }
                break;
        }
        return null;
    }

    //========
    //next is find function
    public static function findByChargeStatus($charge, $status)
    {
        return static::find()
            ->andFilterWhere(['refund_charge_id' => $charge, 'refund_status' => $status]);
    }

    //========
    //next is fk function
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlipayRefund()
    {
        return $this->hasOne(AlipayRefund::className(), ['alipay_refund_refund_id' => 'refund_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundCharge()
    {
        return $this->hasOne(Charge::className(), ['charge_id' => 'refund_charge_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundOperation()
    {
        return $this->hasOne(Operation::className(), ['operation_id' => 'refund_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWechatRefund()
    {
        return $this->hasOne(WechatRefund::className(), ['wechat_refund_refund_id' => 'refund_id']);
    }
}
