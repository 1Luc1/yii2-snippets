<?php

namespace app\helpers;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * Description of TouristHelper
 * Bootstrap Tour Options, see: http://bootstraptour.com/api/
 * Bootstrap Tourist: https://github.com/IGreatlyDislikeJavascript/bootstrap-tourist
 * @author luc
 */
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
                            Yii::t('app', 'Tourist-Page'),
                            Url::to(['/tourist']),
                            ['class' => 'dotted']
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
