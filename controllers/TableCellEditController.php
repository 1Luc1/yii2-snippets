<?php

namespace app\controllers;

use app\models\Cell;
use app\models\Row;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class TableCellEditController extends Controller {

    public function actionIndex() {
        $models = Row::findAll();
        return $this->render('index', ['dataProvider' => new ArrayDataProvider(['allModels' => $models])]);
    }

    public function actionUpdate($row, $column) {
        $model = Cell::findOne($row, $column);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->renderAjax('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionDestroy() {
        $session = Yii::$app->session;
        $session->destroy();
        return $this->redirect('index');
    }

}
