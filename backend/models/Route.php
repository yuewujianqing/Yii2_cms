<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "my_route".
 *
 * @property string $id 路由表
 * @property int $submenu_id 子菜单id
 * @property string $route_name 路由名
 * @property string $route 路由
 * @property int $status 状态 1:启用 2:禁用
 * @property int $create_time 创建时间
 */
class Route extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submenu_id', 'status', 'create_time'], 'integer'],
            [['route_name', 'route'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'submenu_id' => '子菜单 ID',
            'route_name' => '路由名',
            'route' => '路由',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }

    public function create($data)
    {
        $this->submenu_id = $data['submenu_id'];
        $this->route_name = $data['route_name'];
        $this->route = $data['route'];
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
        $model->route_name = $data['route_name'];
        $model->route = $data['route'];
        $model->status = $data['status'];
        if (!$model->save()) {
            $error = array_values($model->getFirstErrors())[0];
            return $this->arrData(100, $error);
        }
        return $this->arrData(200, '更新成功');
    }

}
