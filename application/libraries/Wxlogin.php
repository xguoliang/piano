<?php

include_once APPPATH . "third_party/wechat_login/wxBizDataCrypt.php";

class Wxlogin {

    public function Login($appid, $sessionKey, $encryptedData, $iv) {
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);

        return $errCode;
//        if ($errCode == 0) {
//            print($data . "\n");
//        } else {
//            print($errCode . "\n");
//        }
    }

}

?>