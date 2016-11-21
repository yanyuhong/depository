<?php
/**
 * Created by PhpStorm.
 * User: qsq
 * Date: 11/20/15
 * Time: 8:46 PM
 */

namespace boss\controllers;

use yii;
use yii\web\Controller;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index',[]);
    }
}