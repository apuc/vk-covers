<?php
/**
 * Created by PhpStorm.
 * User: Офис
 * Date: 05.04.2016
 * Time: 13:58
 */

namespace common\classes;


use Yii;

class UserFunction
{
    public static function getRole_user(){
        $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        return $role;
    }
}