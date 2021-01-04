### Code
---
##### web/js/modal.js
```text
$(function () {
    $(document).on('click', '.showModalButton', function () {
        // reset content before show
        $('#modal').find('#modalContent').html("<div style='text-align:center'><img src='image/ajax-loader.gif'></div>");
        //if modal isn't open; open it and load content
        $('#modal').on('hidden.bs.modal', function () { }).modal('show')
            .find('#modalContent')
```
```js
            .load($(this).attr('value'), function () {
                // show the popover within a modal window after everything is loaded
                $('[data-toggle="popover"]').popover();
            });
```
```text
        //dynamiclly set the header for the modal
        //document.getElementById('headerTitle').innerHTML = $(this).attr('header') ? $(this).attr('header') : $(this).attr('title');
        $("#headerTitle").html($(this).attr('header') ? $(this).attr('header') : $(this).attr('title'));
    });
```
```js
    // show popover in whole application
    $('[data-toggle="popover"]').popover();
```
```text
});
```

##### views/modal/show.php

```php
<?php

use app\helpers\TagHelper;
use app\models\Modal;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Modal */

$help = '<p class="text-justify">' . Yii::t('text', 'Label tooltip to give some usefull information for the input.') . '</p>';
$help2 = '<p class="text-justify">' . Yii::t('text', 'For Attribute2 a value needs to be selected.') . '</p>';
$help3 = '<p class="text-justify">' . Yii::t('text', 'Can\'t set the label for the checkbox correctly.') . '</p>';
$items = [1 => Yii::t('app', 'first item'), 2 => Yii::t('app', 'second item'), 3 => Yii::t('app', 'third item')];
?>

<div class="tooltip-show">
    <?php $form = ActiveForm::begin(['id' => 'tooltip-show-form', 'enableAjaxValidation' => true]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'attribute1', ['labelOptions' => TagHelper::getLabelOptions($help, 'left')])->input('text') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'attribute2', ['labelOptions' => TagHelper::getLabelOptions($help2, 'top')])
                    ->dropDownList($items, ['prompt' => Yii::t('app', '---- Select item ----')]);
            ?>
        </div>
    </div>
    <?= $form->field($model, 'attribute3')->checkBox()->label(null, TagHelper::getLabelOptions($help3, 'left')) ?>

    <div class="form-group" style="clear: both;">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
```

##### helpers/TagHelper.php
```php
<?php

namespace app\helpers;

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
}
```