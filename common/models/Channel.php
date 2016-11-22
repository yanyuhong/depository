<?php

namespace common\models;

use common\tools\Encrypt;
use common\tools\Time;
use Yii;
use yii\web\IdentityInterface;

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
class Channel extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['channel_key'], 'unique'],
            [['channel_name'], 'unique'],
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

    //==========
    //next is model function

    public function initNew($name){
        $this->channel_name = $name;
        $this->channel_key = Encrypt::getNum($name);
        $this->channel_secret = Encrypt::md5Str($name, 'channel');
        $this->channel_created_at = Time::now();
    }

    //==========
    //next is fk function
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

    //===========
    //next is IdentityInterface function
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['channel_id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $key = explode(' ', $token)[0];
        $secret = explode(' ', $token)[1];

        return static::find()->where(['channel_key' => $key, 'channel_secret' => $secret])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->channel_secret;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
