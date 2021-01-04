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
