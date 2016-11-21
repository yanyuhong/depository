<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property integer $account_id
 * @property integer $account_channel_id
 * @property string $account_key
 * @property integer $account_type
 * @property integer $account_status
 * @property string $account_amount
 * @property string $account_freeze_amount
 * @property string $account_created_at
 * @property string $account_updated_at
 *
 * @property Channel $accountChannel
 * @property AccountLog[] $accountLogs
 * @property Card[] $cards
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_channel_id', 'account_key'], 'required'],
            [['account_channel_id', 'account_type', 'account_status'], 'integer'],
            [['account_amount', 'account_freeze_amount'], 'number'],
            [['account_created_at', 'account_updated_at'], 'safe'],
            [['account_key'], 'string', 'max' => 64],
            [['account_channel_id', 'account_key'], 'unique', 'targetAttribute' => ['account_channel_id', 'account_key'], 'message' => 'The combination of Account Channel ID and Account Key has already been taken.'],
            [['account_channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['account_channel_id' => 'channel_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'account_channel_id' => 'Account Channel ID',
            'account_key' => 'Account Key',
            'account_type' => 'Account Type',
            'account_status' => 'Account Status',
            'account_amount' => 'Account Amount',
            'account_freeze_amount' => 'Account Freeze Amount',
            'account_created_at' => 'Account Created At',
            'account_updated_at' => 'Account Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountChannel()
    {
        return $this->hasOne(Channel::className(), ['channel_id' => 'account_channel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountLogs()
    {
        return $this->hasMany(AccountLog::className(), ['account_log_account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Card::className(), ['card_account_id' => 'account_id']);
    }
}
