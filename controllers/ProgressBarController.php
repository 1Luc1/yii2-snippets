<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class ProgressBarController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionShow() {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('show');
        }
    }

    public function actionOne() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action two ...'),
                    'nextUrl' => Url::to(['two'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionTwo() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action three ...'),
                    'nextUrl' => Url::to(['three'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionThree() {
        if (Yii::$app->request->isAjax) {
            $inclPic = Yii::$app->request->post('inclPic');

            if ($inclPic == 'false' || sleep(1)) {
                $res = array(
                    'success' => ($inclPic == 'false') ? 'skipped' : true,
                    'nextLabel' => Yii::t('app', 'Action four ...'),
                    'nextUrl' => Url::to(['four'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionFour() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action five ...'),
                    'nextUrl' => Url::to(['five'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionFive() {
        if (Yii::$app->request->isAjax) {
            sleep(1);

            if (true) {
                $res = [];
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

}
