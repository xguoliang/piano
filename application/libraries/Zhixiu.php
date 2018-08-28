<?php

class Zhixiu {

    public function GetOrderId($count) {
        $count = $count + 1;
        if (strlen($count) == 1) {
            return '0000' . $count;
        } else if (strlen($count) == 2) {
            return '000' . $count;
        } else if (strlen($count) == 3) {
            return '00' . $count;
        } else if (strlen($count) == 4) {
            return '0' . $count;
        } else {
            return $count;
        }
    }

    public function GetDate($format) {
        date_default_timezone_set('Asia/Shanghai');
        $datetime = (string) date($format);
        return $datetime;
    }

    public function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung',
                'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel',
                'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront',
                'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi',
                'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public function del_dir($dir) {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $str = "rmdir /s/q " . $dir;
            exec($str);
        } else {
            $str = "rm -Rf " . $dir;
            exec($str);
        }
        return true;
    }

    public function diffBetweenTwoDays($day1, $day2) {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);
        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }

    public function GetAccessToken($appid, $secret) {
        $this->load->library("jssdk", array('appId' => $appid, 'appSecret' => $secret), 'jssdk');
        $at = json_decode($this->jssdk->get_php_file(APPPATH . "third_party/access_token.php"));
        if ($at->expire_time < time()) {
            $get_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_token_url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $a['open'] = json_decode($res, true);
            $access_token = $a['open']['access_token'];
            if ($access_token) {
                $at->expire_time = time() + 7000;
                $at->access_token = $access_token;
                $this->jssdk->set_php_file(APPPATH . "third_party/access_token.php", json_encode($at));
            }
        } else {
            $access_token = $at->access_token;
        }
        return $access_token;
    }

}

?>