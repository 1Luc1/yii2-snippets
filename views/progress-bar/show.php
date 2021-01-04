<?php

use kartik\switchinput\SwitchInput;
use yii\bootstrap\Progress;
use yii\helpers\Html;
?>
<div class="progress-bar-show" style="font-family: Arial, Helvetica, sans-serif;">
    <?php
    echo Progress::widget([
        'percent' => 0,
        'barOptions' => ['class' => 'progress-bar-info',],
        'options' => ['id' => 'progBar', 'class' => 'active progress-striped', 'style' => 'display: none;']
    ]);
    ?>
    <div id="app" style="display:none" data-done="<?= Yii::t('app', 'DONE') ?>" data-skipped="<?= Yii::t('app', 'SKIPPED') ?>" data-failed="<?= Yii::t('app', 'FAILED') ?>" ></div>

    <div id="info-panel" class="panel panel-info" style="display: none;">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Yii::t('app', 'Details') ?></h3>
        </div>
        <div id="info-body" class="panel-body">
            <div class="row" id="info-row">
                <div class="col-sm-5"></div>
                <div class="col-sm-7"></div>
            </div>
            <?= Html::tag('div', "", ['id' => 'detail-info']); ?>
        </div>
    </div>

    <div id="error-panel" class="panel panel-danger" style="display: none;">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Yii::t('app', 'Error Message') ?></h3>
        </div>
        <div class="panel-body">
            <?= Html::tag('div', "", ['id' => 'detail-error']); ?>
        </div>
    </div>

    <div id="options-panel">
        <div class="row" id="info-row">
            <div class="col-sm-6">
                <div class="well well-sm"><strong>Info!</strong> <?= Yii::t('text', 'Running this process may take some time.') ?></div>
            </div>
            <div class="col-sm-3"> <label class="control-label"> <?= Yii::t('app', 'run third action?') ?> </label>
                 <?=
                SwitchInput::widget(['name' => 'backpic', 'options' => ['id' => 'backpic'], 'value' => false, 'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No')
                ]]);
                ?>
            </div>
            <div class="col-sm-3"><br>
                <?= Html::button(Yii::t('app', 'Start'), [ 'class' => 'btn btn-info', 'onclick' => 'startBackup();']); ?>
            </div>
        </div>
    </div>
</div>
