<?php
namespace backend\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class MainMenuAdmin extends Widget
{
    public function run(){
        var_dump(Yii::$app->module->id);
        echo \yii\widgets\Menu::widget(
            [
                'items' => [
                    [
                        'label' => 'Пользователи',
                        'url' => Url::to(['/user/admin']),
                        'template' => '<a href="{url}"><i class="fa fa-users"></i> <span>{label}</span></a>',
                        'active' => Yii::$app->controller->module->id == 'user' || Yii::$app->controller->module->id == 'rbac',

                    ],
                    [
                        'label' => 'Обложки',
                        /*'active' => Yii::$app->controller->id == 'site',*/
                        'items' => [
                            [
                                'label' => 'Группы',
                                'url' => Url::to(['/covers/default/groups']),
                                'active' => Yii::$app->controller->action->id === 'groups' && Yii::$app->controller->module->id === 'covers',
                            ],
                            [
                                'label' => 'Мои обложки',
                                'url' => Url::to(['/covers/covers']),
                                'active' => Yii::$app->controller->action->id === 'index' && Yii::$app->controller->module->id === 'covers',
                            ],
                        ],
                        'options' => [
                            'class' => 'treeview',
                        ],
                        'template' => '<a href="#"><i class="fa fa-newspaper-o"></i> <span>{label}</span> <i class="fa fa-angle-left pull-right"></i></a>',
                    ],
                    [
                        'label' => 'Доска',
                        'items' => [
                            [
                                'label' => '123',
                                'url' => '#'
                            ],
                            [
                                'label' => '345',
                                'url' => '#',
                            ],
                        ],
                        'options' => [
                            'class' => 'treeview',
                        ],
                        'template' => '<a href="#"><i class="fa fa-dashboard"></i> <span>{label}</span> <i class="fa fa-angle-left pull-right"></i></a>',
                    ],
                ],
                'activateItems' => true,
                'activateParents' => true,
                'activeCssClass'=>'active',
                'encodeLabels' => false,
                /*'dropDownCaret' => false,*/
                'submenuTemplate' => "\n<ul class='treeview-menu' role='menu'>\n{items}\n</ul>\n",
                'options' => [
                    'class' => 'sidebar-menu',
                ]
            ]
        );
    }
}