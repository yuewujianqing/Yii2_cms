<?php
/**
 * User: my
 * Time: 2019/5/13 13:12
 */

namespace backend\libs;

use Yii;

class Util
{
    /**
     * 终止并完成http请求；客户端终止等待完成请求
     * 后续代码可以继续运行；例如日志、统计等代码；后续输出将不再生效；
     */
    public function http_close(){
        self::ignore_timeout();
        if(function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } else {
            header("Connection: close");
            header("Content-Length: ".ob_get_length());
            ob_start();
            echo str_pad('',1024*5);
            ob_end_flush();
            flush();
        }
    }

    /**
     * 设置超时时间和内存限制
     */
    public static function ignore_timeout(){
        @ignore_user_abort(true);
        @ini_set("max_execution_time",48 * 60 * 60);
        @set_time_limit(48 * 60 * 60);//set_time_limit(0)  2day
        @ini_set('memory_limit', '4000M');//4G;
    }

    /**
     * 根据QQ号获取用户名和头像等信息
     * @param $qq
     * @return mixed
     */
    public static function getUserInfoByQq($qq)
    {
        $url = 'http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=' . $qq;
        $data = file_get_contents($url);
        $data = iconv('GB2312', 'UTF-8', $data);
        $pattern =  '/portraitCallBack\((.*)\)/is';
        preg_match($pattern, $data, $result);
        $res = $result[1];
        $res = json_decode($res, true);
        return $res;
    }

    /**
     * 通过淘宝（阿里云）接口，根据ip获取地理位置接口
     * @param $ip
     * @return mixed  // 国家 、省（自治区或直辖市）、市（县）、运营商
     */
    public static function getAddressByTaoBao($ip)
    {
        $url = 'http://ip.aliyun.com/service/getIpInfo.php?ip=' . $ip;
        $data = file_get_contents($url);
        return json_decode($data, true);
    }

    /**
     * 通过腾讯地图接口获取地址位置
     * @param $ip
     * @return bool|mixed|string  // 国家 、省（自治区或直辖市）、市 、区
     */
    public static function getLocationByTencentMap($ip)
    {
        $appKey = 'WALBZ-3HPCW-UQJRW-RUXPQ-ME3E2-GLBGK';
        $url = "https://apis.map.qq.com/ws/location/v1/ip?ip={$ip}&key={$appKey}";
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        return $res;
    }

    /**
     * 记录日志
     * @param $fileName
     * @param $log
     */
    public static function writeLog($fileName, $log)
    {
        $logFile = Yii::getAlias('@backend') . "/runtime/logs/{$fileName}.log";
        $content = date('Y-m-d H:i:s') . $log . "\r\n";
        if (filesize($logFile < 1024 * 1024 * 5)) { // 5M
            file_put_contents($logFile, $content, FILE_APPEND);
        } else {
            file_put_contents($logFile, $content);
        }
    }

    /**
     * 获取文章第一张图片做为缩略图
     * @param $content
     * @return bool|string
     */
    public static function getArticleThumb($content)
    {
        $content = stripslashes($content);
        if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
            $str = $matches[3][0];
            $str = substr($str, 6);
            if (preg_match('/upload/', $str)) {
                return $str;
            }
        }
        return '';
    }


}
