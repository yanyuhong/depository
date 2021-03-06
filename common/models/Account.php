<?php

namespace common\models;

use common\tools\Time;
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
 * @property Charge[] $charges
 * @property Transfer[] $transfers
 * @property Transfer[] $transfers0
 * @property Withdraw[] $withdraws
 */
class Account extends \yii\db\ActiveRecord
{

    const ACCOUNT_TYPE_COMMON = 1; //帐户类型:普通帐户

    const ACCOUNT_STATUS_NORMAL = 1; //帐户状态:正常

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
    //=====================
    //next is model function
    public function initNew($channel_id, $account_key)
    {
        $this->account_channel_id = $channel_id;
        $this->account_key = $account_key;
        $this->account_type = self::ACCOUNT_TYPE_COMMON;
        $this->account_status = self::ACCOUNT_STATUS_NORMAL;
        $this->account_created_at = Time::now();
    }

    public function addAmount($operation, $amount)
    {
        $account_log = new AccountLog();
        $account_log->initNew($this->account_id, $operation, AccountLog::ACCOUNT_LOG_TYPE_INTO, $amount, $this->account_amount);
        $account_log->save();
        $this->account_amount = $account_log->account_log_changed_amount;
        $this->save();
        return true;
    }

    public function freezeAmount($operation, $amount)
    {
        if ($this->account_amount - $this->account_freeze_amount < $amount) return false;
        $account_log = new AccountLog();
        $account_log->initNew($this->account_id, $operation, AccountLog::ACCOUNT_LOG_TYPE_FREEZE, $amount, $this->account_amount);
        $account_log->save();
        $this->account_freeze_amount += $amount;
        $this->save();
        return true;
    }

    public function thawAmount($operation, $amount)
    {
        if ($this->account_freeze_amount < $amount) return false;
        $account_log = new AccountLog();
        $account_log->initNew($this->account_id, $operation, AccountLog::ACCOUNT_LOG_TYPE_FREEZE, -$amount, $this->account_amount);
        $account_log->save();
        $this->account_freeze_amount -= $amount;
        $this->save();
        return true;
    }

    public function outAmount($operation, $amount)
    {
        if ($this->account_freeze_amount < $amount) return false;
        $account_log = new AccountLog();
        $account_log->initNew($this->account_id, $operation, AccountLog::ACCOUNT_LOG_TYPE_OUT, -$amount, $this->account_amount);
        $account_log->save();
        $this->account_freeze_amount -= $amount;
        $this->account_amount = $account_log->account_log_changed_amount;
        $this->save();
        return true;
    }


    //==================
    //next is find function
    public static function findByChannelKey($channel_id, $account_key)
    {
        return static::find()
            ->where([
                "account_channel_id" => $channel_id,
                "account_key" => $account_key,
            ])->one();
    }

    //=======
    //next is fk function
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharges()
    {
        return $this->hasMany(Charge::className(), ['charge_account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransfers()
    {
        return $this->hasMany(Transfer::className(), ['transfer_out_account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransfers0()
    {
        return $this->hasMany(Transfer::className(), ['transfer_into_account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdraws()
    {
        return $this->hasMany(Withdraw::className(), ['withdraw_account_id' => 'account_id']);
    }
}
