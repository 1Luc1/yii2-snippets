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
