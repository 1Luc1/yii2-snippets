<?php

use app\helpers\MarkdownHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'Tooltip within Modal';
?>

<div class="tooltip-index">

    <div class="row pb-3">
        <div class="col-md-8">
            <h3 class="page-header"><?= Yii::t('app', 'Example') ?></h3>
            <div class="row">
                <div class="col-md-6 text-center">
                    <?=
                    Html::button(Yii::t('app', 'Show Modal with Tooltip'), ['value' => Url::to(['tooltip/show']),
                        'title' => Yii::t('app', 'Showing modal with tooltip', [
                            'model_name' => 'modal model']), 'header' => Yii::t('app', 'Modal with Tooltip'), 'class' => 'showModalButton btn btn-info']);
                    ?>
                </div>
                <div class="col-md-6">

                    <?= Yii::t('text', 'Clicking the button will open a modal window. Within the modal window a tooltip will be shown.'); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h3 class="page-header"><?= Yii::t('app', 'Requirement') ?></h3>
            <?= Html::a('Modal', Url::to(['/modal']), ['target' => '_blank']); ?>
        </div>
    </div>

    <?= MarkdownHelper::get('/views/tooltip/code.md'); ?>
</div>
