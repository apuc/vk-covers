<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 17.01.2018
 * Time: 16:47
 * @var $model \common\models\db\Covers
 * @var $widgets \common\models\db\CoverWidgets
 */
use yii\helpers\Html;

?>

<div class="wrap" data-cover-id="<?= $model->id ?>">
    <div class="widgets">
        <div class="widget-item" data-name="random-img" data-rus-name="Случайные изображения">Случайные изображения</div>
        <div class="widget-item"></div>
        <div class="widget-item"></div>
        <div class="widget-item"></div>
        <div class="widget-item"></div>
    </div>
    <div class="work-box">
        <div class="cover-item" id="mainCover" style="position: relative">
            <?= Html::img(null !== $model->img ? $model->img : '/secure/empty.png', ['class' => 'cover-img']) ?>
            <?php foreach ($widgets as $widget): ?>
                <?php $wParams = json_decode($widget->widget_settings); ?>
                <div id="widget_<?= $widget->id ?>" style="
                        height: <?= $wParams->height ?>px;
                        width: <?= $wParams->width ?>px;
                        top: <?= $wParams->y ?>px;
                        left: <?= $wParams->x ?>px;
                        position: absolute;
                        background-color: grey;
                        opacity: 0.7;
                        border: 2px dashed black;
                        ;"></div>
            <?php endforeach; ?>
        </div>
        <input type="file" id="coverFile" name="coverFile" />
        <?= Html::a('Сохранить', '#', ['class' => 'btn btn-success', 'id' => 'saveCover']) ?>
        <?= Html::a('Пердпросмотр', '#', ['class' => 'btn btn-success', 'id' => 'previewCover']) ?>
        <div class="coverPreviewBox"></div>
    </div>
    <div class="layers">
        <?= $this->render('add-widgets', ['widgets' => $widgets]); ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        loadWidget();
    });
</script>
