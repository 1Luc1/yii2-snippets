### Code
---
```php
use yii\grid\GridView;

<?php
for ($i = 1; $i <= 5; $i++) {
    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'header' => $i,
        'headerOptions' => ['class' => 'text-center'],
        'template' => '{dg}',
        'buttons' => ['dg' => function($url, $model) use ($i) {
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
```

##### helpers/TagHelper.php

```php
<?php

namespace app\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class TagHelper {
    public static function getActionFunction($model, $column) {
        $cell = $model->getCell($column);

        $text = !empty($cell) && !empty($cell->value) ? '<span role="button">' . $cell->value . '</span>' :
                '<span role="button" class="glyphicon glyphicon-minus"></span>';

        return Html::a($text, FALSE, ['value' => Url::to(['table-cell-edit/update', 'row' => $model->row_number, 'column' => $column]),
                    'title' => Yii::t('app', 'Update Cell'),
                    'header' => Yii::t('app', 'Updating Cell') . ' <small>' . $model->row_number . ', ' . $column . '</small>', 'class' => 'showModalButton']);
    }
}
```

##### models/Row.php
```php
<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for a row within a table.
 */
class Row extends Model {

    /** @var integer */
    public $row_number;

    /** @var array */
    public $cells = [];

    public function rules() {
        return [
            ['row_number', 'required'],
            ['row_number', 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'row_number' => Yii::t('app', 'row number'),
        ];
    }

    public function getCell($column) {
        if (array_key_exists($column, $this->cells)){
            return $this->cells[$column];
        }
        return null;
    }

    public static function findAll() {
        $session = Yii::$app->session;
        $rows = $session['rows'];
        if (empty($rows)) {
            $rows = ["1" => new Row(['row_number' => 1]), "2" => new Row(['row_number' => 2]), "3" => new Row(['row_number' => 3])];
            $session['rows'] = $rows;
        }
        return $rows;
    }

}
```

##### models/Cell.php
```php
<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the cell class for a cell within a table.
 */
class Cell extends Model {

    /** @var integer */
    public $row;

    /** @var integer */
    public $column;

    /** @var string */
    public $value;

    /** @var boolean */
    public $isNewRecord;

    public function init() {
        parent::init();
        $this->isNewRecord = true;
    }

    public function rules() {
        return [
            [['column', 'row'], 'required'],
            [['column', 'row'], 'integer'],
            ['value', 'string', 'length' => [2, 10]],
        ];
    }

    public function attributeLabels() {
        return [
            'column' => Yii::t('app', 'Column'),
            'row' => Yii::t('app', 'Row'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    public function save() {
        // get rows from session
        $session = Yii::$app->session;
        $rows = $session['rows'];

        // get row of this cell
        $row_model = $rows[$this->row];
        // set this cell as new cell in row
        $row_model->cells[$this->column] = $this;

        // restore row model to session
        $rows[$this->row] = $row_model;
        $session['rows'] = $rows;

        $this->isNewRecord = false;
        return true;
    }

    public static function findOne($row, $column) {
        $session = Yii::$app->session;
        $rows = $session['rows'];
        $row_model = $rows[$row];
        $cell = $row_model->getCell($column);
        if (empty($cell)) {
            $cell = new Cell(['row' => $row, 'column' => $column]);
            $row_model->cells[$column] = $cell;
            $rows[$row] = $row_model;
            $session['rows'] = $rows;
        }

        return $cell;
    }

}
```

##### views/table-cell-edit/update.php
```php
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
```

##### controllers/TableCellEditController.php
```php
<?php

namespace app\controllers;

use app\models\Cell;
use app\models\Row;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class TableCellEditController extends Controller {

    public function actionIndex() {
        $models = Row::findAll();
        return $this->render('index', ['dataProvider' => new ArrayDataProvider(['allModels' => $models])]);
    }

    public function actionUpdate($row, $column) {
        $model = Cell::findOne($row, $column);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->renderAjax('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionDestroy() {
        $session = Yii::$app->session;
        $session->destroy();
        return $this->redirect('index');
    }

}
```