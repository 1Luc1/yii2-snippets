<?php

namespace app\helpers;

use Yii;
use yii\helpers\Markdown;
use yii\web\NotFoundHttpException;

class MarkdownHelper
{
    public static function get($markdownPath)
    {
        try {
            $file = file_get_contents(Yii::getAlias('@app') . $markdownPath);
        } catch (\Throwable $th) {
            $file = false;
        }

        if ($file) {
            return Markdown::process($file, 'gfm');
        }

        throw new NotFoundHttpException(
            Yii::t(
                'app',
                "The file {path} couldn't be found.",
                ['path' => $markdownPath]
            ),
            404
        );
    }
}
