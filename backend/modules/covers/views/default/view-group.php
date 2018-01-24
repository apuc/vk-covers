<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 16.01.2018
 * Time: 23:06
 * @var $model \common\models\db\VkUserGroups
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;

?>
<div>
    <?= Html::a('Список', \yii\helpers\Url::to(['groups']), ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить из системы', \yii\helpers\Url::to(['del-group', 'id' => $model->owner_id]), ['class' => 'btn btn-danger']) ?>
</div>
<p></p>
<div>
    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'photo',
                'label' => 'Фото',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img($model->photo, ['width' => '100px']);
                }
            ],
            [
                'attribute' => 'name',
                'label' => 'Название',
            ],                                           // title свойство (обычный текст)
            'domain',
            'members_count',
            // дата создания в формате datetime
        ],
    ]);
    ?>
</div>
