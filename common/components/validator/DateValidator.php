<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/9/20
 * Time: 下午3:56
 */

namespace common\components\validator;


use yii\validators\Validator;

class DateValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        if (strtotime($model->$attribute) == 0) {
            $this->addError($model, $attribute, '时间格式不正确');
        }
    }

}