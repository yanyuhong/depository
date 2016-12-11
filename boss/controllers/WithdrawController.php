<?php

namespace boss\controllers;

use common\models\Withdraw;
use Yii;
use boss\models\WithdrawForm;
use boss\models\WithdrawSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WithdrawController implements the CRUD actions for WithdrawForm model.
 */
class WithdrawController extends Controller
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
     * Lists all WithdrawForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Operation an existing WithdrawForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionOperation($id)
    {
        $model = $this->findModel($id);

        if ($model->withdraw_status == Withdraw::WITHDRAW_STATUS_RECEIVE) {
            $model->updateStatus(WithdrawForm::WITHDRAW_STATUS_PROCESS);
        }

        return $this->actionIndex();
    }

    /**
     * Success an existing WithdrawForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSuccess($id)
    {
        $model = $this->findModel($id);

        if (in_array($model->withdraw_status, [Withdraw::WITHDRAW_STATUS_RECEIVE, Withdraw::WITHDRAW_STATUS_PROCESS])) {
            $model->updateStatus(WithdrawForm::WITHDRAW_STATUS_SUCCESS);
        }

        return $this->actionIndex();
    }

    /**
     * Fail an existing WithdrawForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionFail($id)
    {
        $model = $this->findModel($id);

        if (in_array($model->withdraw_status, [Withdraw::WITHDRAW_STATUS_RECEIVE, Withdraw::WITHDRAW_STATUS_PROCESS])) {
            $model->updateStatus(WithdrawForm::WITHDRAW_STATUS_FAIL);
        }

        return $this->actionIndex();
    }

    /**
     * Finds the WithdrawForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WithdrawForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WithdrawForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
