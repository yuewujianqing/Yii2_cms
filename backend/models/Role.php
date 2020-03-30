<?php

namespace backend\models;

/**
 * This is the model class for table "my_role".
 *
 * @property string $id 用户角色表
 * @property string $name 角色名
 * @property string $description 角色描述
 * @property string $permission 权限
 * @property int $create_time 创建时间
 */
class Role extends Base
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['permission'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '角色名',
            'description' => '描述',
            'permission' => '权限',
            'create_time' => '创建时间',
        ];
    }

    public function create($data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->permission = json_encode($data['ids']);
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
        $model->name = $data['name'];
        $model->description = $data['description'];
        $model->permission = json_encode($data['ids']);
        $model->create_time = time();
        if (!$model->save()) {
            $error = array_values($model->getFirstErrors())[0];
            return $this->arrData(100, $error);
        }
        return $this->arrData(200, '更新成功');
    }


}
