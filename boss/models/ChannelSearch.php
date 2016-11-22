<?php

namespace boss\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use boss\models\ChannelForm;

/**
 * ChannelSearch represents the model behind the search form about `boss\models\ChannelForm`.
 */
class ChannelSearch extends ChannelForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id'], 'integer'],
            [['channel_key', 'channel_secret', 'channel_name', 'channel_created_at', 'channel_updated_at'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ChannelForm::find();

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
            'channel_id' => $this->channel_id,
            'channel_created_at' => $this->channel_created_at,
            'channel_updated_at' => $this->channel_updated_at,
        ]);

        $query->andFilterWhere(['like', 'channel_key', $this->channel_key])
            ->andFilterWhere(['like', 'channel_secret', $this->channel_secret])
            ->andFilterWhere(['like', 'channel_name', $this->channel_name]);

        return $dataProvider;
    }
}
