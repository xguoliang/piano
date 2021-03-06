<?php

require_once "./application/third_party/wxpay/lib/WxPay.Api_vip.php";
require_once "./application/third_party/wxpay/example/WxPay.JsApiPay_vip.php";
require_once './application/third_party/wxpay/example/log.php';
class Pay {

    public function pays($orderno, $price, $notifyurl) {
        $logHandler = new CLogFileHandler("./application/third_party/wxpay/logs/" . date('Y-m-d') . '.log');
        $log = Log::Init($logHandler, 15);

//打印输出数组信息
        function printf_info($data) {
            foreach ($data as $key => $value) {
                echo "<font color='#00ff55;'>$key</font> : $value <br/>";
            }
        }

//①、获取用户openid
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();
//$openId = $_GET['openid'];
//②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
//$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetOut_trade_no($orderno);
        $input->SetTotal_fee($price);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url($notifyurl);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>正在开启微信支付</b></font><br/>';
//printf_info($order);exit;
        $data['jsApiParameters'] = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
        $data['editAddress'] = $tools->GetEditAddressParameters();

        return $data;
    }

}

?>