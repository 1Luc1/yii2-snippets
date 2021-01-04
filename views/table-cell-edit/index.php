<?php

use app\helpers\MarkdownHelper;
use app\helpers\TagHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Table Cell Edit';
?>

<div class="table-cell-edit-index">
    <h3 class="page-header"><?= Yii::t('app', 'Example') ?></h3>
    <div class="row">
        <div class="col-md-6 text-center">
            <?php
            for ($i = 1; $i <= 5; $i++) {
                $columns[] = [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => $i,
                    'headerOptions' => ['class' => 'text-center'],
                    'template' => '{dg}',
                    'buttons' => ['dg' => function ($url, $model) use ($i) {
                        return TagHelper::getActionFunction($model, $i);
                    }]
                ];
            }

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}',
                'columns' => $columns,
            ]);
            ?>
        </div>

        <div class="col-md-4 col-lg-offset-1">
            <?= Yii::t('text', 'Clicking the {-} will open an modal window. Within the modal you can create or update the value for this cell.', ['-' => '<span class="glyphicon glyphicon-minus" ></span>']); ?>
            <br> <br>
            <?= Html::a(Yii::t('app', 'Clear Table'), ['/table-cell-edit/destroy'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h3 class="page-header"><?= Yii::t('app', 'Requirement') ?></h3>
            <?= Html::a('Modal', Url::to(['/modal']), ['target' => '_blank']); ?>
        </div>
        <div class="col-md-6">
            <h3 class="page-header"><?= Yii::t('app', 'Info') ?></h3>
            <?= Yii::t('text', 'This snippet uses only the session to store the table cell values.') ?>
        </div>
    </div>

    <?= MarkdownHelper::get('/views/table-cell-edit/code.md'); ?>
</div>