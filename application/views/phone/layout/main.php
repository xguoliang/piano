<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $layout['title']; ?></title>
        <?php $this->load->view('phone/layout/head'); ?>
    </head>
    <body <?php if(isset($layout['top'])){echo "style='padding-top:44px;'";}?>>
        <?php echo $content ?>
    </body>
<script>

    function ChoosePay(id,e){
        e.stopPropagation();
        layer.confirm('请选择支付方式',{btn:['支付宝','微信'],shadeClose:true,title:'支付'}
            ,function(){
                if(!is_weixin()){
                    ToAliPay(id)
                }else{
                    layer.msg('请在外部外部浏览器支付!')
                }
            },function(){
                ToWxPay(id)
            }
        )
    }

    function ChoosePay1(id){
        layer.confirm('请选择支付方式',{btn:['支付宝','微信'],shadeClose:true,title:'支付'}
            ,function(){
                if(!is_weixin()){
                    window.location.href = "<?php echo base_url()?>alipay.php?order_sign_no="+id;

                }else{
                    layer.msg('请在外部外部浏览器支付!')
                }
            },function(){
                if(is_weixin() == true){
                    window.location.href = "<?php echo base_url()?>wx_pay.php?order_sign_no="+id+'&abc=abc';
                }else{
                    window.location.href = "<?php echo base_url()?>wx_jspay.php?order_sign_no="+id+'&abc=abc';
                }
            }
        )
    }

    function ToAliPay(id){
        var url = "<?php echo base_url()?>User/Orders/ResetOrderNo";
        var data = {
            id: id
        };
        $.post(url,data,function(res){
            window.location.href = "<?php echo base_url()?>alipay.php?order_sign_no="+res.order_sign_no;
        },'json')
    }

    function ToWxPay(id){
        var url = "<?php echo base_url()?>User/Orders/ResetOrderNo";
        var data = {
            id: id
        };
        $.post(url,data,function(res){
            if(is_weixin() == true){
                window.location.href = "<?php echo base_url()?>wx_pay.php?order_sign_no="+res.order_sign_no+'&abc=abc';
            }else{
                window.location.href = "<?php echo base_url()?>wx_jspay.php?order_sign_no="+res.order_sign_no+'&abc=abc';
            }
        },'json')
    }

    function is_weixin(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }
</script>
</html>