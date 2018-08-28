<div class="gooddt activitydt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
        <span class="gooddt-right">
            <i class="iconfont icon-shoucang" onclick="collects()"></i>
            <i class="iconfont icon-fenxiang"></i>
        </span>
        <p>设备租赁</p>
    </div>
</div>
<div class="activitydt-info">
    <div class="showdt-info">
        <div class="showdt-hd">
            <div class="show-img">
                <img src="<?php echo base_url() . explode("|", $detail['coverimg'])[0]; ?>" alt="">
            </div>
            <div class="show-txt">
                <p class="name"><?php echo $detail['name']; ?></p>
                <p class="date"><span>可租时间</span><br><span><?php echo $detail['start_time']; ?>-<?php echo $detail['end_time']; ?></span></p>
                <p class="price">￥<?php echo $detail['money']; ?>/天</p>
            </div>
        </div>
        <div class="showdt-address">
            <div class="address-l">
                <i class="iconfont icon-dizhi"></i><span>地址：<?php echo $detail['address']; ?></span>
            </div>
            <div class="showdt-con">
                <a href="tel:<?php echo $detail['phone']; ?>">
                    <i></i>
                    <p>电话咨询</p>
                </a>
            </div>
        </div>
    </div>
    <div class="activitydt-wrap swiper-container">
        <p>设备展示</p>
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
        <h5>设备详情</h5>
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
                function collects() {
                    var id =<?php echo $detail['id']; ?>;
                    var url = "CollectLease";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            if (data == 1) {
                                layer.msg('收藏成功！',{time:1500})

                            } else {
                                layer.msg('登录失效，请重新登录！',{time:1500})

                            }
                        }
                    });
                }
</script>