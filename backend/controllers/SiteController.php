<?php
namespace backend\controllers;

use backend\models\LoginLog;
use backend\models\User;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionLogin()
    {

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $user = User::findOne(['name' => $post['name']]);
            $msg = '用户名或密码不正确';
            if (!$user) {
                return $this->json(100, $msg);
            }
            $res = Yii::$app->security->validatePassword($post['password'], $user->password);
            if (!$res) {
                return $this->json(100, $msg);
            }
            if ($user->status == 2) {
                return $this->json(100, '该用户已被禁用，请联系管理员');
            }
            Yii::$app->user->login($user);
            $loginLog = new LoginLog();
            $loginLog->create($user->id);
            return $this->json(200, '登录成功');
        }
        return $this->render('login');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }

    /**
     * ajax 返回json数据
     * @param $status
     * @param $msg
     * @param string $data
     * @return string
     */
    public function json($status, $msg, $data = '')
    {
        if ($data) {
            return json_encode(['status' => $status, 'msg' => $msg, 'data' => $data]);
        } else {
            return json_encode(['status' => $status, 'msg' => $msg]);
        }
    }

}
