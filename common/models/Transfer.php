<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property integer $transfer_id
 * @property integer $transfer_operation_id
 * @property integer $transfer_out_account_id
 * @property integer $transfer_into_account_id
 * @property integer $transfer_type
 * @property integer $transfer_status
 * @property string $transfer_amount
 *
 * @property Operation $transferOperation
 * @property Account $transferOutAccount
 * @property Account $transferIntoAccount
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transfer_operation_id', 'transfer_out_account_id', 'transfer_into_account_id', 'transfer_type', 'transfer_amount'], 'required'],
            [['transfer_operation_id', 'transfer_out_account_id', 'transfer_into_account_id', 'transfer_type', 'transfer_status'], 'integer'],
            [['transfer_amount'], 'number'],
            [['transfer_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['transfer_operation_id' => 'operation_id']],
            [['transfer_out_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['transfer_out_account_id' => 'account_id']],
            [['transfer_into_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['transfer_into_account_id' => 'account_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transfer_id' => 'Transfer ID',
            'transfer_operation_id' => 'Transfer Operation ID',
            'transfer_out_account_id' => 'Transfer Out Account ID',
            'transfer_into_account_id' => 'Transfer Into Account ID',
            'transfer_type' => 'Transfer Type',
            'transfer_status' => 'Transfer Status',
            'transfer_amount' => 'Transfer Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferOperation()
    {
        return $this->hasOne(Operation::className(), ['operation_id' => 'transfer_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferOutAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'transfer_out_account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferIntoAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'transfer_into_account_id']);
    }
}
