<?php

namespace app\controllers;

use yii\web\Controller;

class TouristController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
