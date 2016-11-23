<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/23
 * Time: 下午2:20
 */
namespace api_biz\models;

use common\models\Account;
use common\models\Operation;

use Yii;

class OperationForm extends Operation
{
    public $num;
    public $account;
    public $amount;
    public $payment;

    public $operationModel;
    public $accountModel;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num', 'account', 'amount', 'payment'], 'trim'],
            [['num', 'account', 'amount', 'payment'], 'required'],
            [['num', 'account'], 'string', 'max' => 64],
            [['amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'num' => '流水号',
            'account' => '帐户号',
            'amount' => '金额',
            'payment' => '支付方式'
        ];
    }

    //===========
    //next is rule function
    public function operationQueryRules()
    {
        return ['num'];
    }

    public function operationChargeRules()
    {
        return ['num', 'account', 'amount', 'payment'];
    }

    //==========
    //next is model function
    public function doCharge()
    {

    }

    public function checkNum()
    {
        $channel = Yii::$app->user->identity;
        $operation = self::findByChannelNum($channel->channel_id, $this->num);
        $this->operationModel = $operation;
    }

    public function checkAccount()
    {
        $channel = Yii::$app->user->identity;
        $account = Account::findByChannelKey($channel->channel_id, $this->account);
        $this->accountModel = $account;
    }

    //===========
    //next is search function

    public function searchByNum()
    {
        $channel = Yii::$app->user->identity;
        $operation = self::findByChannelNum($channel->channel_id, $this->num);
        $new = $operation ? new OperationForm($operation) : null;

        if ($new) {
            $new->load(['OperationForm' => (array)$this]);
        }

        return $new;
    }

    //=========
    //next is field function

    public function queryFields()
    {
        return [
            'status' => $this->copyStatus(),
            'type' => $this->copyType(),
            'time' => $this->copyUpdateTime(),
            'message' => $this->copyMessage(),
        ];
    }

    public function chargeFields(){
        return [
            'status' => $this->copyStatus(),
            'payData' => $this->copyPayData(),
        ];
    }

    //=========
    //next is private function
    private function copyStatus()
    {
        return (string)$this->operation_status;
    }

    private function copyType()
    {
        return (string)$this->operation_type;
    }

    private function copyUpdateTime()
    {
        return (string)$this->operation_updated_at;
    }

    private function copyMessage()
    {
        return (string)$this->operation_message;
    }

    private function copyPayData(){
        return (object)[];
    }


}