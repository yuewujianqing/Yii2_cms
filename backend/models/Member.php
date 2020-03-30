<?php

namespace backend\models;

use Yii;
/**
 * This is the model class for table "my_member".
 *
 * @property string $id 前台用户表
 * @property string $nickname 昵称
 * @property string $tel 手机号
 * @property string $password 密码
 * @property string $email 邮箱
 * @property int $status 状态 1:启用 2:禁用
 * @property int $create_time 创建时间
 */
class Member extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'create_time'], 'integer'],
            [['nickname', 'password', 'email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 15],
            [['tel', 'email'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => '昵称',
            'tel' => '手机号码',
            'password' => '密码',
            'email' => '邮箱',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }

    public function create($data)
    {
        $this->nickname = $data['nickname'];
        $this->email = $data['email'];
        $this->tel = $data['tel'];
        $this->password = Yii::$app->security->generatePasswordHash($data['pwd']);
        $this->status = $data['status'];
        $this->create_time = time();
        if (!$this->save()) {
            $error = array_values($this->getFirstErrors())[0];
            return $this->arrData(100, $error);
        }
        return $this->arrData(200, '添加成功');
    }

    public function edit($data)
    {
        $model = self::findOne($data['id']);
        $model->nickname = $data['nickname'];
        $model->email = $data['email'];
        $model->tel = $data['tel'];
        $model->status = $data['status'];
        if ($data['pwd']) {
            $model->password = Yii::$app->security->generatePasswordHash($data['pwd']);
        }
        if (!$model->save()) {
            $error = array_values($model->getFirstErrors())[0];
            return $this->arrData(100, $error);
        }
        return $this->arrData(200, '更新成功');
    }

}
