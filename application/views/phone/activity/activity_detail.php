<div class="gooddt activitydt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
        <span class="gooddt-right">
                <i class="iconfont icon-gouwuche" onclick="AddToCart()"></i>
                <i class="iconfont icon-shoucang" onclick="ChangeCollect()"></i>
                <i class="iconfont icon-fenxiang"></i>
            </span>
        <p>活动详情</p>
    </div>
</div>
<div class="activitydt-info">
    <div class="activitydt-coverimg">
        <img src="<?php echo base_url().explode(',',$detail['coverimg'])[0]?>" alt="">
        <p><?php echo $detail['name']?></p>
        <p>收藏<?php echo $detail['count']?>次</p>
    </div>
    <div class="activitydt-infodt">
        <p>
            <i class="iconfont icon-shizhong"></i>
            <span>时间：</span>
            <span><?php echo $detail['start_time']?>-<?php echo $detail['end_time']?></span>
        </p>
        <p>
            <i class="iconfont icon-didian1"></i>
            <span>地点：</span>
            <span><?php echo $detail['address']?></span>
        </p>
        <p>
            <i class="iconfont icon-renyuanguanli"></i>
            <span>报名人数：</span>
            <span><?php echo $detail['appointment']?>人</span>
        </p>
        <p>
            <i class="iconfont icon-qian1"></i>
            <span>￥<?php echo $detail['price']?></span>
        </p>
    </div>
    <div class="activitydt-wrap swiper-container">
        <p>活动图集</p>
        <div class="activitydt-slide">
            <div class="swiper-wrapper">
                <?php foreach(explode(',',$detail['coverimg']) as $k=>$v){?>
                <div class="swiper-slide">
                    <img src="<?php echo base_url().$v?>" alt="">
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="activitydt-issue">
        <div class="issue-img">
            <img src="<?php echo base_url().$company['headimg']?>" alt="">
        </div>
        <div class="issue-txt">
            <p class="name"><?php echo $company['name']?></p>
            <span>发布者</span>
            <a href="tel:<?php echo $company['phone']?>" class="tel"><i class="iconfont "></i></a>
        </div>
    </div>
    <div class="activitydt-edit">
        <h5>活动详情</h5>
        <p><?php echo $detail['desc']?></p>
    </div>
</div>
<div class="gooddt-buybtn">
    <button class="cart" onclick="AddToCart()">
        <i class="iconfont icon-gouwuche" ></i>加入购物车</button>
    <button class="buy" onclick="ConfirmOrder()">立即购买</button>
</div>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>
<script>
    var user_id = "<?php if(isset($_SESSION['lerenuser'])){echo $_SESSION['lerenuser']['id'];}else{echo '';}?>";
    var activity_id = "<?php echo $detail['id']?>";
    var com_id = "<?php echo $detail['company_id']?>";
    var swiper1 = new Swiper('.activitydt-slide', {
        slidesPerView: 3,
        autoplayDisableOnInteraction: false,
        paginationClickable: true,
        observer: true,
        observeParents: true,
        loop: true,
        autoplay: 2500,
        spaceBetween: 5
    });
    function AddToCart(){
        if(user_id == ''){
            layer.msg('登录后可加入购物车',{time:1500})
            return;
        }else{
            var url = "<?php echo base_url()?>index.php/User/Product/AddToCart";
            var data = {
                save:{
                    user_id:user_id,
                    entity_id:activity_id,
                    entity_type:3,
                    num:1
                }
            };
            $.post(url,data,function(res){
                if(res.status == 1){
                    layer.msg("加入购物车成功!",{time:1500})
                }else{
                    layer.msg("登录失效，请重新登录后操作!",{time:1500})
                }
            },'json')
        }
    }


    function ChangeCollect(){
        if(user_id == ''){
            layer.msg('登录后可收藏!',{time:1500});
            return;
        }else{
            var url = '<?php echo base_url()?>index.php/User/Product/ChangeCollect';
            var data = {
                equal:{
                    entity_type:3,
                    entity_id:activity_id
                }
            }
            $.post(url,data,function(res){
                if(res.status == 1){
                    if(res.ope == 1){
                        layer.msg('收藏成功!',{time:1500},function(){
                            $(".icon-shoucang").css("color","#fba420")
                        });
                    }else{
                        layer.msg('取消收藏成功！',{time:1500},function(){
                            $(".icon-shoucang").css("color","#fff")
                        });
                    }
                }else{
                    layer.msg('登陆后可收藏!',{time:1500})
                    return;
                }
            },'json')
        }
    }

    function ConfirmOrder(){
        var num = $("#pro_num").text();
        if(user_id == ''){
            layer.msg('登录后可购买',{time:1500})
            return;
        }else{
            var url = "<?php echo base_url()?>User/Orders/ConfirmOrder?id="+activity_id+'&entity_type=3&com_id='+com_id+'&num='+1;
            window.location.href = url;
        }
    }
</script>
