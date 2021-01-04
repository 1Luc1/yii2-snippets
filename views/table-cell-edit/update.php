<?php

use app\models\Cell;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Cell */
/* @var $form ActiveForm */
?>

<div class="table-cell-edit-update">

    <?php $form = ActiveForm::begin(['id' => 'table-cell-edit-update-form', 'enableAjaxValidation' => true]); ?> 

    <?= $form->field($model, 'value')->input('text') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'tabindex' => '3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
