<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/30/15
 * Time: 12:39 PM
 */

namespace api_biz\components;


use linslin\yii2\curl\Curl;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii;

class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['clientAuth'] = [
            'class' => AuthClientAndUser::className(),
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function redirectData($url)
    {

        $url .= '?' . http_build_query(Yii::$app->request->get());
        $post = http_build_query(Yii::$app->request->post());
        $headers[] = "appId: " . Yii::$app->request->getHeaders()['appId'];
        $headers[] = "token: " . Yii::$app->request->getHeaders()['token'];
        $headers[] = "gym: " . Yii::$app->request->getHeaders()['gym'];

        $curl = new Curl();

        $curl->reset()
            ->setOptions([
                CURLOPT_POSTFIELDS => $post,
                CURLOPT_HTTPHEADER => $headers,
            ])
            ->post($url);

        Yii::$app->getResponse()->setStatusCode($curl->responseCode);
        return (array)json_decode($curl->response);
    }

    public function renderJsonSuccess($obj = array())
    {
        $response = Yii::$app->response;
        $data = array();
        $data['code'] = "0";
        $data['data'] = $obj;
        $response->data = $data;
        return $response;
    }

    public function renderJsonFailed($code, $reason = null)
    {
        $response = Yii::$app->response;
        if ($code !== null && isset($this->errorMessage[$code])) {
            $data = [
                'code' => $code,
                'message' => $this->errorMessage[$code],
            ];
            if ($code == '40001' && is_array($reason)) {
                $data['message'] = $reason[array_keys($reason)[0]][0];
            }
            $response->data = $data;
            return $response;
        } else {
            return $this->renderJsonFailed('40000');
        }
    }

    private $errorMessage = [
        '40000' => '服务器内部错误',
        '40001' => '参数错误',

        '42001' => '账户已存在',
        '42002' => '账户不存在',

        '42301' => '银行编号不正确',

        '43001' => '操作流水不存在',
        '43002' => '操作流水号不正确',
        '43003' => '操作帐户不正确',
        '43004' => '操作金额超限',
        '43401' => '充值操作流水状态有误',
        '43701' => '状态不正确,无法关闭操作',
    ];
}