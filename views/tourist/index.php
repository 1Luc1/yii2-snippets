<?php

use app\helpers\MarkdownHelper;
use app\helpers\TouristHelper;
use luc\tourist\Tourist;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Tourist';

Tourist::widget(TouristHelper::getOptions([
    [
        'element' => "#example",
        'title' => Yii::t('app', 'Example'),
        'content' => Yii::t('text', "Here you see an example, how the snippet is used within the application."),
        'placement' => 'bottom'
    ],
    [
        'element' => "#code",
        'title' => Yii::t('app', 'Code'),
        'content' =>  Yii::t('text', "Here you see the code used for this snippet."),
        'placement' => 'left'
    ], [
        'element' => "#requirement",
        'title' => Yii::t('app', 'Requirement'),
        'content' =>  Yii::t('text', "Here you see the requirements for this snippet to work properly."),
        'placement' => 'left'
    ]
]));
?>

<div class="tourist-index">
    <div class="row pb-3">
        <div class="col-md-8">
            <h3 class="page-header" id="example"><?= Yii::t('app', 'Example') ?></h3>
            <div class="row">
                <div class="col-md-6 text-center">
                    <span class="glyphicon glyphicon-question-sign"></span>
                </div>
                <div class="col-md-6">
                    <?= Yii::t('text', 'Clicking the <strong>question mark within the navbar</strong> will start the help tour for this page.'); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h3 class="page-header" id="requirement"><?= Yii::t('app', 'Requirement') ?></h3>
            <?= Html::a('yii2-tourist', 'https://github.com/1Luc1/yii2-tourist', ['target' => '_blank']); ?><br>
            <?= Html::a('bootstrap-tourist', 'https://github.com/IGreatlyDislikeJavascript/bootstrap-tourist', ['target' => '_blank']); ?>
        </div>
    </div>

    <?= MarkdownHelper::get('/views/tourist/code.md'); ?>
</div>