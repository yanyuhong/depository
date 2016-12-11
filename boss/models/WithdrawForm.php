<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/12/9
 * Time: 下午4:44
 */

namespace boss\models;

use common\models\Withdraw;

class WithdrawForm extends Withdraw
{
    public static $statusTextList = [
        self::WITHDRAW_STATUS_RECEIVE => "待处理",
        self::WITHDRAW_STATUS_PROCESS => "银行处理中",
        self::WITHDRAW_STATUS_SUCCESS => "完成",
        self::WITHDRAW_STATUS_FAIL => "打款失败",
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'withdraw_amount' => '金额',
            'withdraw_status' => '状态',
        ];
    }

    public function getStatusText()
    {
        return self::$statusTextList[$this->withdraw_status];
    }
}