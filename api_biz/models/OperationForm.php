<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/23
 * Time: 下午2:20
 */
namespace api_biz\models;

use common\models\Account;
use common\models\Charge;
use common\models\Operation;

use Yii;

class OperationForm extends Operation
{
    public $num;
    public $account;
    public $amount;
    public $payment;
    public $title;
    public $detail;
    public $goodsType;
    public $express;

    public $operationModel;
    public $accountModel;

    public $payData;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num', 'account', 'amount', 'payment', 'title', 'detail', 'goodsType', 'express'], 'trim'],
            [['num', 'account', 'amount', 'payment', 'title', 'detail', 'goodsType', 'express'], 'required'],
            [['num', 'account'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 255],
            [['detail'], 'string', 'max' => 128],
            [['express'], 'integer', 'min' => 60,'max' => 1296000],
            [['amount'], 'number'],
            ['payment', 'in', 'range' => array_keys(Charge::$paymentList)],
            ['goodsType', 'in', 'range' => Charge::$goodsTypeList]
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
            'payment' => '支付方式',
            'title' => '商品标题',
            'detail' => '商品描述',
            'goodsType' => '商品类型',
            'express' => '等待时间',
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
        return ['num', 'account', 'amount', 'payment', 'title', 'detail', 'goodsType', 'express'];
    }

    //==========
    //next is model function
    public function doCharge()
    {
        if ($this->saveThis(self::OPERATION_TYPE_CHARGE)) {
            $charge = new Charge();
            $charge->initNew(
                $this->operationModel->operation_id,
                $this->accountModel->account_id,
                Charge::$paymentList[$this->payment]['type'],
                $this->amount,
                $this->title,
                $this->detail,
                $this->goodsType,
                $this->express
            );
            if ($charge->save()) {
                $this->payData = $charge->getPayData();
                if($this->payData) {
                    return true;
                }
            }
        }

        return false;
    }

    public function check()
    {
        $channel = Yii::$app->user->identity;

        $operation = self::findByChannelNum($channel->channel_id, $this->num);
        $this->operationModel = $operation;

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
            'status' => $this->copyThisStatus(),
            'type' => $this->copyType(),
            'time' => $this->copyUpdateTime(),
            'message' => $this->copyMessage(),
        ];
    }

    public function chargeFields()
    {
        return [
            'status' => $this->copyStatus(),
            'payData' => $this->copyPayData(),
        ];
    }

    //=========
    //next is private function
    private function saveThis($type)
    {
        $channel = Yii::$app->user->identity;
        $snapshot = serialize(Yii::$app->request->post());
        $operation = new Operation();
        $operation->initNew($channel->channel_id, $this->num, $type, $snapshot);
        if ($operation->save()) {
            $this->operationModel = $operation;
            return true;
        }
        return false;
    }

    private function copyStatus()
    {
        if ($this->operationModel->operation_status) {
            return (string)$this->operationModel->operation_status;
        } else {
            return "";
        }
    }

    private function copyThisStatus()
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

    private function copyPayData()
    {
        return $this->payData;
    }


}