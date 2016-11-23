<?php
/**
 * Created by PhpStorm.
 * User: yyh
 * Date: 2016/8/22
 * Time: 17:09
 */

namespace api_biz\models;

use common\components\validator\IdnumValidator;
use common\models\Account;
use common\tools\Time;
use Yii;
use yii\base\Model;

class AccountForm extends Account
{
    public $account;
    public $card;
    public $mobile;
    public $idNum;
    public $name;
    public $bank;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'card', 'mobile', 'idNum', 'name', 'bank'], 'trim'],
            [['account', 'name', 'bank', 'idNum'], 'string'],
            [['card', 'mobile'], 'integer'],
            [['account', 'card', 'mobile', 'idNum', 'name', 'bank'], 'required'],
            [['mobile'], 'match',
                'pattern' => '/^[1][0-9]{10}$/',
                'message' => '手机号不符合规范'
            ],
            ['idNum', IdnumValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'month' => '时间',
            'page' => 'page',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    //===============
    //next is model function
    public function addAccount()
    {
        $channel = Yii::$app->user->identity;
        $account = new Account();
        if (!$account->findByChannelKey($channel->channel_id, $this->account)) {
            $account->initNew($channel->channel_id, $this->account);
            $account->save();
            return true;
        } else {
            return false;
        }
    }
    //=====================
    //next is rule function
    public function accountCreateRules()
    {
        return ['account'];
    }

    public function accountCardBindRules()
    {
        return ['account', 'card', 'mobile', 'idNum', 'name', 'bank'];
    }
    //==================
    //next is search function
    public function searchByKey()
    {
        $channel = Yii::$app->user->identity;
        $query = self::find();
        $query->leftJoin("card", "card_account_id=account_id");
        $query->where(["account_channel_id" => $channel->channel_id]);
        return $query;
    }
    //================
    //next is field function
    public function selectList()
    {
        return [
            "amount" => (string)$this->account_amount,
            "cardList" => $this->copyNum()
        ];
    }

    //====================
    //next is private function
    private function copyNum()
    {
        $card = array();
        $card[] = [
            // "num"=>$this->cards->

        ];
        return $card;
    }

}