<?php

namespace boss\models;

use common\models\Bank;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use boss\models\WithdrawForm;

/**
 * WithdrawSearch represents the model behind the search form about `boss\models\WithdrawForm`.
 */
class WithdrawSearch extends WithdrawForm
{
    public $serial_num;
    public $amount_min;
    public $amount_max;
    public $bank_num;
    public $card_name;
    public $card_num;
    public $created_at_start;
    public $created_at_end;
    public $finished_at_start;
    public $finished_at_end;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serial_num', 'bank_num', 'card_name', 'card_num', 'created_at_start', 'created_at_end', 'finished_at_start', 'finished_at_end'], 'string'],
            [['withdraw_status'], 'integer'],
            [['withdraw_amount', 'amount_min', 'amount_max'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'serial_num' => '流水号',
            'amount_min' => '打款金额(起)',
            'amount_max' => '打款金额(止)',
            'bank_num' => '收款银行',
            'card_name' => '收款人',
            'card_num' => '收款银行卡号',
            'created_at_start' => '提交时间(起)',
            'created_at_end' => '提交时间(止)',
            'finished_at_start' => '完成时间(起)',
            'finished_at_end' => '完成时间(止)',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WithdrawForm::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'withdraw_status' => $this->withdraw_status,
        ]);
        $query->andFilterWhere(['>=', 'withdraw_amount', $this->amount_min]);
        $query->andFilterWhere(['<=', 'withdraw_amount', $this->amount_max]);

        if ($this->bank_num || $this->card_name || $this->card_num) {
            $query->leftJoin('card', 'card_id=withdraw_card_id')
                ->leftJoin('bank', 'bank_id=card_bank_id');
            $query->andFilterWhere([
                'bank_num' => $this->bank_num,
                'card_num' => $this->card_num,
            ]);

            $query->andFilterWhere(['like', 'card_name', $this->card_name]);
        }

        if ($this->serial_num || $this->created_at_start || $this->created_at_end || $this->finished_at_start || $this->finished_at_end) {
            $query->leftJoin('operation', 'operation_id=withdraw_operation_id');
            $query->andFilterWhere(['operation_serial_num' => $this->serial_num]);
            $query->andFilterWhere(['>=', 'operation_created_at', $this->created_at_start]);
            $query->andFilterWhere(['<=', 'operation_created_at', $this->created_at_end]);
            $query->andFilterWhere(['>=', 'operation_finished_at', $this->finished_at_start]);
            $query->andFilterWhere(['<=', 'operation_finished_at', $this->finished_at_end]);
        }

        $query->orderBy('withdraw_id desc');

        return $dataProvider;
    }

    public static function getBankList()
    {
        $bank_list = array();
        foreach (Bank::find()->each(20) as $bank) {
            $bank_list[$bank->bank_num] = $bank->bank_name;
        }
        return $bank_list;
    }
}
