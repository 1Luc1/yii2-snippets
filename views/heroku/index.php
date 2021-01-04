<?php

use app\helpers\MarkdownHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'Heroku Deployment';
?>

<div class="heroku-index">

    <div class="row pb-3">
        <div class="col-md-8">
            <h3 class="page-header"><?= Yii::t('app', 'Info') ?></h3>
            <div class="row">
                <div class="col-md-12">
                    <?= Yii::t('text', 'This shows what is needed to set up an yii2 project to be deployed to heroku.'); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h3 class="page-header"><?= Yii::t('app', 'Requirement') ?></h3>
            <?= Html::a('Heroku Account', 'https://www.heroku.com/', ['target' => '_blank']); ?>
        </div>
    </div>

    <?= MarkdownHelper::get('/views/heroku/code.md'); ?>
</div>