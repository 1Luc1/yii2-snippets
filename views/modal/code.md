### Code
---
```php
<?= Html::button(Yii::t('app', 'Show Modal'), ['value' => Url::to(['modal/show']),
        'title' => Yii::t('app', 'Showing modal for {model_name}', [
        'model_name' => 'modal model']), 'header' => Yii::t('app', 'Modal Model'), 'class' => 'showModalButton btn btn-info']);
?>
```

##### assets/AppAsset.php

```php
class AppAsset extends AssetBundle
{
    ...
    public $js = [
        'js/modal.js'
    ];
    ...
}
```

##### web/js/modal.js
```js
$(function () {
    $(document).on('click', '.showModalButton', function () {
        // reset content before show
        $('#modal').find('#modalContent').html("<div style='text-align:center'><img src='image/ajax-loader.gif'></div>");
        //if modal isn't open; open it and load content
        $('#modal').on('hidden.bs.modal', function () { }).modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        //dynamiclly set the header for the modal
        document.getElementById('headerTitle').innerHTML = $(this).attr('header') ? $(this).attr('header') : $(this).attr('title');
    });
});
```

##### views/layouts/main.php
```
...
<div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
```
```php
<?php
    Modal::begin([
        'closeButton' => [
            'label' => 'x',
        ],
        'header' => '<h3 id="headerTitle" style="float: left;"></h3>',
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'><div style='text-align:center'><img src='/image/ajax-loader.gif'></div></div>";
    Modal::end();
?>
```
```
<?php $this->endBody() ?>
...
```

##### controllers/ModalController.php
```php
<?php

namespace app\controllers;

use app\models\Modal;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ModalController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionShow() {
        $model = new Modal();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Values {value} commited to server', ['value' => json_encode($model->toArray())]));
                $this->redirect(['/modal']);
            } elseif (!Yii::$app->request->isPost) {
                return $this->renderAjax('show', ['model' => $model]);
            }
        }
    }
}
```

##### models/Modal.php
```php
<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for modal window.
 */
class Modal extends Model {

    /** @var string */
    public $attribute1;

    /** @var integer */
    public $attribute2;

    /** @var boolean */
    public $attribute3;

    public function rules() {
        return [
            [['attribute1', 'attribute2'], 'required'],
            ['attribute1', 'string', 'max' => 10],
            ['attribute2', 'integer'],
            ['attribute3', 'boolean']
        ];
    }

    public function attributeLabels() {
        return [
            'attribute1' => Yii::t('app', 'first attribute'),
            'attribute2' => Yii::t('app', 'second attribute'),
            'attribute3' => Yii::t('app', 'third attribute'),
        ];
    }

}
```

##### views/show.php
```php
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
```

##### web/image/ajax-loader.gif
![](/image/ajax-loader.gif)