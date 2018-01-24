<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 24.01.2018
 * Time: 12:31
 */

namespace common\classes;

use common\models\db\CoverWidgets;
use Yii;

class RandomImgWidget
{

    public static function compositeWidgetsToCover($coverId, \Imagick $coverObj)
    {
        $widgets = CoverWidgets::find()->where(['cover_id' => $coverId, 'widget_name' => 'random-img'])->all();
        foreach ($widgets as $widget){
            $settings = json_decode($widget->widget_settings);

            $path = Yii::getAlias('@backend/web/widget_img/' . Yii::$app->user->id);
            $fileName = basename($settings->imgs[mt_rand(0, count($settings->imgs) - 1 )]);
            $file = $path . '/' . $fileName;
            $fileImg = new \Imagick($file);
            $fileImg->cropThumbnailImage($settings->width, $settings->height);
            $coverObj->compositeImage($fileImg, \Imagick::COMPOSITE_ATOP, $settings->x, $settings->y);
        }
        return $coverObj;
    }

}