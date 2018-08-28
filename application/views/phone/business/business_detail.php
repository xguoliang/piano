<div class="gooddt activitydt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
<!--        <span class="gooddt-right">
            <i class="iconfont icon-shoucang"></i>
            <i class="iconfont icon-fenxiang"></i>
        </span>-->
        <p>演出买卖</p>
    </div>
</div>
<div class="activitydt-info">
    <div class="businessdt-img">
        <div class="img">
            <img src="<?php echo base_url() . $detail['headimg']; ?>" alt="">
        </div>
        <div class="txt">
            <p><span class="name"><?php echo $detail['name']; ?></span></p>
            <p><span>出场费：</span><span>￥<?php echo $detail['price']; ?></span></p>
        </div>
    </div>
    <div class="businessdt-contact">
        <a href="tel:<?php echo $detail['phone']; ?>"><i class="tel"></i><span><?php echo $detail['phone']; ?></span></a><button>邀请</button>
    </div>
    <div class="activitydt-wrap swiper-container">
        <p>演出图册</p>
        <div class="activitydt-slide">
            <div class="swiper-wrapper">
                <?php
                $coverimg = explode('|', $detail['coverimg']);
                for ($i = 0; $i < count($coverimg); $i++) {
                    ?>
                    <div class="swiper-slide">
                        <img src="<?php echo base_url() . $coverimg[$i]; ?>" alt="">
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="activitydt-edit">
        <h5>乐队详情</h5>
        <p><?php echo $detail['desc']; ?></p>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/swiper.min.js"></script>
<script>
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
</script>