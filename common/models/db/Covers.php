<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "covers".
 *
 * @property int $id
 * @property int $user_id
 * @property int $owner_id
 * @property string $title
 * @property int $dt_add
 * @property string $img
 */
class Covers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'covers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'owner_id', 'title'], 'required'],
            [['user_id', 'owner_id', 'dt_add'], 'integer'],
            [['title', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'owner_id' => 'Owner ID',
            'title' => 'Title',
            'dt_add' => 'Dt Add',
            'img' => 'Img',
        ];
    }

    public function getgroup()
    {
        return  $this->hasOne(VkUserGroups::className(), ['owner_id' => 'owner_id']);
    }
}
