<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property integer $card_id
 * @property integer $card_account_id
 * @property integer $card_bank_id
 * @property string $card_num
 * @property string $card_name
 * @property string $card_id_num
 * @property string $card_mobile
 * @property integer $card_status
 * @property string $card_created_at
 * @property string $card_updated_at
 *
 * @property Account $cardAccount
 * @property Bank $cardBank
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_account_id', 'card_bank_id', 'card_num', 'card_name'], 'required'],
            [['card_account_id', 'card_bank_id', 'card_status'], 'integer'],
            [['card_created_at', 'card_updated_at'], 'safe'],
            [['card_num', 'card_name', 'card_id_num'], 'string', 'max' => 32],
            [['card_mobile'], 'string', 'max' => 16],
            [['card_account_id', 'card_num'], 'unique', 'targetAttribute' => ['card_account_id', 'card_num'], 'message' => 'The combination of Card Account ID and Card Num has already been taken.'],
            [['card_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['card_account_id' => 'account_id']],
            [['card_bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['card_bank_id' => 'bank_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_id' => 'Card ID',
            'card_account_id' => 'Card Account ID',
            'card_bank_id' => 'Card Bank ID',
            'card_num' => 'Card Num',
            'card_name' => 'Card Name',
            'card_id_num' => 'Card Id Num',
            'card_mobile' => 'Card Mobile',
            'card_status' => 'Card Status',
            'card_created_at' => 'Card Created At',
            'card_updated_at' => 'Card Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'card_account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardBank()
    {
        return $this->hasOne(Bank::className(), ['bank_id' => 'card_bank_id']);
    }
}
