<?php
/**
 * User: my
 * Time: 2019/3/4 15:13
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Base extends ActiveRecord
{
    /**
     * 返回数组信息
     * @param $status
     * @param $msg
     * @return array
     */
    public function arrData($status, $msg)
    {
        return ['status' => $status, 'msg' => $msg];
    }
}