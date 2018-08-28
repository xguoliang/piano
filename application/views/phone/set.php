<div class=" good">
    <div class="inside-title">
        <i class="back"></i>
        <p>设置</p>
    </div>
</div>
<div class="setting">
    <ul>
        <li><a href="<?php echo base_url(); ?>User/Login/PChangePhone.html"><span class="setting-info">修改手机号码</span><span class="tel"><?php echo $_SESSION['lerenuser']['phone']; ?></span><i class="iconfont icon-right"></i></a></li>
        <li><a href="<?php echo base_url(); ?>User/Login/PChangePassword.html"><span class="setting-info">修改密码</span><i class="iconfont icon-right"></i></a></li>
        <!--<li><a href=""><span class="setting-info">隐私</span><i class="iconfont icon-right"></i></a></li>-->
        <!--<li><a href=""><span class="setting-info">注销账户</span><i class="iconfont icon-right"></i></a></li>-->
        <li><a href="javascript:void(0)"><span class="setting-info">切换角色</span><i class="iconfont icon-right"></i></a></li>
    </ul>
</div>
<button class="setout" onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Login/Logout.html'">退出当前账户</button>
<div class="mask1"></div>
<div class="change-account">
    <ul>
        <li onclick="javascript:window.location.href='<?php echo base_url(); ?>User/Student/PStudentIndex.html'">我是个人</li>
        <li onclick="javascript:window.location.href='<?php echo base_url(); ?>User/Company/PCompanyIndex.html'">我是琴行</li>
        <li onclick="javascript:window.location.href='<?php echo base_url(); ?>User/Bandsman/PBandsmanIndex.html'">我是乐手</li>
        <li onclick="javascript:window.location.href='<?php echo base_url(); ?>User/Rent/PRentIndex.html'">我是租赁方</li>
    </ul>
    <div class="cancle">取消</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
    $(".setting ul li:last").click(function () {
        $(".mask1").fadeIn();
        $(".change-account").fadeIn();
    });
    $(".change-account .cancle").click(function () {
        $(".change-account").hide();
        $(".mask1").hide();
    })
</script>