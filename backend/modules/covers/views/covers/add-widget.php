<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 18.01.2018
 * Time: 17:32
 * @var $model \common\models\db\CoverWidgets
 * @var  $widgetForm \common\models\forms\WidgetForm
 * @var $imgs array
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="layer-item" data-id="<?= $model->id ?>">
    <div class="layer-item-head"><?= $model->widget_rus_name ?></div>
    <div class="layer-item-body">
        <?php if ($widgetForm->scenario === \common\models\forms\WidgetForm::SCENARIO_RANDOM_IMG): ?>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($widgetForm, 'x')->textInput([
                'id' => 'x_' . $model->id,
                'class' => 'form-control widget_input_' . $model->id,
                'data-type' => 'x',
            ]) ?>
            <?= $form->field($widgetForm, 'y')->textInput([
                'id' => 'y_' . $model->id,
                'class' => 'form-control widget_input_' . $model->id,
                'data-type' => 'y',
            ]) ?>
            <?= $form->field($widgetForm, 'width')->textInput([
                'id' => 'width_' . $model->id,
                'class' => 'form-control widget_input_' . $model->id,
                'data-type' => 'width',
            ]) ?>
            <?= $form->field($widgetForm, 'height')->textInput([
                'id' => 'height_' . $model->id,
                'class' => 'form-control widget_input_' . $model->id,
                'data-type' => 'height',
            ]) ?>
            <?= Html::a('Установить', '#', ['class' => 'btn btn-success setWidgetSettings', 'data-id' => $model->id]) ?>
            <?= Html::a('Добавить изображение', '#',
                ['class' => 'btn btn-success addWidgetImg', 'data-id' => $model->id]) ?>
            <?= Html::a('Удалить', '#', ['class' => 'btn btn-danger delWidget', 'data-id' => $model->id]) ?>
            <?= Html::input('file', 'file_' . $model->id, null, [
                'id' => 'file_' . $model->id,
                'data-id' => $model->id,
                'style' => 'display:none',
                'class' => 'RIFile',
            ]) ?>
            <?php ActiveForm::end(); ?>
            <div class="load-img l-i-<?= $model->id ?>">
                <?php if (null !== $imgs): ?>
                    <?php foreach ($imgs as $img): ?>
                        <div class="widget-load-img">
                            <?= Html::img($img); ?>
                            <span>X</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
