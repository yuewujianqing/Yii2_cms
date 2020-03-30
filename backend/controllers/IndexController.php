<?php
/**
 * User: my
 * Time: 2019/2/2 16:52
 */

namespace backend\controllers;

use backend\models\Menu;
use backend\models\Role;
use backend\models\Route;
use backend\models\Submenu;
use backend\models\User;
use Yii;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        $menu = $this->getMenu();
        return $this->render('index', compact('menu'));
    }

    public function actionWelcome()
    {
        $user = User::findOne(Yii::$app->user->getId());
        $role = Role::findOne($user->role_id);
        $sys = [];
        $sys['yiiVersion'] = Yii::getVersion();
        $sys['serverAddress'] = Yii::$app->request->hostName;
        $sys['os'] = php_uname('s'); // or PHP_OS
        $sys['environment'] = $_SERVER['SERVER_SOFTWARE'];
        $sys['phpVersion'] = PHP_VERSION;
        $sys['operationMode'] = PHP_SAPI;
        $sys['mysqlVersion'] = Yii::$app->db->getServerVersion();
        $sys['uploadLimit'] = ini_get('upload_max_filesize');
        $sys['execTime'] = ini_get('max_execution_time');
        $sys['freeSpace'] = number_format(disk_free_space("/") / 1024 / 1024 / 1024, 2);
        return $this->render('welcome', compact('user', 'role', 'sys'));
    }

    public function actionClearCache()
    {
        $cache = Yii::$app->cache;
        $res = $cache->flush();
        if (!$res) {
            return $this->json(100, '清除失败');
        }
        return $this->json(200, '清除成功');
    }

    /**
     * 获取权限菜单（并存入缓存）
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public function getMenu()
    {
        $user = User::findOne(Yii::$app->user->getId());
        $role = Role::findOne($user->role_id);
        $menu = Yii::$app->cache->get('menu' . $user->role_id);
        if ($menu)  return $menu;
        $permission = json_decode($role->permission);
        $model = new Menu();
        $submenuIdArr = $model->getUserSubmenuIdArr();
        $submenus = Submenu::find()->where(['in', 'id', $submenuIdArr])->asArray()->all();
        $menuIdArr = array_column($submenus, 'menu_id');
        $menuIdArr = array_unique($menuIdArr);
        $menu = Menu::find()->joinWith('submenu')
            ->where(['my_menu.is_show' => 1])
            ->andWhere(['in', 'my_menu.id', $menuIdArr])
            ->orderBy('my_menu.sort desc')
            ->asArray()->all();
        foreach ($menu as &$list) {
            foreach ($list['submenu'] as &$item) {
                $item['rule'] = Route::find()->where(['submenu_id' => $item['id']])
                    ->andWhere(['status' => 1])
                    ->andWhere(['in', 'id', $permission])
                    ->asArray()->all();
            }
        }
        Yii::$app->cache->set('menu' . $user->role_id, $menu);
        return $menu;
    }



}