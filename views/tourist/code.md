### Code
---
##### view/layouts/main.php
```php
...
use luc\tourist\Tourist;
use app\helpers\TouristHelper;
...
```
```text
AppAsset::register($this);
```
```php
if (empty($this->js[View::POS_READY]['tourist'])) {
    Tourist::widget(TouristHelper::getDefaultTourist());
}
```
```text
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Yii2 Snippets - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <nav id="sidebar">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
```
```php
                <?= Html::a(
                    '<span class="glyphicon glyphicon-question-sign" style="color:white;"></span>',
                    '#',
                    [
                        'class' => 'btn btn-md btn-link',
                        'style' => 'float: right;padding: 0px;',
                        'id' => 'tourHelp',
                    ]
                ); ?>
```

##### view/*/index.php
```text
<?php

use app\helpers\MarkdownHelper;
use app\helpers\TouristHelper;
use luc\tourist\Tourist;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Tourist';
```
```php
Tourist::widget(TouristHelper::getOptions([
    [
        'element' => "#example",
        'title' => Yii::t('app', 'Example'),
        'content' => Yii::t('text', "Here you see an example, how the snippet is used within the application."),
        'placement' => 'bottom'
    ],
    [
        'element' => "#code",
        'title' => Yii::t('app', 'Code'),
        'content' =>  Yii::t('text', "Here you see the code used for this snippet."),
        'placement' => 'left'
    ], [
        'element' => "#requirement",
        'title' => Yii::t('app', 'Requirement'),
        'content' =>  Yii::t('text', "Here you see the requirements for this snippet to work properly."),
        'placement' => 'left'
    ]
]));
```

##### helpers/TourHelper.php
```php
<?php

namespace app\helpers;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;

class TouristHelper
{
    public static function getDefaultTourist()
    {
        return [
            'clientOptions' => [
                'steps' => [[
                    'element' => "#tourHelp",
                    'title' => Yii::t('app', 'Help'),
                    'content' => Yii::t(
                        'text',
                        "On this page are no helps available. See the {tour-page} for how to use this snippet.",
                        ['tour-page' => Html::a(
                            Yii::t('app', 'Tour-Page'),
                            Url::to(['/tour']),
                            ['style' => 'border-bottom: 1px dotted;']
                        )]
                    ),
                    'placement' => "bottom",
                ]],
                'showProgressBar' => false,
                'template' => "<div class='popover tour'>
                            <div class='arrow'></div>
                            <h3 class='popover-title'></h3>
                            <div class='popover-content'></div>
                            <div class='popover-navigation'>
                              <button class='btn btn-sm btn-default' data-role='end'>" . Yii::t('app', 'Ok') . "</button>
                            </div>
                          </div>"
            ],
        ];
    }

    public static function getOptions($steps)
    {
        return [
            'clientOptions' => [
                'steps' => $steps,
                'sanitizeWhitelist' => [
                    "label" => ['data-toggle', 'data-trigger', 'data-placement', 'data-html', 'data-content', 'style'], "mark" => []
                ],
                'showProgressBar' => false,
                'template' => "<div class='popover tour'>
                            <div class='arrow'></div>
                            <h3 class='popover-title'></h3>
                            <div class='popover-content'></div>
                            <div class='popover-navigation'>
                              <button class='btn btn-sm btn-default' data-role='prev'>" . Yii::t('app', '« Prev') . "</button>
                              <span data-role='separator'> </span>
                              <button class='btn btn-sm btn-default' data-role='next'>" . Yii::t('app', 'Next »') . "</button>
                              <span data-role='separator'> </span>
                              <button class='btn btn-sm btn-default' data-role='end'>" . Yii::t('app', 'End Help') . "</button>
                            </div>
                          </div>",
            ],
        ];
    }
}
```

##### web/js/main.js
```js
$(function() {
    // start tour if tour help is clicked
    $(document).on('click', '#tourHelp', function() {
        tour.restart();
    });
});
```

##### assets/AppAsset.php
```php
...
public $js = [
        'js/main.js',
...
```