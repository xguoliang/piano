<style>
    body {
        padding-bottom: 0;
    }
</style>
<div class="login">
    <div class="login-info">
        <div class="logo">
            <img src="<?php echo base_url(); ?>assets/img/phone/logo.png" alt="">
            <p>乐人</p>
        </div>
        <div class="login-form">

            <p class="login-input">
                <input type="number" placeholder="请输入原手机号" id="phone">
            </p>
            <p class="login-input">
                <input type="text" placeholder="请输入验证码" id="vcode">
                <button class="yanzheng" id="btnSendCode" onclick="sendMessage()">获取验证码</button>
            </p>
            <button class="login-btn" onclick="submit()">继续</button>
        </div>
    </div>
</div>
<script>
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    function sendMessage() {
        curCount = count;
        var phone = $("#phone").val();
        if (validatemobile(phone)) {
            //设置button效果，开始计时
            if($("#password").val() == ''){
                layer.msg('请输入密码',{time:1500})
                return;
            }
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>index.php/User/Login/ChangePhoneSms",
                data: {
                    phone: phone,
                },
                dataType: "json",
                success: function (data, status) {
                    if (data.status == 1) {
                        $("#btnSendCode").attr("disabled", "true");
                        $("#btnSendCode").text(+curCount + "秒再获取");
                        $('#btnSendCode').css('pointer-events', 'none');
                        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                    } else if(data.status == 2){
                        layer.msg('登录失效，请重新登录后操作!',{time:1500},function(){
                            window.location.href = "<?php echo base_url()?>User/Login/PLogin";
                        })
                    }else{
                        layer.msg('输入手机号不是当前登录手机号!',{time:1500},function(){
                            $("#phone").val('').focus();
                        })
                    }
                }
            })
        }
    }
    function SetRemainTime() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $('#btnSendCode').attr('color', '');
            $("#btnSendCode").removeAttr("disabled");//启用按钮
            $("#btnSendCode").text("重新发送");
            $('#btnSendCode').css('pointer-events', '');
        } else {
            curCount--;
            $("#btnSendCode").text(+curCount + "秒再获取");
        }
    }
    function validatemobile(mobile) {
        if (mobile.length == 0) {
            layer.msg('请输入正确的手机号!',{time:1500})
            return false;
        }
        if (mobile.length != 11) {
            layer.msg('请输入正确的手机号!',{time:1500})
            return false;
        }

        var myreg = /^(((13[0-9]{1})|(17[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if (!myreg.test(mobile))
        {
            layer.msg('请输入正确的手机号!',{time:1500})
            return false;
        } else {
            return true;
        }
    }
    function submit() {
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        if(validatemobile(phone)){
            var url = "ValidateChangePhone";
            var data = {
                phone:phone,
                vcode:vcode
            }
            $.post(url,data,function(res){
                if(res.status == 1){
                    layer.msg('验证通过，正在跳转!',{time:1500},function(){
                        window.location.href = "<?php echo base_url()?>User/Login/ChangePhone"
                    })
                }else if(res.status == 2){
                    layer.msg('登录失效，请重新登录!',{time:1500},function(){
                        window.location.href = '<?php echo base_url()?>User/Login/PLogin';
                    })

                }else if(res.status == 4){
                    layer.msg('验证码错误，请重新输入!',{time:1500},function(){
                        $("#vcode").val('').focus();
                    })
                }else{
                    layer.msg('验证码失效，请重新获取!',{time:1500},function(){
                        $("#vcode").val('').focus();
                    })
                }
            },'json')
        }
    }
</script>