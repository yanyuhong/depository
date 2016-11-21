<?php

namespace api_other\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $data = [
                'code' => (string)$exception->getCode(),
                'message' => (string)$exception->getMessage(),
            ];
            if (!YII_ENV_PROD) {
//                $data['file'] = $exception->getFile();
//                $data['line'] = $exception->getLine();
//                $data['trace'] = $exception->getTraceAsString();
            }
            return $data;
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = [
            'api_url' => '/v1',
        ];

        return $data;
    }


}
