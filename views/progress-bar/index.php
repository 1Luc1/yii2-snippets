<?php

use app\helpers\MarkdownHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Progress Bar';
?>

<div class="progress-bar-index">
    <h3 class="page-header"><?= Yii::t('app', 'Example') ?></h3>
    <div class="row">
        <div class="col-md-6 text-center">
            <?=
                Html::button(Yii::t('app', 'Show Progress'), [
                    'value' => Url::to(['progress-bar/show']), 'id' => 'progress-btn',
                    'title' => Yii::t('app', 'Showing progress bar'), 'header' => Yii::t('app', 'Progress Bar'), 'class' => 'showModalButton btn btn-info',
                    'data' => ['nexturl' => Url::to(['progress-bar/one']), 'nextlabel' => Yii::t('app', 'Action one ...')]
                ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= Yii::t('text', 'Clicking the button will open a modal window. Within this modal you can start an process which shows visually the progress of the process.'); ?>
        </div>
    </div>

    <div class="row pb-3">
        <div class="col-md-6">
            <h3 class="page-header"><?= Yii::t('app', 'Requirement') ?></h3>
            <?= Html::a('Modal', Url::to(['/modal']), ['target' => '_blank']); ?>, <?= Html::a("Kartik's Switchinput", 'https://github.com/kartik-v/yii2-widget-switchinput', ['target' => '_blank']); ?>
        </div>
        <div class="col-md-6">
            <h3 class="page-header"><?= Yii::t('app', 'Info') ?></h3>
            <?= Yii::t('text', 'This snippet is not about handling long running scripts asynchronous. Its about to show the progress of scripts which are based on each other.') ?>.
        </div>
    </div>

    <?= MarkdownHelper::get('/views/progress-bar/code.md'); ?>
</div>