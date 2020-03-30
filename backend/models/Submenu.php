<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "my_submemu".
 *
 * @property string $id 子菜单表
 * @property int $menu_id 主菜单id
 * @property string $route_name 子菜单名
 * @property string $route 路由
 * @property int $sort 排序
 * @property int $is_show 是否显示 1:显示 2:隐藏
 * @property int $create_time 创建时间
 */
class Submenu extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_submenu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id', 'sort', 'is_show', 'create_time'], 'integer'],
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
            'menu_id' => 'Menu ID',
            'route_name' => '子菜单名',
            'route' => '路由',
            'sort' => '排序',
            'is_show' => '是否显示',
            'create_time' => '创建时间',
        ];
    }

    public function create($data)
    {
        $this->menu_id = $data['menu_id'];
        $this->route_name = $data['route_name'];
        $this->route = $data['route'];
        if (!$data['sort']) {
            $data['sort'] = 10;
        }
        $this->sort = $data['sort'];
        $this->is_show = $data['is_show'];
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
        $model->is_show = $data['is_show'];
        if (!$data['sort']) {
            $data['sort'] = 10;
        }
        $model->sort = $data['sort'];
        if (!$model->save()) {
            $error = array_values($model->getFirstErrors())[0];
            return $this->arrData(100, $error);
        }
        return $this->arrData(200, '更新成功');
    }

    public function getRoute()
    {
        return $this->hasMany(Route::className(), ['submenu_id' => 'id']);
    }


}
