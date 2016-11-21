<?php

namespace common\models;

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
 *
 * @property Operation $chargeOperation
 * @property Account $chargeAccount
 * @property Refund[] $refunds
 */
class Charge extends \yii\db\ActiveRecord
{
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
            [['charge_operation_id', 'charge_account_id', 'charge_amount'], 'required'],
            [['charge_operation_id', 'charge_account_id', 'charge_type', 'charge_status'], 'integer'],
            [['charge_amount'], 'number'],
            [['charge_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['charge_operation_id' => 'operation_id']],
            [['charge_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['charge_account_id' => 'account_id']],
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
        ];
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
