<?php

/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/12/22
 * Time: 上午11:50
 */

namespace console\controllers;

use common\models\WechatRefund;
use common\tools\Time;
use console\models\WechatRefundForm;
use yii\console\Controller;
use Yii;

class WechatController extends Controller
{
    public function actionRefunding($time)
    {
        $nowMinute = Time::getMinute(Time::formatTime($time));
        if ($nowMinute != '00') {
            return false;
        }

        $wechatRefundForm = new WechatRefundForm();
        $search_query = $wechatRefundForm->searchByStatusRefunding();

        $numRe = 0;
        $numSuccess = 0;
        foreach ($search_query->each(20) as $wechatRefund) {
            $wechatRefund->query();
            $wechatRefund->refresh();
            if ($wechatRefund->wechat_refund_status == '') {
                $wechatRefund->refund();
                $numRe++;
            } elseif (!in_array($wechatRefund->wechat_refund_status, [WechatRefund::WECHAT_REFUND_STATUS_PROCESSING, WechatRefund::WECHAT_REFUND_STATUS_REPORT])) {
                $numSuccess++;
            }
        }

        if ($numSuccess > 0 || $numRe > 0) {
            Yii::info('[' . date('Y-m-d H:i:s]') . '重新发送退款请求' . $numRe . '条,退款查询完成' . $numSuccess . '条', 'task');
        }

        return 0;
    }
}