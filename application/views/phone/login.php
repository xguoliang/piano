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
                <input type="number" placeholder="请输入手机号" id="phone">
            </p>
            <p class="login-input">
                <input type="password" placeholder="请输入密码" id="password">
            </p>
            <button class="login-btn" onclick="submit()">登 录</button>
            <p class="login-re">
                <a href="PRegister" class="register">注册</a><a href="PForgetPassword" class="for-pwd">忘记密码？</a>
            </p>
        </div>
    </div>
</div>
<script>
    function submit() {
        var phone = $('#phone').val();
        var password = $('#password').val();
        if (phone != "" && password != "") {
            var url = "ValidateLogin";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    phone: phone,
                    password: password
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (data == 1) {
<?php if ($history == 0) { ?>
                            window.location.href = "My.html";
<?php } else { ?>
                            window.history.go(-1);
<?php } ?>
                    } else {
                        layer.msg('手机号密码错误！',{time:1500})

                    }
                }
            });
        } else {
            layer.msg('请输入手机号密码！',{time:1500})
        }
    }
</script>