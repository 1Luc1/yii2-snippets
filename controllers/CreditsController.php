<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class CreditsController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

}
