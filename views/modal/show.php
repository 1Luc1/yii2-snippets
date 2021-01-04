<?php

use app\models\Modal;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Modal */

$items = [1 => Yii::t('app', 'first item'),
        2 => Yii::t('app', 'second item'),
        3 => Yii::t('app', 'third item')
];
?>
<div class="modal-show">
    <?php $form = ActiveForm::begin(['id' => 'modal-show-form', 'enableAjaxValidation' => true]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'attribute1')->input('text') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'attribute2')->dropDownList($items, 
                    ['prompt' => Yii::t('app', '---- Select item ----')]); ?>
        </div>
    </div>

    <?= $form->field($model, 'attribute3')->checkBox() ?>

    <div class="form-group" style="clear: both;">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>