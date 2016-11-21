<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/9/20
 * Time: 下午3:56
 */

namespace common\components\validator;


use yii\validators\Validator;

class ArrayValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        if (!is_array($model->$attribute)) {
            $this->addError($model, $attribute, '数组格式不正确');
        }
    }

}