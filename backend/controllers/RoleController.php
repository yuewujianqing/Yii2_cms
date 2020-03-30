<?php
/**
 * User: my
 * Time: 2019/3/16 14:39
 */

namespace backend\controllers;

use backend\models\Role;
use backend\models\Submenu;
use backend\models\User;
use Yii;
use yii\data\Pagination;

class RoleController extends BaseController
{
    public function actionIndex()
    {
        $query = Role::find();
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
        $submenus = Submenu::find()->joinWith('route')
            ->where(['is_show' => 1])->orderBy('sort desc')
            ->asArray()->all();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!isset($post['ids'])) {
                return $this->json(100, '拥有权限不能为空');
            }
            $post['ids'] = array_values($post['ids']);
            foreach ($post['ids'] as &$val) {
                $val = (int)$val;
            }
            $model = new Role();
            $res = $model->create($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('create', compact('submenus'));
    }

    public function actionUpdate()
    {
        $id = (int)Yii::$app->request->get('id');
        $role = Role::findOne($id);
        $submenus = Submenu::find()->joinWith('route')
            ->where(['is_show' => 1])->orderBy('sort desc, id desc')
            ->asArray()->all();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!isset($post['ids'])) {
                return $this->json(100, '拥有权限不能为空');
            }
            $post['ids'] = array_values($post['ids']);
            foreach ($post['ids'] as &$val) {
                $val = (int)$val;
            }
            $model = new Role();
            $res = $model->edit($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('update', compact('submenus', 'role'));
    }

    public function actionDel()
    {
        $id = (int)Yii::$app->request->get('id');
        if ($id == 1) {
            return $this->json(100, '超级管理员不能删除');
        }
        $user = User::findOne(Yii::$app->user->getId());
        if ($id == $user->role_id) {
            return $this->json(100, '不能删除自身所属的角色');
        }
        $model = User::findOne(['role_id' => $id]);
        if ($model) {
            return $this->json(100, '该角色下含有用户，不能删除');
        }
        $model = Role::findOne($id);
        $res = $model->delete();
        if (!$res) {
            return $this->json(100, '删除失败');
        }
        return $this->json(200, '删除成功');
    }

    public function actionBatchDel()
    {
        $idArr = Yii::$app->request->get('idArr');
        if (in_array(1, $idArr)) {
            return $this->json(100, '超级管理员不能删除');
        }
        $user = User::findOne(Yii::$app->user->getId());
        if (in_array($user->role_id, $idArr)) {
            return $this->json(100, '不能删除自身所属的角色');
        }
        foreach ($idArr as $id) {
            $model = User::findOne(['role_id' => $id]);
            if ($model) {
                return $this->json(100, '该角色下含有用户，不能删除');
            }
        }
        $res = Role::deleteAll(['in', 'id', $idArr]);
        if (!$res) {
            return $this->json(100, '批量删除失败');
        }
        return $this->json(200, '批量删除成功');
    }

}