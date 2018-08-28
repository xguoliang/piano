<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="iconfont icon-shezhi set" onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Login/PSet.html'"></i>
    </div>
</div>
<div class="my-info" onclick="javascript:window.location.href = 'PChangeCompany.html'">
    <div class="my-img">
        <img src="<?php echo $detail['headimg'] != "" ? base_url() . $detail['headimg'] : "assets/img/user/headimg.png"; ?>" alt="">
    </div>
    <div class="my-txt">
        <h5><?php echo $detail['name'] != "" ? $detail['name'] : "点击编辑琴行名称"; ?></h5>
        <p>
            <i></i>
            <span><?php echo $detail['address']; ?></span>
        </p>
    </div>
</div>
<div class="my-info-list">
    <ul>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PProductList.html">
                <i class="iconfont icon-weibiaoti1"></i>
                <p>商品管理</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PLessonList.html">
                <i class="iconfont icon-kecheng"></i>
                <p>课程中心</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Orders/MyOrdersType.html">
                <i class="iconfont icon-dingdan1"></i>
                <p>我的订单</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PTeacherList.html">
                <i class="iconfont icon-renxiang"></i>
                <p>老师列表</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PActivityList.html">
                <i class="iconfont icon-biaoqian"></i>
                <p>活动列表</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PPerformList.html">
                <i class="iconfont icon-meiti_huatong_jingying"></i>
                <p>演出列表</p>
            </a>
        </li>
    </ul>
</div>
<div class="my-fenlei-list">
    <ul>
        <!--        <li>
                    <a href="rent-manage.html">
                        <i class="iconfont icon-icon-"></i>
                        <span>设备租赁</span>
                        <i class="iconfont icon-right"></i>
                    </a>
                </li>
                <li>
                    <a href="site-manage.html">
                        <i class="iconfont icon-diban-hui"></i>
                        <span>场地租赁</span>
                        <i class="iconfont icon-right"></i>
                    </a>
                </li>-->
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PSoundList.html">
                <i class="iconfont icon-luyin"></i>
                <span>演唱录音</span>
                <i class="iconfont icon-right"></i>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PMovieList.html">
                <i class="iconfont icon-shipin"></i>
                <span>影音制作</span>
                <i class="iconfont icon-right"></i>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Company/PHeadlineList.html">
                <i class="iconfont icon-xinwen"></i>
                <span>头条新闻</span>
                <i class="iconfont icon-right"></i>
            </a>
        </li>
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