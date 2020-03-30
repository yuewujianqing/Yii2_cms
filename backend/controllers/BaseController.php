<?php
/**
 * User: my
 * Time: 2019/2/2 16:52
 */

namespace backend\controllers;


use backend\models\OperateLog;
use backend\models\Role;
use backend\models\Route;
use backend\models\User;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
            return false;
        }
        $user = User::findOne(Yii::$app->user->getId());
        $role = Role::findOne(['id' => $user->role_id]);
        $permission = json_decode($role->permission);
        $routes = Route::find()->where(['in', 'id', $permission])->asArray()->all();
        $permissionArr = array_column($routes, 'route');
        $allowUrl = ['index/index', 'index/welcome', 'index/clear-cache'];
        if (!in_array($this->route, $allowUrl)  && !in_array($this->route, $permissionArr)) {
            echo $this->json(100, '抱歉，没有权限');
            return false;
        }
        $allowRoute = ['menu/route', 'menu/submenu'];
        if (!in_array($this->action->id, ['index', 'view']) && !in_array($this->route, $allowUrl) && !in_array($this->route,
                $allowRoute)) {
            $route = Route::findOne(['route' => $this->route]);
            $operateLog = new OperateLog();
            $operateLog->create(Yii::$app->user->getId(), $route->route_name, $this->route, $_REQUEST);
        }
        return parent::beforeAction($action);
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
            return json_encode(['status' => $status, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['status' => $status, 'msg' => $msg], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 返回数组信息
     * @param $status
     * @param $msg
     * @return array
     */
    public function arrData($status, $msg)
    {
        return ['status' => $status, 'msg' => $msg];
    }

    /**
     * CSV文件导出
     * @param $data
     * @param string $name
     */
    public function csvExport($data, $name = '')
    {
        $csvFileName = $name ? $name . '.csv' : date('YmdHis') . rand(111111, 999999) . '.csv';
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $csvFileName . '"');
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Expires: Mon,26 Jul 1997 05:00:00 GMT');
        header('Content-Transfer-Encoding: binary');
        echo implode("\r\n", $data);
        exit;
    }

    /**
     * 调试函数（支持语法高亮）
     */
    public function dd(){
        $param = func_get_args();
        foreach ($param as $p)  {
            VarDumper::dump($p, 10, true);
        }
        exit(1);
    }
}