<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 17.01.2018
 * Time: 15:49
 * @var $model \common\models\db\VkUserGroups
 */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Добавить обложку';
?>

<h1>Добавить обложку</h1>

<div class="cover-box">
    <?= Html::label('Название') ?>
    <?= Html::input('text', 'coverName', null, ['class' => 'form-control', 'placeholder' => 'Название обложки']) ?>
    <br>
    <?= Html::label('Группа') ?>
    <?= Html::dropDownList('coverGroup', null, ArrayHelper::map($model, 'id', 'name'), ['class' => 'form-control']) ?>
</div>