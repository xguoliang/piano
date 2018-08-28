<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="iconfont icon-shezhi set" onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Login/PSet.html'"></i>
    </div>
</div>
<div class="my-infodt" onclick="javascript:window.location.href = 'PChangeBandsman.html'">
    <div class="my-img">
        <img src="<?php echo $detail['headimg'] != "" ? base_url() . $detail['headimg'] : "assets/img/user/headimg.png"; ?>" alt="">
    </div>
    <div class="my-txt">
        <h5><?php echo $detail['name'] != "" ? $detail['name'] : "请编辑乐手名称"; ?></h5>
        <p>擅长乐器：<?php echo $detail['instrument']; ?></p>
    </div>
</div>
<div class="my-atte3">
    <ul>
        <li>
            <a href="PMyConcern.html">
                <span><?php echo $guanzhu; ?></span>
                <p>我的关注</p>
            </a>
        </li>
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
<div class="my-yueshou">
    <ul>
        <li>
            <a href="PMyBand.html">
                <i class="iconfont icon-tuandui"></i>
                <p>乐队组建</p>
            </a>
        </li>
        <li>
            <a href="PMyCompanionship.html">
                <i class="iconfont icon-leduibianpeipitchon"></i>
                <p>陪伴练习</p>
            </a>
        </li>
        <li>
            <a href="PerformBusiness.html">
                <i class="iconfont icon-lifangtilitiduomiantifangkuai2"></i>
                <p>演出买卖</p>
            </a>
        </li>
        <li>
            <a href="PMyWorks.html">
                <i class="iconfont icon-yinle"></i>
                <p>我的作品</p>
            </a>
        </li>
    </ul>
</div>
<div class="my-fenlei-list">
    <ul>
        <li>
            <a href="<?php echo base_url(); ?>User/Message/MessageList.html">
                <i class="iconfont icon-xiaoxi"></i>
                <span>消息通知</span>
                <i class="iconfont icon-right"></i>
            </a>
        </li>
        <!--        <li>
                    <a href="my-download.html"><i class="iconfont icon-xiazai"></i><span>我的下载</span><i class="iconfont icon-right"></i></a>
                </li>-->
        <li>
            <a href="">
                <i class="iconfont icon-msnui-telephone"></i>
                <span>联系客服</span>
                <i class="iconfont icon-right"></i>
            </a>
        </li>
    </ul>
</div>
<?php $this->load->view('phone/foot', array('nav' => 4)); ?>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>