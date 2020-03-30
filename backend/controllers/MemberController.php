<?php
/**
 * User: my
 * Time: 2019/2/2 17:44
 */

namespace backend\controllers;

use backend\models\Member;
use Yii;
use yii\data\Pagination;

class MemberController extends BaseController
{
    public function actionIndex()
    {
        $query = Member::find();
        $search = Yii::$app->request->get('search');
        $query = $this->condition($query, $search);
        $countQuery = clone $query;
        $pagination = new Pagination([
           'totalCount' => $countQuery->count(),
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
        if (isset($search['nickname']) && $search['nickname']) {
            $query = $query->andWhere(['like', 'nickname', $search['nickname']]);
        }
        if (isset($search['tel']) && $search['tel']) {
            $query = $query->andWhere(['like', 'tel', $search['tel']]);
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
            $model = new Member();
            $res = $model->create($post);
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
        $model = Member::findOne($id);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Member();
            $res = $model->edit($post);
            if ($res['status'] != 200) {
                return $this->json(100, $res['msg']);
            }
            return $this->json(200, $res['msg']);
        }
        return $this->render('update', compact('model'));
    }

    public function actionChangeStatus()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $member = Member::findOne($post['id']);
            $status = $post['status'] == 1 ? 2 : 1;
            $member->status = $status;
            if (!$member->save(false)){
                return $this->json(100, '操作失败');
            }
            return $this->json(200, '操作成功');
        }
    }

    public function actionDel()
    {
        $id = (int)Yii::$app->request->get('id');
        $model = Member::findOne($id);
        $res = $model->delete();
        if (!$res) {
            return $this->json(100, '删除失败');
        }
        return $this->json(200, '删除成功');
    }

    public function actionBatchDel()
    {
        $idArr = Yii::$app->request->get('idArr');
        $res = Member::deleteAll(['in', 'id', $idArr]);
        if (!$res) {
            return $this->json(100, '批量删除失败');
        }
        return $this->json(200, '批量删除成功');
    }

    public function actionExport()
    {
        $search = Yii::$app->request->get('search');
        $query = Member::find();
        $query = $this->condition($query, $search);
        $data = $query->all();
        $header = ['ID', '昵称', '手机号码', '邮箱', '创建时间', '状态'];
        $list[] = implode(',', $header);
        if ($data) {
            foreach ($data as $val) {
                $item = [
                    $val->id,
                    $val->nickname,
                    $val->tel,
                    $val->email,
                    date('Y-m-d H:i:s', $val->create_time),
                    $val->status == 1 ? '启用' : '禁用',
                ];
                $list[] = implode(',', $item);
            }
        }
        $fileName = '用户列表_' . date('Y-m-d H:i');
        return $this->csvExport($list, $fileName);
    }
    
}