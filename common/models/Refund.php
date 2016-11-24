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
 * @property Charge $refundCharge
 * @property Operation $refundOperation
 */
class Refund extends \yii\db\ActiveRecord
{
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
}
