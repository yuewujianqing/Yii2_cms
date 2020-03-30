<?php
/**
 * User: my
 * Time: 2019/1/21 14:20
 */

namespace backend\libs;

use backend\models\Member;
use Yii;
use yii\helpers\Url;

/**
 * 助手类
 * Class Helper
 * @package frontend\controllers
 */
class Helper
{
    /**
     * 获取系统配置信息
     * @param $key
     * @return string
     */
    public static function getSysInfo($key)
    {
     //   return AdminSystem::findOne(['key' => $key])->content;
    }

    /**
     * 获取上传图片路径
     * @param $uploadPath
     * @return string
     */
    public static function imgUrl($uploadPath)
    {
        $imgUrl = Yii::$app->params['imgUrl'];
        $uploadPath = substr($uploadPath,8);
        $imgUrl = $imgUrl.$uploadPath;
        return $imgUrl;
    }

    /**
     * 获取用户头像地址
     * @return mixed|string
     */
    public static function getHeadImg()
    {
        $headImg = Yii::$app->user->identity->head_img;
        if (!$headImg) {
            return Url::to('@web/images/tx.jpg');
        } else {
            if (strpos($headImg, 'http') !== false) {
                return $headImg;
            } else {
                return Helper::imgUrl($headImg);
            }
        }
    }

