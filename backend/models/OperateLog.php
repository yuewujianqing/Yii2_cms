<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "my_operate_log".
 *
 * @property string $id 操作日志表
 * @property int $user_id 用户id
 * @property string $route_name 路由名
 * @property string $route 路由
 * @property string $param 参数
 * @property int $create_time 创建时间
 */
class OperateLog extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_operate_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'create_time'], 'integer'],
            [['route_name', 'route'], 'string', 'max' => 100],
            [['param'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'route_name' => '路由名',
            'route' => '路由',
            'param' => '参数',
            'create_time' => '创建时间',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function create($userId, $routeName, $route, $param)
    {
        $this->user_id = $userId;
        $this->route_name = $routeName;
        $this->route = $route;
        $this->param = json_encode($param, JSON_UNESCAPED_UNICODE);
        $this->create_time = time();
        $this->save(false);
    }
}
