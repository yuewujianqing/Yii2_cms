<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "my_set".
 *
 * @property string $id 系统设置表
 * @property string $key 键
 * @property string $desc 描述
 * @property string $value 值
 * @property int $type 类型 1:文本 2:图片
 */
class Set extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'my_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['key'], 'string', 'max' => 50],
            [['key'], 'unique'],
            [['desc', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => '键',
            'desc' => '描述',
            'value' => '值',
            'type' => '类型',
        ];
    }
}
