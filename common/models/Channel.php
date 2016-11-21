<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $channel_id
 * @property string $channel_key
 * @property string $channel_secret
 * @property string $channel_name
 * @property string $channel_created_at
 * @property string $channel_updated_at
 *
 * @property Account[] $accounts
 * @property Operation[] $operations
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_key', 'channel_secret', 'channel_name'], 'required'],
            [['channel_created_at', 'channel_updated_at'], 'safe'],
            [['channel_key', 'channel_secret'], 'string', 'max' => 64],
            [['channel_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'channel_id' => 'Channel ID',
            'channel_key' => 'Channel Key',
            'channel_secret' => 'Channel Secret',
            'channel_name' => 'Channel Name',
            'channel_created_at' => 'Channel Created At',
            'channel_updated_at' => 'Channel Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['account_channel_id' => 'channel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['operation_channel_id' => 'channel_id']);
    }
}
