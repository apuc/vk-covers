<?php
/**
 * @var $this yii\web\View
 * @var $model \common\models\db\Covers
 */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Мои обложки';
?>
<h1>Мои обложки</h1>
<?= Html::a('Добавить обложку', Url::to(['add-cover']), ['class' => 'btn btn-success']) ?>

<div class="covers-box">
    <?php foreach ($model as $item): ?>
        <div class="cover-item">
            <h3><?= $item->title ?> (группа: <?= $item->group->name ?>)
            <?= Html::a('Удалить', Url::to(['del-cover', 'id' => $item->id]), ['class' => 'btn btn-danger']) ?></h3>
            <a href="<?= Url::to(['edit-cover', 'id' => $item->id]) ?>">
                <?= Html::img(null !== $item->img ? $item->img : '/secure/empty.png', ['class' => 'cover-img']) ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>
