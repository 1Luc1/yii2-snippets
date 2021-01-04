### Code
---
```php
<?=
Html::button(Yii::t('app', 'Show Progress'), ['value' => Url::to(['progress-bar/show']), 'id' => 'progress-btn',
    'title' => Yii::t('app', 'Showing progress bar'), 'header' => Yii::t('app', 'Progress Bar'), 'class' => 'showModalButton btn btn-info',
    'data' => ['nexturl' => Url::to(['progress-bar/one']), 'nextlabel' => Yii::t('app', 'Action one ...')]]);
?>
```

##### assets/AppAsset.php

```php
class AppAsset extends AssetBundle
{
    ...
    public $js = [
        'js/modal.js'
        'js/progress_bar.js'
    ];
    ...
}
```

##### views/progress-bar/show.php
```php
<?php

use kartik\switchinput\SwitchInput;
use yii\bootstrap\Progress;
use yii\helpers\Html;
?>
<div class="progress-bar-show" style="font-family: Arial, Helvetica, sans-serif;">
    <?php
    echo Progress::widget([
        'percent' => 0,
        'barOptions' => ['class' => 'progress-bar-info',],
        'options' => ['id' => 'progBar', 'class' => 'active progress-striped', 'style' => 'display: none;']
    ]);
    ?>
    <div id="app" style="display:none" data-done="<?= Yii::t('app', 'DONE') ?>" data-skipped="<?= Yii::t('app', 'SKIPPED') ?>" data-failed="<?= Yii::t('app', 'FAILED') ?>" ></div>

    <div id="info-panel" class="panel panel-info" style="display: none;">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Yii::t('app', 'Details') ?></h3>
        </div>
        <div id="info-body" class="panel-body">
            <div class="row" id="info-row">
                <div class="col-sm-5"></div>
                <div class="col-sm-7"></div>
            </div>
            <?= Html::tag('div', "", ['id' => 'detail-info']); ?>
        </div>
    </div>

    <div id="error-panel" class="panel panel-danger" style="display: none;">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Yii::t('app', 'Error Message') ?></h3>
        </div>
        <div class="panel-body">
            <?= Html::tag('div', "", ['id' => 'detail-error']); ?>
        </div>
    </div>

    <div id="options-panel">
        <div class="row" id="info-row">
            <div class="col-sm-6">
                <div class="well well-sm"><strong>Info!</strong> <?= Yii::t('text', 'Running this progress may take some time.') ?></div>
            </div>
            <div class="col-sm-3"> <label class="control-label"> <?= Yii::t('app', 'run third action?') ?> </label>
                 <?=
                SwitchInput::widget(['name' => 'backpic', 'options' => ['id' => 'backpic'], 'value' => false, 'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No')
                ]]);
                ?>
            </div>
            <div class="col-sm-3"><br>
                <?= Html::button(Yii::t('app', 'Start'), [ 'class' => 'btn btn-info', 'onclick' => 'startBackup();']); ?>
            </div>
        </div>
    </div>
</div>
```

##### js/progress_bar.js
```js
function startBackup() {
    window.onbeforeunload = function () {
        return 'Please save';
    };

    // prevent modal to close on click outside
    $('#modal').on('hide.bs.modal', function (e) {
        e.preventDefault();
    });

    $('#options-panel').hide();
    $('#progBar').show();
    $('#info-panel').slideDown('fast');

    ajaxRequest = $.ajax({
        async: true,
        type: "post",
        dataType: 'json',
        url: $("#progress-btn").attr("data-nexturl"),
        data: null
    });

    addRow($("#progress-btn").attr("data-nextlabel"));
    ajaxRequest.done(backupCallback);
}

function backupCallback(response) {
    if (!response.hasOwnProperty('success')) {
        endBackup();
    } else if (response.success) {
        addStatus(((response.success === 'skipped') ? $("#app").attr("data-skipped") : $("#app").attr("data-done")) + "<br>");
        // to set the progressbar width dynamicly a hack has to be used; only works with inline style
        $('.progress-bar').css("width", parseInt($('.progress-bar')[0].style.width) + 20 + "%");
        ajaxRequest = $.ajax({
            async: true,
            type: "post",
            dataType: 'json',
            url: response.nextUrl,
            data: {inclPic: $('#backpic').bootstrapSwitch('state'), filename: response.filename}
        });
        addRow(response.nextLabel);
        ajaxRequest.done(backupCallback);
        ajaxRequest.fail(function (response) {
            callEnd(response);
        });

    } else if (!response.success) {
        callEnd(response);
    }
}

function callEnd(response) {
    endBackup(true);
    $('#error-panel').slideDown('fast');
    $('#detail-error').append(response.errorMsg);
}

function endBackup(failed) {
    failed = failed === undefined ? false : failed;
    addStatus(failed ? $("#app").attr("data-failed") : $("#app").attr("data-done"));
    if (!failed) {
        $('.progress-bar').css("width", '100%');
    }
    barClass = failed ? "progress-bar-danger" : "progress-bar-success";
    $('.progress-bar').toggleClass("progress-bar-info " + barClass);
    window.onbeforeunload = null;
    $('#modal').off('hide.bs.modal');
}

function addRow(label) {
    $('#info-body').append($('#info-row').clone().removeAttr('id'));
    $('#info-body').children().last().children().first().append(label);
}

function addStatus(status) {
    $('#info-body').children().last().children().last().append(status);
}
```

##### controllers/ProgressBarController.php
```php
<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class ProgressBarController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionShow() {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('show');
        }
    }

    public function actionOne() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action two ...'),
                    'nextUrl' => Url::to(['two'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionTwo() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action three ...'),
                    'nextUrl' => Url::to(['three'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionThree() {
        if (Yii::$app->request->isAjax) {
            $inclPic = Yii::$app->request->post('inclPic');

            if ($inclPic == 'false' || sleep(1)) {
                $res = array(
                    'success' => ($inclPic == 'false') ? 'skipped' : true,
                    'nextLabel' => Yii::t('app', 'Action four ...'),
                    'nextUrl' => Url::to(['four'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionFour() {
        if (Yii::$app->request->isAjax) {
            sleep(1);
            if (true) {
                $res = array(
                    'success' => true,
                    'nextLabel' => Yii::t('app', 'Action five ...'),
                    'nextUrl' => Url::to(['five'])
                );
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

    public function actionFive() {
        if (Yii::$app->request->isAjax) {
            sleep(1);

            if (true) {
                $res = [];
            } else {
                $res = array(
                    'success' => false,
                    'errorMsg' => Yii::t('text', 'An error occurred while processing.'),
                );
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
    }

}
```