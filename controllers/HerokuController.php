<?php

namespace app\controllers;

use yii\web\Controller;

class HerokuController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}