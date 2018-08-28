<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="iconfont icon-shezhi set" onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Login/PSet.html'"></i>
    </div>
    <div class="my-infodt" onclick="javascript:window.location.href = 'PChangeRent.html'">
        <div class="my-img">
            <img src="<?php echo $detail['headimg'] != "" ? base_url() . $detail['headimg'] : "assets/img/user/headimg.png"; ?>" alt="">
        </div>
        <div class="my-txt">
            <h5><?php echo $detail['name'] != "" ? $detail['name'] : "请编辑租赁房名称"; ?></h5>
        </div>
    </div>
</div>
<div class="my-atte3 my-atte2">
    <ul>
        <li>
            <a href="<?php echo base_url(); ?>User/Student/PMyCollect.html">
                <span><?php echo $collect_count; ?></span>
                <p>我的收藏</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Orders/MyOrdersType.html">
                <span><?php echo $order_count; ?></span>
                <p>我的订单</p>
            </a>
        </li>
    </ul>
</div>
<div class="my-fenlei-list">
    <ul>
        <li>
            <a href="PLeaseList.html"><i class="iconfont icon-icon-"></i><span>设备租赁</span><i class="iconfont icon-right"></i></a>
        </li>
        <li>
            <a href="PSiteLease.html"><i class="iconfont icon-diban-hui"></i><span>场地租赁</span><i class="iconfont icon-right"></i></a> 
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Message/MessageList.html"><i class="iconfont icon-xiaoxi"></i><span>消息通知</span><i class="iconfont icon-right"></i></a>
        </li>
        <li>
            <a href=""><i class="iconfont icon-msnui-telephone"></i><span>联系客服</span><i class="iconfont icon-right"></i></a>
        </li>
    </ul>
</div>
<?php $this->load->view('phone/foot', array('nav' => 4)); ?>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>