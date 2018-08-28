<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message"><a title="返回首页"><i class="fa fa-home"></i></a>欢迎使用琴行后台</span>
            </li>
            <li>
                <a onclick="LogOut()">
                    <i class="fa fa-sign-out"></i> 退出
                </a>
            </li>
        </ul>
    </nav>
</div>
<script>
    function LogOut(){
        var url = "<?php echo base_url()?>index.php/Admin/Login/LogOut";
        $.post(url,{},function(){
            if(res.status == 1){
                layer.msg('登陆成功！',{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>Admin/Login/Login.html";
                })
            }
        })
    }
</script>