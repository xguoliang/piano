<div class="gooddt activitydt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
        <span class="gooddt-right">
            <i class="iconfont icon-shoucang" onclick="collects(<?php echo $detail['id']; ?>)"></i>
            <i class="iconfont icon-fenxiang"></i>
        </span>
        <p>乐手详情</p>
    </div>
</div>
<div class="activitydt-info">
    <div class="businessdt-img">
        <div class="img">
            <img src="<?php echo base_url() . $detail['headimg']; ?>" alt="">
        </div>
        <div class="txt">
            <p><span class="name" style="font-size:0.32rem;"><?php echo $detail['name'] ?></span><span style="margin-left:0.2rem;">擅长乐器：<?php echo $detail['instrument_name']; ?></span></p>
            <p><span>出场费：</span><span>￥<?php echo $business['price']; ?></span></p>
        </div>
    </div>
    <div class="businessdt-contact">
        <a href="tel:<?php echo $business['phone']; ?>"><i class="tel"></i><span><?php echo $business['phone']; ?></span></a><button onclick="javascript:window.location.href = 'tel:<?php echo $business['phone']; ?>'">邀请</button>
    </div>
    <div class="activitydt-wrap swiper-container">
        <p>演出图册</p>
        <div class="activitydt-slide">
            <div class="swiper-wrapper">
                <?php
                $coverimg = explode('|', $business['coverimg']);
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
        <h5>个人详情</h5>
        <p><?php echo $business['desc']; ?></p>
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
            function collects(id) {
                var url = "CollectBandsman";
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (data, textStatus) {
                        if (data == 1) {
                            layer.msg('收藏成功!', {time: 1500})
                        } else {
                            layer.msg('请先登录!', {time: 1500})

                        }
                    }
                });
            }
</script>