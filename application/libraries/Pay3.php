<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "./application/third_party/wxpay/lib/WxPay.Api_vip.php";
require_once "./application/third_party/wxpay/example/WxPay.NativePay_vip.php";
require_once './application/third_party/wxpay/example/log.php';

class Pay3
{
    public function Pay($order_id)
    {
        $dsn='mysql:host=localhost;dbname=station';
        $username='root';
        $passwd='Jia123';
        $pdo=new PDO($dsn,$username,$passwd);

        $order = $pdo->query('select * from `orders` where id = "' . $order_id . '"')->fetch(PDO::FETCH_ASSOC  );
        $price = $order['amount']*100;
        $order_no = $order['order_no'];
        $notify = new NativePay();

//模式二
        /**
         * 流程：
         * 1、调用统一下单，取得code_url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、支付完成之后，微信服务器会通知支付成功
         * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
         */
        $input = new WxPayUnifiedOrder();
        $input->SetBody("购买商品");
        $input->SetAttach("购买商品");
        $input->SetOut_trade_no($order_no);
        $input->SetTotal_fee($price);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url($_SERVER['wxpay_config_vip']['notify_url']);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order_no);
        $result = $notify->GetPayUrl($input);
        $url2 = $result["code_url"];
        return $url2;
    }

}
?>
