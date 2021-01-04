<?php

namespace app\controllers;

use app\models\Modal;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ModalController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionShow() {
        $model = new Modal();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Values {value} commited to server', ['value' => json_encode($model->toArray())]));
                $this->redirect(['/modal']);
            } elseif (!Yii::$app->request->isPost) {
                return $this->renderAjax('show', ['model' => $model]);
            }
        }
    }
}
