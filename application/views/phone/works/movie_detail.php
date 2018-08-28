<style>
    .tel{
        position: absolute;
        top: 0.2rem;
        right: 0.2rem;
        width: .52rem;
        height: .52rem;
        background: url(../../assets/img/phone/rent-tel.png) no-repeat;
        background-size: 100% 100%;
    }
</style>
<div class="gooddt activitydt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
        <span class="gooddt-right">
            <i class="iconfont icon-shoucang" onclick="collects()"></i>
            <i class="iconfont icon-fenxiang"></i>
        </span>
        <p>影音制作</p>
    </div>
</div>
<div class="activitydt-info">
    <div class="showdt-info">
        <div class="showdt-hd" style="position:relative;">
            <div class="show-img">
                <img src="<?php echo base_url() . explode('|', $detail['coverimg'])[0]; ?>" alt="">
            </div>
            <div class="show-txt" style="width: 3.5rem;">
                <p class="name"><?php echo $detail['name']; ?></p>
                <p class="price">￥<?php echo $detail['price']; ?>/天</p>
            </div>
            <a href="tel:<?php echo $detail['phone']; ?>"><i class="tel"></i></a>
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
<?php if (isset($_SESSION['lerenuser'])) { ?>
                        var id =<?php echo $detail['id']; ?>;
                        var url = '<?php echo base_url() ?>index.php/User/Product/ChangeCollect';
                        var data = {
                            equal: {
                                entity_type: 8,
                                entity_id: id
                            }
                        }
                        $.post(url, data, function (res) {
                            if (res.status == 1) {
                                if (res.ope == 1) {
                                    layer.msg('收藏成功!', {time: 1500}, function () {
                                    });
                                } else {
                                    layer.msg('取消收藏成功！', {time: 1500}, function () {
                                    });
                                }
                            } else {
                                layer.msg('登陆后可收藏!', {time: 1500})
                                return;
                            }
                        }, 'json')
<?php } else { ?>
                        layer.msg('请不要申请自己的乐队!', {time: 1500})
<?php } ?>
                }
</script>