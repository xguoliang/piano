<?php

ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ALL ^ E_DEPRECATED);

require_once "./application/third_party/wxpay/lib/WxPay.Api.php";
require_once './application/third_party/wxpay/lib/WxPay.Notify.php';
require_once './application/third_party/wxpay/example/log.php';
//require_once "./application/third_party/sms/TopSdk.php";
//初始化日志
$logHandler = new CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify {

    //查询订单
    public function Queryorder($transaction_id) {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg) {
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }
        $dsn='mysql:host='.$_SERVER['database_config']['hostname'].';dbname='.$_SERVER['database_config']['database'];
        $username='root';
        $passwd=$_SERVER['database_config']['password'];
        $pdo=new PDO($dsn,$username,$passwd);
        $pdo->query('set names utf8;');
        date_default_timezone_set('Asia/Shanghai');
        $datetime = (string) date("Y-m-d H:i:s");
//        mysql_query("insert into test(text,time) values ('进入回调','$datetime')");
        $orders = $pdo->query('select * from orders where order_sign_no = "'. $data['out_trade_no'].'"')->fetchAll(PDO::FETCH_ASSOC);

        foreach($orders as $k=>$order){
            if ($order['is_pay'] == 0) {
                $str = $order['order_no'].',';
                date_default_timezone_set('Asia/Shanghai');
                $pdo->query('update orders set pay_method=2,is_pay = 1,status=2,pay_time="'.time().'",pay_no="'.$data['transaction_id'].'" where id = "'.$order['id'].'"');
                //根据支付宝返回信息改变用户积分
            }
        }

        $user_id = $orders[0]['user_id'];
        $message = array(
            'user_id' => $user_id,
            'title' => '支付成功！',
            'desc' => '您订单号为'.substr($str,0,-1).'的订单支付成功!',
            'is_read' => 0,
            'add_time' => date("Y-m-d H:i:s",time())
        );
        $pdo->exec("insert into message (user_id,title,`desc`,is_read,add_time) values ('".$message['user_id']."','".$message['title']."','".$message['desc']."',0,'".$message['add_time']."')");
        return true;
    }

    function PushData($managerid, $orderno, $price, $name, $address, $datetime, $token) {

        $qysend = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $token;
        $qrcode = '{"touser":"' . $managerid . '","template_id":"uqT5pj-D-HkMKGotnIXoARYVNqJ4G25F2HKxVJkyfTI","url":"' . $_SERVER['HTTP_HOST'] . '/index.php/User/Order/OrderList?1",            
                                "data":{
                                "first": {"value":"恭喜你支付成功！","color":"#173177"},
                                "keyword1":{"value":"' . $orderno . '","color":"#173177"},
                                "keyword2": {"value":"中钓协会商城","color":"#173177"},
                                "keyword3": {"value":"商城物品","color":"#173177"},
                                "keyword4": {"value":"' . $price . '","color":"#173177"},
                                "keyword5": {"value":"' . $datetime . '","color":"#173177"},
                                "remark":{"value":"如有其它问题,请咨询电话:400-8888-888","color":"#173177"}
           }
       }';
//        mysql_query("insert into test (name,time) values ('发送前','$datetime')");
        $result = $this->send_post($qysend, $qrcode);
//        mysql_query("insert into test (name,time) values ('$result','$datetime')");
    }

    function PushAdmin($managerid, $orderno, $price, $name, $address, $datetime, $token) {

        $qysend = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $token;
        $qrcode = '{"touser":"' . $managerid . '","template_id":"uqT5pj-D-HkMKGotnIXoARYVNqJ4G25F2HKxVJkyfTI","url":"' . $_SERVER['HTTP_HOST'] . '/index.php/User/Order/OrderList",            
                                "data":{
                                "first": {"value":"有新订单！","color":"#173177"},
                                "keyword1":{"value":"' . $orderno . '","color":"#173177"},
                                "keyword2": {"value":"中钓协会商城","color":"#173177"},
                                "keyword3": {"value":"商城物品","color":"#173177"},
                                "keyword4": {"value":"' . $price . '","color":"#173177"},
                                "keyword5": {"value":"' . $datetime . '","color":"#173177"},
                                "remark":{"value":"有新订单，快去发货。","color":"#173177"}
           }
       }';
        $this->send_post($qysend, $qrcode);
    }

    function send_post($url, $post_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
