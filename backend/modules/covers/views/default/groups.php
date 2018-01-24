<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 16.01.2018
 * Time: 17:51
 * @var $dataProvider \yii\data\ArrayDataProvider
 */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ваши группы';
?>

<div>
    <?php echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'photo_200',
                'label' => 'Фото',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img($data['photo_200'], ['width' => '100px']);
                }
            ],
            [
                'attribute' => 'screen_name',
                'format' => 'raw',
                'label' => 'Ссылка',
                'value' => function($data){
                    return Html::a('https://vk.com/' . $data['screen_name'], 'https://vk.com/' . $data['screen_name']);
                }
            ],
            'name',
            [
                'label' => 'Действие',
                'format' => 'raw',
                'value' => function($data){
                    if(\common\models\db\VkUserGroups::find()->where(['owner_id' => $data['id']])->one()){
                        return Html::a('Просмотр', Url::to(['view-group', 'id' => $data['id']]), ['class'=>'btn btn-primary']);
                    }
                    return Html::a('Добавить в систему', Url::to(['add-group', 'id' => $data['id']]), ['class'=>'btn btn-success']);
                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ])?>
</div>
