<?php

use app\helpers\MarkdownHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Modal';
?>

<div class="modal-index">
    <h3 class="page-header"><?= Yii::t('app', 'Example') ?></h3>
    <div class="row">
        <div class="col-md-6 text-center">
            <?=
                Html::button(Yii::t('app', 'Show Modal'), [
                    'value' => Url::to(['modal/show']),
                    'title' => Yii::t('app', 'Showing modal for {model_name}', [
                        'model_name' => 'modal model'
                    ]), 'header' => Yii::t('app', 'Modal Model'), 'class' => 'showModalButton btn btn-info'
                ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= Yii::t('text', 'Clicking the button will open a modal window. The content for the modal window will be loaded using ajax. Within the modal the model will be validated.'); ?>
        </div>
    </div>

    <div class="row pb-3">
        <div class="col-md-6">
            <h3 class="page-header"><?= Yii::t('app', 'Requirement') ?></h3>
            <?= Html::a('Yii2 Basic', 'https://github.com/yiisoft/yii2-app-basic', ['target' => '_blank']); ?>
        </div>
        <div class="col-md-6">
            <h3 class="page-header"><?= Yii::t('app', 'Info') ?></h3>
            <?= Yii::t('text', 'This example is based <strong>heavily</strong> on') ?> <?= Html::a("skworden's", 'http://www.yiiframework.com/user/74354/', ['target' => '_blank']) ?> <?= Html::a('tutorial', 'http://www.yiiframework.com/wiki/806/render-form-in-popup-via-ajax-create-and-update-with-ajax-validation-also-load-any-page-via-ajax-yii-2-0-2-3/', ['target' => '_blank']) ?>.
        </div>
    </div>

    <?= MarkdownHelper::get('/views/modal/code.md'); ?>
</div>