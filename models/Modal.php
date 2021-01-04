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
