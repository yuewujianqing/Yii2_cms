<?php
/**
 * User: my
 * Time: 2019/3/22 9:44
 */

namespace backend\controllers;

use backend\models\Menu;
use backend\models\Route;
use backend\models\Submenu;
use Yii;
use yii\data\Pagination;

class MenuController extends BaseController
{
    public function actionIndex()
    {
        $query = Menu::find();
        $search = Yii::$app->request->get('search');
        $query = $this->condition($query, $search);
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 10,
        ]);
        $models = $query
            ->orderBy('id desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index', compact('models', 'pagination', 'search'));
    }

    public function condition($query, $search)
    {
        if (isset($search['name']) && $search['name']) {
            $query = $query->andWhere(['like', 'name', $search['name']]);
        }
        if (isset($search['b_time']) && $search['b_time']) {
            $bTime = strtotime($search['b_time'] . ' 00:00:00');
            $query = $query->andWhere(['>=', 'create_time', $bTime]);
        }
        if (isset($search['e_time']) && $search['e_time']) {
            $eTime = strtotime($search['e_time'] . ' 23:59:59');
            $query = $query->andWhere(['<=', 'create_time', $eTime]);
        }
        return $query;
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $menu = new Menu();
            $res = $menu->create($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('create');
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $menu = Menu::findOne($id);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $menu = new Menu();
            $res = $menu->edit($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('update', compact('menu'));
    }


    public function actionDel()
    {
        $id = (int)Yii::$app->request->get('id');
        $submenu = Submenu::findOne(['menu_id' => $id]);
        if ($submenu) {
            return $this->json(100, '含有子菜单，禁止删除');
        }
        $model = Menu::findOne($id);
        $res = $model->delete();
        if (!$res) {
            return $this->json(100, '删除失败');
        }
        return $this->json(200, '删除成功');
    }

    public function actionBatchDel()
    {
        $idArr = Yii::$app->request->get('idArr');
        foreach ($idArr as $id) {
            $submenu = Submenu::findOne(['menu_id' => $id]);
            if ($submenu) {
                return $this->json(100, '含有子菜单，禁止删除');
            }
        }
        $res = Menu::deleteAll(['in', 'id', $idArr]);
        if (!$res) {
            return $this->json(100, '批量删除失败');
        }
        return $this->json(200, '批量删除成功');
    }

    public function actionSubmenu()
    {
        $id = (int)Yii::$app->request->get('id');
        $query = Submenu::find()->where(['menu_id' => $id]);
        $models = $query->all();
        $count = $query->count();
        return $this->render('submenu', compact('models', 'count', 'id'));
    }

    public function actionSubmenuCreate()
    {
        $menuId = Yii::$app->request->get('menu_id');
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Submenu();
            $res = $model->create($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('submenu-create', compact('menuId'));
    }

    public function actionSubmenuUpdate()
    {
        $id = Yii::$app->request->get('id');
        $model = Submenu::findOne($id);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Submenu();
            $res = $model->edit($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('submenu-update', compact('model'));
    }

    public function actionSubmenuDel()
    {
        $id = (int)Yii::$app->request->get('id');
        $route = Route::findOne(['submenu_id' => $id]);
        if ($route) {
            return $this->json(100, '含有子路由，禁止删除');
        }
        $model = Submenu::findOne($id);
        $res = $model->delete();
        if (!$res) {
            return $this->json(100, '删除失败');
        }
        return $this->json(200, '删除成功');
    }

    public function actionSubmenuBatchDel()
    {
        $idArr = Yii::$app->request->get('idArr');
        foreach ($idArr as $id) {
            $route = Route::findOne(['submenu_id' => $id]);
            if ($route) {
                return $this->json(100, '含有子路由，禁止删除');
            }
        }
        $res = Submenu::deleteAll(['in', 'id', $idArr]);
        if (!$res) {
            return $this->json(100, '批量删除失败');
        }
        return $this->json(200, '批量删除成功');
    }

    public function actionRoute()
    {
        $id = (int)Yii::$app->request->get('id');
        $query = Route::find()->where(['submenu_id' => $id]);
        $models = $query->all();
        $count = $query->count();
        return $this->render('route', compact('models', 'count', 'id'));
    }

    public function actionRouteCreate()
    {
        $submenuId = Yii::$app->request->get('submenu_id');
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Route();
            $res = $model->create($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('route-create', compact('submenuId'));
    }

    public function actionRouteUpdate()
    {
        $id = Yii::$app->request->get('id');
        $model = Route::findOne($id);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Route();
            $res = $model->edit($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('route-update', compact('model'));
    }

    public function actionRouteDel()
    {
        $id = (int)Yii::$app->request->get('id');
        $model = Route::findOne($id);
        $res = $model->delete();
        if (!$res) {
            return $this->json(100, '删除失败');
        }
        return $this->json(200, '删除成功');
    }

    public function actionRouteBatchDel()
    {
        $idArr = Yii::$app->request->get('idArr');
        $res = Route::deleteAll(['in', 'id', $idArr]);
        if (!$res) {
            return $this->json(100, '批量删除失败');
        }
        return $this->json(200, '批量删除成功');
    }



}