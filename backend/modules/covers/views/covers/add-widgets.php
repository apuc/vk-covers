<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 24.01.2018
 * Time: 11:05
 * @var $widgets \common\models\db\CoverWidgets
 */

use common\models\forms\WidgetForm;

foreach ($widgets as $widget){
    $widgetForm = new WidgetForm();
    $widgetForm->scenario = $widget->widget_name;
    $settings = json_decode($widget->widget_settings);
    $widgetForm->attributes = [
        'x' => $settings->x,
        'y' => $settings->y,
        'width' => $settings->width,
        'height' => $settings->height,
    ];
    echo $this->render('add-widget', ['widgetForm' => $widgetForm, 'model' => $widget, 'imgs' => $settings->imgs]);
}