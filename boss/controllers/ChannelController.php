<?php

namespace boss\controllers;

use common\tools\Time;
use Yii;
use boss\models\ChannelForm;
use boss\models\ChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ChannelController implements the CRUD actions for ChannelForm model.
 */
class ChannelController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ChannelForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChannelForm model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ChannelForm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChannelForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveOne()) {
            return $this->redirect(['view', 'id' => $model->channel_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChannelForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->channel_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChannelForm model with alipay.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAlipay($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->channel_id]);
        } else {
            return $this->render('alipay', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChannelForm model with wechat.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionWechat($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->wechat_sslcert = UploadedFile::getInstance($model, 'wechat_sslcert');
            $cert_path = getcwd() . '/uploads/'. $model->channel_id . '-'. $model->wechat_sslcert->baseName . Time::time() . '.' . $model->wechat_sslcert->extension;
            if($model->wechat_sslcert){
                $model->wechat_sslcert->saveAs($cert_path, false);
                $model->channel_wechat_sslcert = $cert_path;
            }
            $model->wechat_sslkey = UploadedFile::getInstance($model, 'wechat_sslkey');
            $key_path = getcwd() . '/uploads/'. $model->channel_id . '-'. $model->wechat_sslkey->baseName . Time::time() . '.' . $model->wechat_sslkey->extension;
            if($model->wechat_sslkey){
                $model->wechat_sslkey->saveAs($key_path, false);
                $model->channel_wechat_sslkey = $key_path;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->channel_id]);
            }
        }
        return $this->render('wechat', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ChannelForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the ChannelForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChannelForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
