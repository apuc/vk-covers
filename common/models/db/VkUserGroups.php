<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "vk_user_groups".
 *
 * @property int $id
 * @property int $user_id
 * @property string $domain
 * @property string $name
 * @property int $owner_id
 * @property string $photo
 * @property int $status
 * @property int $prod_count
 * @property int $members_count
 * @property int $last_update
 */
class VkUserGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_user_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'domain', 'name', 'owner_id', 'photo'], 'required'],
            [['user_id', 'owner_id', 'status', 'prod_count', 'members_count', 'last_update'], 'integer'],
            [['domain', 'name', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'domain' => 'Domain',
            'name' => 'Название',
            'owner_id' => 'Идентификатор ВК',
            'photo' => 'Фото',
            'status' => 'Статус',
            'prod_count' => 'Кол-во продуктов',
            'members_count' => 'Кол-во участников',
            'last_update' => 'Последнее обновление',
        ];
    }
}
