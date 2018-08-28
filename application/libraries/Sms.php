<?php

include APPPATH . "third_party/sms/TopSdk.php";
require './config.php';

class Sms {

    public function smss($appkey, $secret, $type, $phone, $name) {
        global $sms_config;
        $c = new TopClient;
        $c->appkey = $_SERVER['sms_config']['appkey'];
        $c->secretKey = $_SERVER['sms_config']['secretkey'];
        if ($type == 1) {
            $code = $this->GetRandStr(4);
            $_SESSION['vcode'] = $code;
            $this->sendcode($c, $code, $phone, "SMS_62515684");
        } else if ($type == 2) {
            $this->sendnotice($c, $phone, "SMS_65060046");
        } else {
            $this->sendnotices($c, $phone, $name, $sms_id);
        }
    }

    function GetRandStr($len) {
        $chars = array("0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }

    function sendcode($c, $code, $phone, $sms_id) {
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("智休软件");
        $param = "{code:'$code'}";
        $req->setSmsParam("$param");
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($sms_id);
        $resp = $c->execute($req);
        return json_encode($resp);
    }

    function sendnotice($c, $phone, $sms_id) {
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("智休软件");
        $req->setSmsParam("");
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($sms_id);
        $resp = $c->execute($req);
        return json_encode($resp);
    }

    function sendnotices($c, $phone, $name, $sms_id) {
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("智休软件");
        $param = "{nickname:'$name'}";
        $req->setSmsParam("$param");
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($sms_id);
        $resp = $c->execute($req);
        return json_encode($resp);
    }

}

?>