<?php

namespace common\models;

use common\tools\Time;
use Yii;

/**
 * This is the model class for table "account_log".
 *
 * @property integer $account_log_id
 * @property integer $account_log_account_id
 * @property integer $account_log_operation_id
 * @property integer $account_log_type
 * @property string $account_log_amount
 * @property string $account_log_original_amount
 * @property string $account_log_changed_amount
 * @property string $account_log_created_at
 * @property string $account_log_updated_at
 *
 * @property Account $accountLogAccount
 * @property Operation $accountLogOperation
 */
class AccountLog extends \yii\db\ActiveRecord
{

    const ACCOUNT_LOG_TYPE_INTO = 1;//资金变动类型:转入
    const ACCOUNT_LOG_TYPE_OUT = 2;//资金变动类型:转出
    const ACCOUNT_LOG_TYPE_FREEZE = 3;//资金变动类型:冻结

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_log_account_id', 'account_log_operation_id', 'account_log_amount'], 'required'],
            [['account_log_account_id', 'account_log_operation_id', 'account_log_type'], 'integer'],
            [['account_log_amount', 'account_log_original_amount', 'account_log_changed_amount'], 'number'],
            [['account_log_created_at', 'account_log_updated_at'], 'safe'],
            [['account_log_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_log_account_id' => 'account_id']],
            [['account_log_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['account_log_operation_id' => 'operation_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_log_id' => 'Account Log ID',
            'account_log_account_id' => 'Account Log Account ID',
            'account_log_operation_id' => 'Account Log Operation ID',
            'account_log_type' => 'Account Log Type',
            'account_log_amount' => 'Account Log Amount',
            'account_log_original_amount' => 'Account Log Original Amount',
            'account_log_changed_amount' => 'Account Log Changed Amount',
            'account_log_created_at' => 'Account Log Created At',
            'account_log_updated_at' => 'Account Log Updated At',
        ];
    }

    //===========
    //next is model function
    public function initNew($account, $operation, $type, $amount, $original)
    {
        $this->account_log_account_id = $account;
        $this->account_log_operation_id = $operation;
        $this->account_log_type = $type;
        $this->account_log_amount = $amount;
        $this->account_log_original_amount = $original;
        $this->account_log_changed_amount = $original + $amount;
        if ($type == self::ACCOUNT_LOG_TYPE_FREEZE) {
            $this->account_log_changed_amount = $original;
        }
        $this->account_log_created_at = Time::now();
    }

    //=============
    //next is fk function
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountLogAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'account_log_account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountLogOperation()
    {
        return $this->hasOne(Operation::className(), ['operation_id' => 'account_log_operation_id']);
    }
}
