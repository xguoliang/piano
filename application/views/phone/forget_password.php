<style>
    body {
        padding-bottom: 0;
    }
</style>
<div class="login">
    <div class="login-info">
        <div class="logo">
            <p>乐人</p>
        </div>
        <div class="login-form">
            <p class="login-input">
                <input type="number" placeholder="请输入手机号" id="phone">
            </p>
            <p class="login-input">
                <input type="text" placeholder="请输入验证码" id="vcode">
                <span class="yanzheng" id="btnSendCode" onclick="sendMessage()">获取验证码</span>
            </p>
            <p class="login-input">
                <input type="password" placeholder="设置密码" id="password">
            </p>
            <p class="login-input">
                <input type="password" placeholder="设置密码" id="passconf">
            </p>
            <button class="login-btn">确 定</button>
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

            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>index.php/User/Login/ForgetSendSms",
                data: {
                    phone: phone,
                },
                dataType: "json",
                success: function (data, status) {
                    if (data == 1) {
                        $("#btnSendCode").attr("disabled", "true");
                        $("#btnSendCode").text(+curCount + "秒再获取");
                        $('#btnSendCode').css('pointer-events', 'none');
                        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                    } else {
                        layer.msg('该手机号已注册!',{time:1500})
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
            layer.msg('请输入手机号!',{time:1500})
            return false;
        }
        if (mobile.length != 11) {
            layer.msg('请输入有效的手机号码!',{time:1500})
            return false;
        }

        var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if (!myreg.test(mobile))
        {
            layer.msg('请输入有效的手机号码!',{time:1500})
            return false;
        } else {
            return true;
        }
    }
    function submit() {
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        var password = $('#password').val();
        var passconf = $('#passconf').val();
        if (password != passconf) {
            layer.msg('两次密码不一致!',{time:1500})
            return;
        }
        if (phone != "" && vcode != "" && password != "") {
            var url = "ValidateForgetPassword";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    phone: phone,
                    vcode: vcode,
                    password: password
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (data == 1) {
                        layer.msg('注册成功!',{time:1500},function(){
                            window.history.go(-1)
                        })

                    } else if (data == 2) {
                        layer.msg('该手机号未注册!',{time:1500})
                    } else if (data == 3) {
                        layer.msg('验证码错误!',{time:1500})
                    } else {

                    }
                }
            });
        } else {
            layer.msg('输入不完整!',{time:1500})
        }
    }
</script>