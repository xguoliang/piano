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
                <input type="password" placeholder="请输入旧密码" id="old_pass">
            </p>
            <p class="login-input">
                <input type="password" placeholder="请输入新密码" id="new_pass">
            </p>
            <p class="login-input">
                <input type="password" placeholder="请再次输入新密码" id="passconf">
            </p>
            <button class="login-btn" onclick="submit()">保 存</button>
        </div>
    </div>
</div>
<script>
    function submit() {
        var old_pass = $('#old_pass').val();
        var new_pass = $('#new_pass').val();
        var passconf = $('#passconf').val();
        if (old_pass != "" && new_pass != "") {
            if (new_pass == passconf) {
                if(old_pass != new_pass){
                    layer.msg('新密码不能与原密码相同!',{time:1500});
                    return;
                }
                var url = "UpdatePassword";
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        old_pass: old_pass,
                        new_pass: new_pass
                    },
                    dataType: "json",
                    success: function (data, textStatus) {
                        if (data == 1) {
                            layer.msg('保存成功!',{time:1500},function(){
                                window.history.go(-1);

                            })
                        } else {
                            layer.msg('原密码错误!',{time:1500})
                        }
                    }
                });
            } else {
                layer.msg('两次密码不一致!',{time:1500})

            }
        } else {
            layer.msg('请填写密码!',{time:1500})

        }
    }
</script>