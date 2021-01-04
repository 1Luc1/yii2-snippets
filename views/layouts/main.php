<?php
/* @var $this yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use luc\tourist\Tourist;
use app\helpers\TouristHelper;
use app\widgets\Alert;
use kmergen\LanguageSwitcher;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

AppAsset::register($this);

if (empty($this->js[View::POS_READY]['tourist'])) {
    Tourist::widget(TouristHelper::getDefaultTourist());
}
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
                <?= Html::a(
                    '<span class="glyphicon glyphicon-question-sign" style="color:white;"></span>',
                    '#',
                    [
                        'class' => 'btn btn-md btn-link',
                        'style' => 'float: right;padding: 0px;',
                        'id' => 'tourHelp',
                    ]
                ); ?>
                <?=
                    LanguageSwitcher::widget([
                        'parentTemplate' => '<div class="nav">
                            <li class="dropdown pull-left">{activeItem}
                            <ul class="dropdown-menu dropdown-menu-left">{items}</ul>
                            </li>
                    </div>',
                        'activeItemTemplate' => '<a href="#" class="dropdown-toggle nopadding" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{label}</a>',
                        'itemTemplate' => '<li><a href="{url}">{label}</a></li>'
                    ]);
                ?>
                <h3 style="margin-top: 0px;">Yii2 Snippets</h3>
            </div>

            <?php

            $current_controller = Yii::$app->controller->id;
            ?>
            <!-- Sidebar Links -->
            <ul class="list-unstyled components">
                <li class="<?= $current_controller == 'modal' ? 'active' : '' ?>"><a href="<?= Url::to(['/modal']) ?>">Modal</a></li>
                <li class="<?= $current_controller == 'tooltip' ? 'active' : '' ?>"><a href="<?= Url::to(['/tooltip']) ?>">Tooltip <small>within Modal</small></a></li>
                <li class="<?= $current_controller == 'tourist' ? 'active' : '' ?>"><a href="<?= Url::to(['/tourist']) ?>">Tourist</a></li>
                <li class="<?= $current_controller == 'progress-bar' ? 'active' : '' ?>"><a href="<?= Url::to(['/progress-bar']) ?>">Progress Bar</a></li>
                <li class="<?= $current_controller == 'table-cell-edit' ? 'active' : '' ?>"><a href="<?= Url::to(['/table-cell-edit']) ?>">Table Cell Edit</a></li>
                <li class="<?= $current_controller == 'heroku' ? 'active' : '' ?>"><a href="<?= Url::to(['/heroku']) ?>">Heroku Deployment</a></li>
            </ul>

            <ul class="list-unstyled">
                <li class="<?= $current_controller == 'credits' ? 'active' : '' ?>"><a href="<?= Url::to(['/credits']) ?>"><small>Credits</small></a></li>
            </ul>
        </nav>

        <div id="content" class="">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
            </button>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>


    <?php
    Modal::begin([
        'closeButton' => [
            'label' => 'x',
        ],
        'header' => '<h3 id="headerTitle" style="float: left;"></h3>',
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-md',
        // setting tabindex fix problem with not selectable search field with select2
        'options' => ['style' => 'margin-top: 40px', 'tabindex' => false]
    ]);
    echo "<div id='modalContent'><div style='text-align:center'><img src='/image/ajax-loader.gif'></div></div>";
    Modal::end();
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>