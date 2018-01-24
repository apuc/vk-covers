<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 17.01.2018
 * Time: 16:04
 */

namespace common\models\forms;

use yii\base\Model;

class CoverAddForm extends Model
{

    public $name;
    public $group;

    public function rules()
    {
        return [
            [['name', 'group'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название обложки',
            'group' => 'Группа',
        ];
    }
}