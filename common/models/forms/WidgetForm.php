<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 18.01.2018
 * Time: 22:18
 */

namespace common\models\forms;

use yii\base\Model;

class WidgetForm extends Model
{

    public $x;
    public $y;
    public $width;
    public $height;

    const SCENARIO_RANDOM_IMG = 'random-img';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_RANDOM_IMG] = ['x', 'y', 'width', 'height'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['x', 'y', 'width', 'height'], 'required', 'on' => self::SCENARIO_RANDOM_IMG],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'x' => 'Координаты X',
            'y' => 'Координаты Y',
            'width' => 'Ширина',
            'height' => 'Высота',
        ];
    }
}