<div class="gooddt activitydt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
        <p>演出详情</p>
    </div>
</div>
<div class="activitydt-info">
    <div class="activitydt-coverimg">
        <img src="<?php echo base_url() . explode('|', $detail['coverimg'])[0]; ?>" alt="">
        <p><?php echo $detail['name']; ?></p>
    </div>
    <div class="activitydt-infodt">
        <p>
            <i class="iconfont icon-shizhong"></i>
            <span>时间：</span>
            <span><?php echo $detail['start_time']; ?>-<?php echo $detail['end_time']; ?></span>
        </p>
        <p>
            <i class="iconfont icon-didian1"></i>
            <span>地点：</span>
            <span><?php echo $detail['address']; ?></span>
        </p>
        <p>
            <i class="iconfont icon-qian1"></i>
            <span>￥<?php echo $detail['price']; ?>/场</span>
        </p>
    </div>
    <div class="showdt-contact">
        <h5>电话咨询</h5>
        <p><span><?php echo $detail['phone']; ?></span><a href="tel:<?php echo $detail['phone']; ?>" class="tel">立即咨询</a></p>
    </div>
    <div class="activitydt-wrap swiper-container">
        <p>演出展示</p>
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
        <h5>演出详情</h5>
        <p><?php echo $detail['desc']; ?></p>
    </div>
</div>