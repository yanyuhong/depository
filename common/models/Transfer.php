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

    const TRANSFER_TYPE_COMMON = 1;//转账类型:一般转账
    const TRANSFER_TYPE_ALLOWANCE = 2;//转账类型:补贴(无转出帐户)

    const TRANSFER_STATUS_RECEIVE = 1;//状态:接收
    const TRANSFER_STATUS_SUCCESS = 2;//状态:成功
    const TRANSFER_STATUS_FAIL = 3;//状态:失败

    public $statusList = [
        self::TRANSFER_STATUS_RECEIVE => Operation::OPERATION_STATUS_RECEIVE,
        self::TRANSFER_STATUS_SUCCESS => Operation::OPERATION_STATUS_SUCCESS,
        self::TRANSFER_STATUS_FAIL => Operation::OPERATION_STATUS_FAIL
    ];

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
            [['transfer_operation_id', 'transfer_into_account_id', 'transfer_type', 'transfer_amount'], 'required'],
            [['transfer_operation_id', 'transfer_out_account_id', 'transfer_into_account_id', 'transfer_type', 'transfer_status'], 'integer'],
            [['transfer_amount'], 'number'],
            [['transfer_operation_id'], 'unique'],
            [['transfer_out_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['transfer_out_account_id' => 'account_id']],
            [['transfer_into_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['transfer_into_account_id' => 'account_id']],
            [['transfer_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['transfer_operation_id' => 'operation_id']],
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

    //==========
    //next is model function
    public function initNew($operation, $out, $into, $type, $amount)
    {
        $this->transfer_operation_id = $operation;
        $this->transfer_out_account_id = $out;
        $this->transfer_into_account_id = $into;
        $this->transfer_type = $type;
        $this->transfer_amount = $amount;
    }

    public function transfer()
    {
        if ($this->transfer_type == self::TRANSFER_TYPE_COMMON && $this->transferOutAccount) {
            $out = $this->transferOutAccount->outAmount($this->transfer_operation_id, $this->transfer_amount);
            if (!$out) {
                $this->transferOutAccount->thawAmount($this->transfer_operation_id, $this->transfer_amount);
                $this->transfer_status = self::TRANSFER_STATUS_FAIL;
                return $this->endUpdate();
            }
        }
        $into = $this->transferIntoAccount->addAmount($this->transfer_operation_id, $this->transfer_amount);
        if (!$into) {
            if ($this->transfer_type == self::TRANSFER_TYPE_COMMON && $this->transferOutAccount) {
                $this->transferOutAccount->addAmount($this->transfer_operation_id, $this->transfer_amount);
            }
            $this->transfer_status = self::TRANSFER_STATUS_FAIL;
        } else {
            $this->transfer_status = self::TRANSFER_STATUS_SUCCESS;
        }
        return $this->endUpdate();
    }

    public function getFinishTime()
    {
        return "";
    }

    public function getMessage()
    {
        return "";
    }

    private function endUpdate()
    {
        if ($this->update()) {
            $this->transferOperation->updateStatus();
        }

        return true;
    }

    //==========
    //next is fk function
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
