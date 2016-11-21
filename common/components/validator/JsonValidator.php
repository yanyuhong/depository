<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/9/20
 * Time: 下午3:56
 */

namespace common\components\validator;


use yii\validators\Validator;

class JsonValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        if (json_decode($model->$attribute) === null) {
            $this->addError($model, $attribute, 'JSON格式不正确');
        }
    }

}