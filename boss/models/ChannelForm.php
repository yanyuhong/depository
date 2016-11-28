<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/22
 * Time: 下午2:40
 */

namespace boss\models;


use common\models\Channel;

class ChannelForm extends Channel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_name', 'channel_alipay_appId', 'channel_alipay_rsaPrivateKey' , 'channel_alipay_rsaPublicKey'], 'trim'],
            [['channel_name'], 'required'],
            [['channel_name'], 'string', 'max' => 255],
            [['channel_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'channel_id' => 'ID',
            'channel_key' => '渠道KEY',
            'channel_secret' => '密钥',
            'channel_name' => '渠道名称',
            'channel_alipay_appId' => '支付宝appId',
            'channel_alipay_rsaPrivateKey' => '支付宝私钥',
            'channel_alipay_rsaPublicKey' => '支付宝公钥',
            'channel_created_at' => '创建时间',
            'channel_updated_at' => '修改时间',
        ];
    }

    public function saveOne(){
        $channel = new Channel();
        $channel->initNew($this->channel_name);
        if($channel->save()){
            $this->setAttributes($channel->attributes, false);
            return true;
        }
        return false;
    }
}