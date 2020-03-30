<?php
/**
 * User: my
 * Date: 2019/3/24
 * Time: 21:57
 */

namespace backend\controllers;

use backend\models\LoginLog;
use Yii;
use yii\data\Pagination;

class LoginLogController extends BaseController
{
    public function actionIndex()
    {
        $query = LoginLog::find()->joinWith('user');
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
            $query = $query->andWhere(['like', 'my_user.name', $search['name']]);
        }
        if (isset($search['ip']) && $search['ip']) {
            $query = $query->andWhere(['like', 'my_login_log.ip', $search['ip']]);
        }
        if (isset($search['b_time']) && $search['b_time']) {
            $bTime = strtotime($search['b_time'] . ' 00:00:00');
            $query = $query->andWhere(['>=', 'my_login_log.create_time', $bTime]);
        }
        if (isset($search['e_time']) && $search['e_time']) {
            $eTime = strtotime($search['e_time'] . ' 23:59:59');
            $query = $query->andWhere(['<=', 'my_login_log.create_time', $eTime]);
        }
        return $query;
    }

    public function actionDel()
    {
        $id = (int)Yii::$app->request->get('id');
        $model = LoginLog::findOne($id);
        $res = $model->delete();
        if (!$res) {
            return $this->json(100, '删除失败');
        }
        return $this->json(200, '删除成功');
    }

    public function actionBatchDel()
    {
        $idArr = Yii::$app->request->get('idArr');
        $res = LoginLog::deleteAll(['in', 'id', $idArr]);
        if (!$res) {
            return $this->json(100, '批量删除失败');
        }
        return $this->json(200, '批量删除成功');
    }

    public function actionView()
    {
        if (Yii::$app->request->isPost) {
            $id = (int)Yii::$app->request->post('id');
            $loginLog = LoginLog::findOne($id);
            if (!$loginLog) {
                return $this->json(100, '该条UA不存在');
            }
            return $this->json(200, '获取成功', $loginLog->user_agent);
        }
    }

}