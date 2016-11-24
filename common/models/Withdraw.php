<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property integer $withdraw_id
 * @property integer $withdraw_operation_id
 * @property integer $withdraw_account_id
 * @property integer $withdraw_card_id
 * @property string $withdraw_amount
 * @property integer $withdraw_status
 *
 * @property Card $withdrawCard
 * @property Operation $withdrawOperation
 * @property Account $withdrawAccount
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['withdraw_operation_id', 'withdraw_account_id', 'withdraw_card_id', 'withdraw_amount', 'withdraw_status'], 'required'],
            [['withdraw_operation_id', 'withdraw_account_id', 'withdraw_card_id', 'withdraw_status'], 'integer'],
            [['withdraw_amount'], 'number'],
            [['withdraw_operation_id'], 'unique'],
            [['withdraw_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['withdraw_account_id' => 'account_id']],
            [['withdraw_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Card::className(), 'targetAttribute' => ['withdraw_card_id' => 'card_id']],
            [['withdraw_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['withdraw_operation_id' => 'operation_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'withdraw_id' => 'Withdraw ID',
            'withdraw_operation_id' => 'Withdraw Operation ID',
            'withdraw_account_id' => 'Withdraw Account ID',
            'withdraw_card_id' => 'Withdraw Card ID',
            'withdraw_amount' => 'Withdraw Amount',
            'withdraw_status' => 'Withdraw Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdrawCard()
    {
        return $this->hasOne(Card::className(), ['card_id' => 'withdraw_card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdrawOperation()
    {
        return $this->hasOne(Operation::className(), ['operation_id' => 'withdraw_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdrawAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'withdraw_account_id']);
    }
}
