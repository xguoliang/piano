<?php
require './application/libraries/Pay.php';
error_reporting(E_ALL ^ E_DEPRECATED);
$con = mysql_connect($database_config['hostname'], $database_config['username'], $database_config['password']);
mysql_select_db($database_config['database'], $con);
mysql_query("set names 'utf8'");
$order_no = $_GET['order_sign_no'];
$order = mysql_fetch_array(mysql_query('select sum(price) as sprice from orders where order_sign_no = "' . $order_no . '"'));
$price = $order['sprice'] * 100;
$pay = new Pay();
$data = $pay->pays($order_no, $price, $wxpay_config['notify_url']);
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/> 
        <title>微信支付</title>
        <script src="./assets/js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript">
            //调用微信JS api 支付
            function jsApiCall()
            {
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
<?php echo $data['jsApiParameters']; ?>,
                        function (res) {
                            WeixinJSBridge.log(res.err_msg);
                            if (res.err_msg == "get_brand_wcpay_request:ok") {
                                window.location.href = "<?php echo $wxpay_config['redirect_url']; ?>";
                            } else {
                                window.location.href = "<?php echo $wxpay_config['redirect_url']; ?>";
                            }
                        }
                );
            }

            function callpay()
            {
                if (typeof WeixinJSBridge == "undefined") {
                    if (document.addEventListener) {
                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                    } else if (document.attachEvent) {
                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                    }
                } else {
                    jsApiCall();
                }
            }
        </script>
        <script type="text/javascript">
            //获取共享地址
            function editAddress()
            {
                WeixinJSBridge.invoke(
                        'editAddress',
<?php echo $data['editAddress']; ?>,
                        function (res) {
                            var value1 = res.proviceFirstStageName;
                            var value2 = res.addressCitySecondStageName;
                            var value3 = res.addressCountiesThirdStageName;
                            var value4 = res.addressDetailInfo;
                            var tel = res.telNumber;

//                            alert(value1 + value2 + value3 + value4 + ":" + tel);
                        }
                );
            }

            window.onload = function () {
//                if (typeof WeixinJSBridge == "undefined") {
//                    if (document.addEventListener) {
//                        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
//                    } else if (document.attachEvent) {
//                        document.attachEvent('WeixinJSBridgeReady', editAddress);
//                        document.attachEvent('onWeixinJSBridgeReady', editAddress);
//                    }
//                } else {
//                    editAddress();
//                }
                callpay();
            };

        </script>
        <style type="text/css">
            p {
                margin: 0;
            }

            a {
                text-decoration: none;
            }

            a:focus,
            a:hover {
                color: white;
                text-decoration: none;
            }

            .btn.focus,
            .btn:focus,
            .btn:hover {
                color: #ED3737;
            }
        </style>
    </head>
    <body>
        <!--        <div class="weui_msg">
                    <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
                    <div class="weui_text_area">
                        <h2 class="weui_msg_title">下单成功</h2>
                        <h2 class="weui_msg_title">订单金额：元</h2>
                    </div>
                    <div class="weui_opr_area" style="margin-top:100px;">
                        <p class="weui_btn_area">
                            <a href="" onclick="callpay()" class="weui_btn weui_btn_primary">立即支付</a>
                        </p >
                    </div>
                </div>-->
    </body>
</html>