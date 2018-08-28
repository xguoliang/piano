<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>琴行登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin/font-awesome/css/font-awesome.css" rel="-stylesheet">
    <link href="<?php echo base_url() ?>assets/admin/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin/css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div style="padding-top: 150px;">
        <h3>欢迎使用琴行管理后台</h3>
        <div class="m-t" role="form">
            <div class="form-group">
                <input id="user_account" type="text" class="form-control" placeholder="用户名">
            </div>
            <div class="form-group">
                <input id="user_password" type="password" class="form-control" placeholder="密码">
            </div>
            <button id="submit" type="submit" class="btn btn-primary block full-width m-b">登 录</button>
        </div>
    </div>
</div>
<!-- Mainly scripts -->
<script src="<?php echo base_url() ?>assets/admin/js/jquery-2.1.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/layer/layer.js"></script>

<script type="text/javascript">
    $(function () {
        $("#user_password").focus(function () {
            $(document).keypress(function (e) {
                // 回车键事件
                if (e.which == 13) {
                    $("#submit").click();
                }
            });
        });
        $("#submit").click(function () {
            var user_account = $("#user_account").val();
            var user_password = $("#user_password").val();
            if (user_account != '' && user_password != '') {
                var url = "<?php echo base_url()?>Admin/Login/ValidateLogin";
                var data = {
                    'user_account': user_account,
                    'user_password': user_password
                };
                $.post(url, data, function (res) {
                    if (res.status == 1) {
                        layer.msg('登陆成功，正在跳转!', {time: 1500}, function(){
                            window.location.href = "<?php echo base_url()?>Admin/Piano/PianoList";
                        });
                    } else if (res.status == 0) {
                        layer.msg('密码错误，请重试!', {time: 1500});
                        $("#user_password").val('');
                        $("#user_password").focus();
                        return;
                    } else {
                        layer.msg('账号不存在!', {time: 1500});
                        $("#user_account").val('');
                        $("#user_password").val('');
                        $("#user_account").focus();
                        return;
                    }
                }, "json")
            } else {
                layer.msg('账号或者密码不能为空!', {time: 1500});
                return;
            }
        })
    })
</script>
</body>
</html>
