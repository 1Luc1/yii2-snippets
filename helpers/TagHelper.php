<?php

namespace app\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class TagHelper {

    public static function getLabelOptions($help, $placement = 'auto') {
        return [
            'class' => "control-label",
            'data-toggle' => 'popover',
            'data-trigger' => 'click hover',
            'data-placement' => $placement,
            'data-html' => 'true',
            'data-content' => $help,
            'style' => 'border-bottom: 1px dashed #888; cursor:help;'
        ];
    }

    public static function getActionFunction($model, $column) {
        $cell = $model->getCell($column);

        $text = !empty($cell) && !empty($cell->value) ? '<span role="button">' . $cell->value . '</span>' :
                '<span role="button" class="glyphicon glyphicon-minus"></span>';

        return Html::a($text, FALSE, ['value' => Url::to(['table-cell-edit/update', 'row' => $model->row_number, 'column' => $column]),
                    'title' => Yii::t('app', 'Update Cell'),
                    'header' => Yii::t('app', 'Updating Cell') . ' <small>' . $model->row_number . ', ' . $column . '</small>', 'class' => 'showModalButton']);
    }

}
