<?php
/**
 * User: my
 * Time: 2019/3/26 19:12
 */

namespace backend\controllers;


use backend\models\Set;
use common\models\UploadForm;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class SetController extends BaseController
{
    public function actionIndex()
    {
        $texts = Set::find()->where(['type' => 1])->all();
        $images = Set::find()->where(['type' => 2])->all();
        return $this->render('index', compact('texts', 'images'));
    }

    public function actionChangeText()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $set = Set::findOne($post['id']);
            if (!$set) {
                return $this->json(100, '参数错误');
            }
            $set->value = $post['val'];
            if (!$set->save()) {
                return $this->json(100, '修改失败');
            }
            return $this->json(200, '修改成功');
        }
    }

    public function actionChangeImg()
    {
        if (Yii::$app->request->isPost) {
            $model = new UploadForm();
            $model->imageFile = UploadedFile::getInstanceByName('file');
            $res = $model->upload();
            if ($res['status'] == 200) {
                return $this->json(200, '上传成功', $res['path']);
            } else {
                return $this->json(100, $res['msg']);
            }
        }
        if (Yii::$app->request->isGet) {
            $get = Yii::$app->request->get();
            $set = Set::findOne($get['id']);
            if (!$set) {
                return $this->json(100, '参数错误');
            }
            $set->value = $get['val'];
            if (!$set->save()) {
                return $this->json(100, '修改失败');
            }
            return $this->json(200, '修改成功');
        }
    }


}