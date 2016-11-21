<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property integer $bank_id
 * @property string $bank_num
 * @property string $bank_name
 *
 * @property Card[] $cards
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_num', 'bank_name'], 'required'],
            [['bank_num'], 'string', 'max' => 16],
            [['bank_name'], 'string', 'max' => 64],
            [['bank_num'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank_id' => 'Bank ID',
            'bank_num' => 'Bank Num',
            'bank_name' => 'Bank Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Card::className(), ['card_bank_id' => 'bank_id']);
    }
}