    /**
     * 生成唯一邀请码
     * @return bool|string
     */
    public static function getInvitation()
    {
        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $code = substr(str_shuffle($str), 0, 6);
        } while (Member::find()->where(['invite_code' => $code])->count() > 0);//数据库没有该邀请码才返回
        return $code;
    }

    /**
     * 返回数组信息
     * @param $status
     * @param $msg
     * @return array
     */
    public static function arrData($status, $msg)
    {
        return ['status' => $status, 'msg' => $msg];
    }

    /**
     * 判断是否为微信端
     * @return bool
     */
    public static function isWx()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') ? true : false;
    }

    /**
     * 生成二维码
     * @param $text
     * @return mixed
     */
    public static function qrcode($text)
    {
        include Yii::getAlias('@root').'/extend/qrcode/phpqrcode/phpqrcode.php';
        return \QRcode::png($text,false,'H',2,1,true);
    }

    /**
     * 写日志
     * @param $file
     * @param $content
     */
    public static function log($file, $content)
    {
        file_put_contents($file, $content.'<br/>',FILE_APPEND);
    }


    /**
     * 短信接口：腾讯云
     * @param $phone
     * @param $random
     * @return array
     */
    public static function sendSms($phone, $random)
    {
        $appId = Yii::$app->params['sms']['appId'];
        $appKey = Yii::$app->params['sms']['appKey'];
        $tplId = Yii::$app->params['sms']['tplId'];
        $sj = 3;
        $curTime = time();
        $wholeUrl = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid=" . $appId . "&random=" . $random;
        // 按照协议组织 post 包体
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "" . "86";
        $tel->mobile = "" . $phone;
        $data->tel = $tel;
        $data->sig = hash("sha256",
            "appkey=" . $appKey . "&random=" . $random . "&time="
            . $curTime . "&mobile=" . $phone, FALSE);
        $data->tpl_id = $tplId;
        $data->params = array($random, $sj);
        $data->time = $curTime;
        //$data->sign = '云肆网络';//如果只有一个则不需要签名
        $data->extend = '';
        $data->ext = '';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $wholeUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($curl);
        $res = json_decode($ret, true);
        if ($res['errmsg'] == 'OK') { // 发送成功
            return self::arrData(200, '发送成功');
        }else{
            return self::arrData(100, $res['errmsg']);
        }
    }

    /**
     * 银行卡四要素接口：腾讯云
     * @param $mobile
     * @param $bankcard
     * @param $idCard
     * @param $name
     * @return mixed
     */
    public static function bankcard($mobile,$bankcard, $idCard,$name)
    {
        $dateTime = gmdate("I d F Y H:i:s");
        $SecretId = Yii::$app->params['bankcard']['secretId'];
        $SecretKey = Yii::$app->params['bankcard']['secretKey'];
        $srcStr = "date: " . $dateTime . "\n" . "source: " . "bankcard4";
        $Authen = 'hmac id="' . $SecretId . '", algorithm="hmac-sha1", headers="date source", signature="';
        $signStr = base64_encode(hash_hmac('sha1', $srcStr, $SecretKey, true));
        $Authen = $Authen . $signStr . "\"";
        $url = 'https://service-m5ly0bzh-1256140209.ap-shanghai.apigateway.myqcloud.com/release/bank_card4/verify';
        $bodys = "?bankcard=$bankcard&idcard=$idCard&name=$name&mobile=$mobile";
        $headers = array(
            'Host:service-m5ly0bzh-1256140209.ap-shanghai.apigateway.myqcloud.com',
            'Accept:text/html, */*; q=0.01',
            'Source: bankcard4',
            'Date: ' . $dateTime,
            'Authorization: ' . $Authen,
            'X-Requested-With: XMLHttpRequest',
            'Accept-Encoding: gzip, deflate, sdch'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url . $bodys);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $data = curl_exec($ch);
        $result = json_decode($data,true);
        if ($result['code'] != '0') {
            return self::arrData(100, $result['message']);
        }
        if ($result['code'] == '0' && $result['result']['res'] != 1) {
            return self::arrData(100, $result['result']['description']);
        }
        return self::arrData(200, '认证成功');
    }

    /**
     * 创建并提交 POST 表单
     * @param $data
     * @param $url
     * @return string
     */
    public static function buildForm($data, $url)
    {
        $sHtml = "<!DOCTYPE html><html><head><title>Waiting...</title>";
        $sHtml.= "<meta http-equiv='content-type' content='text/html;charset=utf-8'></head>
      <body><form id='submit' name='pay' action='".$url."' method='post'>";
        foreach($data as $key => $value){
            $sHtml.= "<input type='hidden' name='".$key."' value='".$value."' style='width:90%;'/>";
        }
        $sHtml .= "</form>正在提交订单信息...";
        $sHtml .= "<script>document.forms['submit'].submit();</script></body></html>";
        return $sHtml;
    }

    /**
     * 发送 POST 请求
     * @param $url
     * @param $postData
     * @return bool|string
     */
    public static function sendPost($url, $postData) {
        $postData = http_build_query($postData);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postData,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    /**
     * curl 请求
     * @param $url
     * @param int $isPost
     * @param string $dataFields
     * @param string $cookieFile
     * @param bool $v
     * @return mixed
     */
    public static function curl($url, $isPost = 0, $dataFields = '', $cookieFile = '', $v = false) {
        $header = array("Connection: Keep-Alive","Accept: text/html, application/xhtml+xml, */*",
            "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3","User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $v);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $isPost && curl_setopt($ch, CURLOPT_POST, $isPost);
		// $dataFields每个请求方法的数据处理方式都不一样，有原数组，json_encode,hhttp_build_query等。
		// 意味着该方法不能完全通用
        $isPost && curl_setopt($ch, CURLOPT_POSTFIELDS, $dataFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        $cookieFile && curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        $cookieFile && curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
		// https请求
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

    /**
     * 获取短链接
     * @param $longUrl
     * @return bool
     */
    public static function getShortUrl($longUrl)
    {
        $source = '1681459862';
        $apiUrl = "http://api.t.sina.com.cn/short_url/shorten.json?source={$source}&url_long=".urlencode($longUrl);
        $res = self::curl($apiUrl);
        $res = json_decode($res,true);
        $shortUrl = $res[0]['url_short'];
        if($shortUrl){
            return $shortUrl;
        }
        return false;
    }

    /**
     * 根据HTTP请求获取用户位置
     */
    public static function getUserLocation()
    {
        $key = "16199cf2aca1fb54d0db495a3140b8cb"; // 高德地图key
        $url = "http://restapi.amap.com/v3/ip?key=$key";
        $json = file_get_contents($url);
        $obj = json_decode($json, true); // 转换数组
        $obj["message"] = $obj["status"] == 0 ? "失败" : "成功";
        return $obj;
    }

    /**
     * 根据 ip 获取 当前城市
     * @param $ip
     * @return mixed
     */
    public static function getCityByIp($ip)
    {
        $url = 'http://restapi.amap.com/v3/ip';
        $data = array(
            'output' => 'json',
            'key' => '16199cf2aca1fb54d0db495a3140b8cb',
            'ip' => $ip
        );
        $postData = http_build_query($data);
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postData
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        $res = json_decode($result, true);
        if (empty($res['province'])) { // 127.0.0.1 ::1
            $res['province'] = '本地';
            $res['city'] = '本地';
        }
        return $res;
    }

    /**
     * 通过腾讯地图接口获取地址位置（有时定位是错的）
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
     * 获取设备类型（安卓 or 苹果）
     * @return string
     */
    public static function getDeviceType()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $type = 'other';
        if (strpos($agent, 'iphone') || strpos($agent, 'ipad')){
            $type = 'ios';
        }
        if (strpos($agent, 'android')) {
            $type = 'android';
        }
        return $type;
    }

    /**
     * XML 数据转为数组
     * @param $xml
     * @return mixed
     */
    public static function xmlToArray($xml)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    /**
     * 导出excel格式表
     * @param $filename
     * @param $title
     * @param $data
     */
    public static function exportExcelData($filename, $title, $data)
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=" . $filename . ".xls");
        if (is_array($title)) {
            foreach ($title as $key => $value) {
                echo $value . "\t";
            }
        }
        echo "\n";
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                foreach ($value as $_key => $_value) {
                    echo $_value . "\t";
                }
                echo "\n";
            }
        }
    }

    /**
     * 导出csv格式表
     * @param $filename
     * @param $title
     * @param $data
     */
    public static function exportCsvData($filename, $title, $data)
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=" . $filename . ".csv");
        if (is_array($title)) {
            foreach ($title as $key => $value) {
                echo $value . ",";
            }
        }
        echo "\n";
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                foreach ($value as $_key => $_value) {
                    echo $_value . ",";
                }
                echo "\n";
            }
        }
    }

    /**
     * 下载文件(file_get_contents()速度慢，不推荐使用)
     * @param $file
     */
    public static function downloadFile($file)
    {
        $fp = fopen($file, 'rb');
        if ($fp === false) exit('文件不存在或打开失败');

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$file.'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        ob_clean();
        ob_end_flush();
        set_time_limit(0);

        $chunkSize = 1024 * 1024;
        while (!feof($fp)) {
            $buffer = fread($fp, $chunkSize);
            echo $buffer;
            ob_flush();
            flush();
        }
        fclose($fp);
    }

    /**
     * 校验身份证号码
     * @param $number
     * @return bool
     */
    public static function isIdCard($number)
    {
        //加权因子
        $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码串
        $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        //按顺序循环处理前17位
        $sigma = 0;
        for ($i = 0; $i < 17; $i++) {
            //提取前17位的其中一位，并将变量类型转为实数
            $b = (int)$number{$i};
            //提取相应的加权因子
            $w = $wi[$i];
            //把从身份证号码中提取的一位数字和加权因子相乘，并累加
            $sigma += $b * $w;
        }
        //计算序号
        $snumber = $sigma % 11;
        //按照序号从校验码串中提取相应的字符。
        $check_number = $ai[$snumber];
        if ($number{17} == $check_number) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 人性化显示时间
     * @param $time
     * @return false|string
     */
    public static function formatTime($time)
    {
        $formatTime = date("Y-m-d H:i:s", $time);
        $newTime = time() - $time;
        if ($newTime < 60) {
            $str = '刚刚';
        } elseif ($newTime < 60 * 60) {
            $min = floor($newTime / 60);
            $str = $min . '分钟前';
        } elseif ($newTime < 60 * 60 * 24) {
            $h = floor($newTime / (60 * 60));
            $str = $h . '小时前';
        } elseif ($newTime < 60 * 60 * 24 * 3) {
            $d = floor($newTime / (60 * 60 * 24));
            if ($d == 1) {
                $str = '昨天 ' . $formatTime;
            } else {
                $str = '前天 ' . $formatTime;
            }
        } else {
            $str = $formatTime;
        }
        return $str;
    }

    /**
     * 获取用户浏览器类型和版本
     * @return string
     */
    public static function getBrowser()
    {
        $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
        if (stripos($sys, "Firefox/") > 0) {
            preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
            $exp[0] = "Firefox";
            $exp[1] = $b[1];  //获取火狐浏览器的版本号
        } elseif (stripos($sys, "Maxthon") > 0) {
            preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
            $exp[0] = "傲游";
            $exp[1] = $aoyou[1];
        } elseif (stripos($sys, "MSIE") > 0) {
            preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
            $exp[0] = "IE";
            $exp[1] = $ie[1];  //获取IE的版本号
        } elseif (stripos($sys, "OPR") > 0) {
            preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
            $exp[0] = "Opera";
            $exp[1] = $opera[1];
        } elseif (stripos($sys, "Edge") > 0) {
            //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
            preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
            $exp[0] = "Edge";
            $exp[1] = $Edge[1];
        } elseif (stripos($sys, "Chrome") > 0) {
            preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
            $exp[0] = "Chrome";
            $exp[1] = $google[1];  //获取google chrome的版本号
        } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
            preg_match("/rv:([\d\.]+)/", $sys, $IE);
            $exp[0] = "IE";
            $exp[1] = $IE[1];
        } elseif (stripos($sys, 'Safari') > 0) {
            preg_match("/safari\/([^\s]+)/i", $sys, $safari);
            $exp[0] = "Safari";
            $exp[1] = $safari[1];
        } else {
            $exp[0] = "未知浏览器";
            $exp[1] = "";
        }
        return $exp[0] . '(' . $exp[1] . ')';
    }

    /**
     * 获取用户操作系统
     * @return string
     */
    public static function getOs()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
            $os = 'Windows 95';
        } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
            $os = 'Windows ME';
        } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
            $os = 'Windows 98';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
            $os = 'Windows Vista';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
            $os = 'Windows 8';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
            $os = 'Windows 10';#添加win10判断
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
            $os = 'Windows 2000';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
            $os = 'Windows NT';
        } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
            $os = 'Windows 32';
        } else if (preg_match('/linux/i', $agent)) {
            $os = 'Linux';
            if (strpos($agent, 'Android') !== false) {
                preg_match("/(?<=Android )[\d\.]{1,}/", $agent, $version);
                $os = 'Android '.$version[0];
            }
        } else if (preg_match('/unix/i', $agent)) {
            $os = 'Unix';
        } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
            $os = 'SunOS';
        } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
            $os = 'IBM OS/2';
        } else if (preg_match('/Mac/i', $agent)) {
            $os = 'Mac';
            if (strpos($agent, 'iPhone') !== false) {
                preg_match("/(?<=CPU iPhone OS )[\d\_]{1,}/", $agent, $version);
                $os = 'iPhone '.str_replace('_', '.', $version[0]);
            }
            if (strpos($agent, 'iPad') !== false) {
                preg_match("/(?<=CPU OS )[\d\_]{1,}/", $agent, $version);
                $os = 'iPad '.str_replace('_', '.', $version[0]);
            }
        } else if (preg_match('/PowerPC/i', $agent)) {
            $os = 'PowerPC';
        } else if (preg_match('/AIX/i', $agent)) {
            $os = 'AIX';
        } else if (preg_match('/HPUX/i', $agent)) {
            $os = 'HPUX';
        } else if (preg_match('/NetBSD/i', $agent)) {
            $os = 'NetBSD';
        } else if (preg_match('/BSD/i', $agent)) {
            $os = 'BSD';
        } else if (preg_match('/OSF1/i', $agent)) {
            $os = 'OSF1';
        } else if (preg_match('/IRIX/i', $agent)) {
            $os = 'IRIX';
        } else if (preg_match('/FreeBSD/i', $agent)) {
            $os = 'FreeBSD';
        } else if (preg_match('/teleport/i', $agent)) {
            $os = 'teleport';
        } else if (preg_match('/flashget/i', $agent)) {
            $os = 'flashget';
        } else if (preg_match('/webzip/i', $agent)) {
            $os = 'webzip';
        } else if (preg_match('/offline/i', $agent)) {
            $os = 'offline';
        } else {
            $os = '未知操作系统';
        }
        return $os;
    }

    /**
     * 获取全球唯一标识
     * @return string
     */
    public static function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * 保存base64编码的图片
     * @param $base64Str
     * @param $dir
     * @return string
     */
    public static function saveBase64Img($base64Str, $dir)
    {
        is_dir($dir) || mkdir($dir, 0755, true);
        $base64Str = explode(',', $base64Str);
        $data = base64_decode($base64Str[1]);
        $imgName = date('YmdHis') . mt_rand(100000, 999999) . '.png';
        file_put_contents($dir . $imgName, $data);
        return $imgName;
    }

}
