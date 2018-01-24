<?php

namespace backend\modules\covers\controllers;

use common\classes\Debug;
use common\classes\RandomImgWidget;
use common\models\db\Covers;
use common\models\db\CoverWidgets;
use common\models\db\VkUserGroups;
use common\models\forms\WidgetForm;
use common\models\VK;
use Yii;
use yii\web\UploadedFile;

class CoversController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = Covers::find()
            ->joinWith('group')
            ->where(['`covers`.`user_id`' => \Yii::$app->user->id])
            ->all();
        return $this->render('index', ['model' => $model]);
    }

    public function actionAddCover()
    {
        $model = new \common\models\forms\CoverAddForm();
        $groups = VkUserGroups::find()->where(['user_id' => \Yii::$app->user->id])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $cover = new Covers();
                $cover->attributes = [
                    'user_id' => \Yii::$app->user->id,
                    'owner_id' => $model->group,
                    'title' => $model->name,
                    'dt_add' => time(),
                ];
                $cover->save();
                return $this->redirect(['index']);
            }
        }

        return $this->render('cover-add-form', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    public function actionDelCover($id)
    {
        Covers::deleteAll(['id' => $id]);
        return $this->redirect(['index']);
    }

    public function actionDelWidget()
    {
        $post = Yii::$app->request->post();
        CoverWidgets::deleteAll(['id' => $post['id']]);
    }

    public function actionEditCover($id)
    {
        $model = Covers::findOne($id);
        $widgets = CoverWidgets::find()->where(['cover_id' => $id])->all();
        return $this->render('edit-cover', ['model' => $model, 'widgets' => $widgets]);
    }

    public function actionLoadCoverImg()
    {
        $post = Yii::$app->request->post();
        $path = Yii::getAlias('@backend/web/covers/' . Yii::$app->user->id);
        is_dir($path) || mkdir($path);
        $file = $_FILES[0];
        $ext = new \SplFileInfo($file['name']);
        $ext = $ext->getExtension();
        $fileName = time() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $path . '/' . $fileName)) {
            $imgUrl = Yii::$app->request->baseUrl . '/covers/' . Yii::$app->user->id . '/' . $fileName;
            if ($post['crop'] == 1) {
                $img = new \Imagick($path . '/' . $fileName);
                $img->cropThumbnailImage(795, 200);
                $img->writeImage($path . '/cropped_' . $fileName);
                $imgUrl = Yii::$app->request->baseUrl . '/covers/' . Yii::$app->user->id . '/cropped_' . $fileName;
            }
            echo json_encode([
                'status' => 200,
                'imgUrl' => $imgUrl,
            ]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Не удалось загрузить файл']);
        }
    }

    public function actionLoadRandomImg()
    {
        $post = Yii::$app->request->post();
        $path = Yii::getAlias('@backend/web/widget_img/' . Yii::$app->user->id);
        is_dir($path) || mkdir($path);
        $file = $_FILES[0];
        $ext = new \SplFileInfo($file['name']);
        $ext = $ext->getExtension();
        $fileName = time() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $path . '/' . $fileName)) {
            $imgUrl = Yii::$app->request->baseUrl . '/widget_img/' . Yii::$app->user->id . '/' . $fileName;
            echo json_encode([
                'status' => 200,
                'imgUrl' => $imgUrl,
            ]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Не удалось загрузить файл']);
        }
    }

    public function actionAddWidget()
    {
        $post = Yii::$app->request->post();
        $model = new CoverWidgets();
        $model->attributes = [
            'cover_id' => $post['coverId'],
            'widget_name' => $post['widgetName'],
            'widget_rus_name' => $post['widgetRusName'],
        ];
        $model->save();
        $widgetForm = new WidgetForm();
        $widgetForm->scenario = $post['widgetName'];
        $data['id'] = $model->id;
        $data['html'] = $this->renderAjax('add-widget', ['model' => $model, 'widgetForm' => $widgetForm, 'imgs' => null]);
        echo json_encode($data);
    }

    public function actionSaveCoverWidgets()
    {
        $post = Yii::$app->request->post();
        foreach ((array)$post['widgets'] as $widget) {
            $model = CoverWidgets::find()->where(['id' => $widget['widgetId']])->one();
            $model->widget_settings = json_encode($widget);
            $model->save();
        }
        $cover = Covers::find()->where(['id' => $post['coverId']])->one();
        $cover->img = $post['coverImg'];
        $cover->save();
    }

    public function actionPreviewCover()
    {
        $post = Yii::$app->request->post();
        $cover = Covers::findOne($post['coverId']);

        $path = Yii::getAlias('@backend/web/covers/' . Yii::$app->user->id);
        $fileName = basename($cover->img);
        $file = $path . '/' . $fileName;
        $coverImg = new \Imagick($file);

        $coverImg = RandomImgWidget::compositeWidgetsToCover($post['coverId'], $coverImg);
        $coverImg->writeImage($path . '/result_' . $fileName);
        $tmpName = '/tmp_' . time() . '_' . $fileName;
        $coverImg->writeImage($path . $tmpName);
        $imgUrl = Yii::$app->request->baseUrl . '/covers/' . Yii::$app->user->id . $tmpName;

        $cover->img_result = Yii::$app->request->baseUrl . '/covers/' . Yii::$app->user->id . '/result_' . $fileName;
        $cover->save();

        if(isset($post['use'])){
            $vk = new VK([
                'client_id' => '6301353',
                'client_secret' => 'jV9DdZuX0bb6sA6E4X8r',
                'access_token' => '51a45c1161c9e972bc6f891a5b56073c6307301c8eec609b1ba93b1eb8bc0b7db7a44300b2e11db0a1d2b',
            ]);
            $vk->addOwnerCoverPhoto($cover->owner_id, $path . '/result_' . $fileName);
        }

        echo json_encode([
            'status' => 200,
            'imgUrl' => $imgUrl,
        ]);
    }

    public function actionTest()
    {
        return $this->render('test');
    }
}
