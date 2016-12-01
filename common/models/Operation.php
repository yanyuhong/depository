<?php

namespace common\models;

use common\tools\Time;
use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property integer $operation_id
 * @property integer $operation_channel_id
 * @property string $operation_serial_num
 * @property integer $operation_type
 * @property integer $operation_status
 * @property string $operation_snapshot
 * @property string $operation_message
 * @property string $operation_created_at
 * @property string $operation_finished_at
 * @property string $operation_updated_at
 *
 * @property AccountLog[] $accountLogs
 * @property Charge $charge
 * @property Channel $operationChannel
 * @property Refund $refund
 * @property Transfer $transfer
 * @property Withdraw $withdraw
 */
class Operation extends \yii\db\ActiveRecord
{

    const OPERATION_TYPE_CHARGE = 1; //交易类型:充值


    const OPERATION_STATUS_RECEIVE = 1; //交易状态:接收
    const OPERATION_STATUS_PROCESS = 2; //交易状态:处理中
    const OPERATION_STATUS_SUCCESS = 3; //交易状态:成功
    const OPERATION_STATUS_FAIL = 4; //交易状态:失败

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_channel_id', 'operation_serial_num', 'operation_type', 'operation_snapshot'], 'required'],
            [['operation_channel_id', 'operation_type', 'operation_status'], 'integer'],
            [['operation_snapshot'], 'string'],
            [['operation_created_at', 'operation_finished_at', 'operation_updated_at'], 'safe'],
            [['operation_serial_num'], 'string', 'max' => 64],
            [['operation_message'], 'string', 'max' => 255],
            [['operation_channel_id', 'operation_serial_num'], 'unique', 'targetAttribute' => ['operation_channel_id', 'operation_serial_num'], 'message' => 'The combination of Operation Channel ID and Operation Serial Num has already been taken.'],
            [['operation_channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['operation_channel_id' => 'channel_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'operation_id' => 'Operation ID',
            'operation_channel_id' => 'Operation Channel ID',
            'operation_serial_num' => 'Operation Serial Num',
            'operation_type' => 'Operation Type',
            'operation_status' => 'Operation Status',
            'operation_snapshot' => 'Operation Snapshot',
            'operation_message' => 'Operation Message',
            'operation_created_at' => 'Operation Created At',
            'operation_finished_at' => 'Operation Finished At',
            'operation_updated_at' => 'Operation Updated At',
        ];
    }

    //=========
    //next is model function
    public function initNew($channel, $num, $type, $snapshot)
    {
        $this->operation_channel_id = $channel;
        $this->operation_serial_num = $num;
        $this->operation_type = $type;
        $this->operation_snapshot = $snapshot;
        $this->operation_status = self::OPERATION_STATUS_RECEIVE;
        $this->operation_created_at = Time::now();
    }

    public function depthQuery()
    {
        if (in_array($this->operation_status, [self::OPERATION_STATUS_RECEIVE, self::OPERATION_STATUS_PROCESS])) {
            switch ($this->operation_type) {
                case self::OPERATION_TYPE_CHARGE:
                    $this->charge->query();
                    break;
            }

        }

        return false;
    }

    public function close(){
        if (in_array($this->operation_status, [self::OPERATION_STATUS_RECEIVE, self::OPERATION_STATUS_PROCESS])) {
            switch ($this->operation_type) {
                case self::OPERATION_TYPE_CHARGE:
                    return $this->charge->close();
                    break;
            }

        }

        return false;
    }

    public function updateStatus()
    {
        switch ($this->operation_type) {
            case self::OPERATION_TYPE_CHARGE:
                if ($this->charge->charge_status) {
                    $this->operation_status = $this->charge->statusList[$this->charge->charge_status];
                    $finishTime = $this->charge->getFinishTime();
                    if ($finishTime) {
                        $this->operation_finished_at = $finishTime;
                    }
                    $this->operation_message = $this->charge->getMessage();
                }
                break;
        }

        if ($this->update()) {
            if (in_array($this->operation_type, [self::OPERATION_STATUS_SUCCESS, self::OPERATION_STATUS_FAIL])) {
                //todo: 回调
            }
        }
    }

    //==========
    //next is find function

    public static function findByChannelNum($channel, $num)
    {
        return static::find()
            ->where(['operation_channel_id' => $channel, 'operation_serial_num' => $num])
            ->one();
    }

    //========
    //next is fk function
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountLogs()
    {
        return $this->hasMany(AccountLog::className(), ['account_log_operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharge()
    {
        return $this->hasOne(Charge::className(), ['charge_operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationChannel()
    {
        return $this->hasOne(Channel::className(), ['channel_id' => 'operation_channel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefund()
    {
        return $this->hasOne(Refund::className(), ['refund_operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransfer()
    {
        return $this->hasOne(Transfer::className(), ['transfer_operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdraw()
    {
        return $this->hasOne(Withdraw::className(), ['withdraw_operation_id' => 'operation_id']);
    }
}
