<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "cover_widgets".
 *
 * @property int $id
 * @property int $cover_id
 * @property string $widget_name
 * @property string $widget_rus_name
 * @property string $widget_settings
 */
class CoverWidgets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cover_widgets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cover_id', 'widget_name', 'widget_rus_name'], 'required'],
            [['cover_id'], 'integer'],
            [['widget_settings'], 'string'],
            [['widget_name', 'widget_rus_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cover_id' => 'Cover ID',
            'widget_name' => 'Widget Name',
            'widget_rus_name' => 'Widget Rus Name',
            'widget_settings' => 'Widget Settings',
        ];
    }
}
