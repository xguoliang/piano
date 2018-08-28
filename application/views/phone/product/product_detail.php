<div class="gooddt good">
    <div class="gooddt-hd1 inside-title gooddt-hd">
        <i class="back"></i>
        <span class="gooddt-right">
            <i class="iconfont icon-gouwuche" onclick="AddToCart()"></i>
            <i class="iconfont icon-shoucang" onclick="ChangeCollect()" <?php
            if ($is_collect == 1) {
                echo "style='color:#fba420'";
            } else {
                echo '';
            }
            ?>></i>
            <i class="iconfont icon-fenxiang"></i>
        </span>
    </div>
</div>
<div class="gooddt-hd2 inside-title gooddt-hd" style="display:none">
    <i class="back"></i>
    <ul>
        <li class="active">商品</li>
        <li>评价</li>
        <li>详情</li>
        <li>推荐</li>
    </ul>
</div>
<div class="gooddt-info">
    <div class="gooddt-wrap swiper-container">
        <ul class="swiper-wrapper">
            <?php foreach (explode(',', $detail['img']) as $k => $v) { ?>
                <li class="swiper-slide">
                    <img src="<?php echo base_url() . $v ?>" alt="">
                </li>
            <?php } ?>
        </ul>
        <div class="swiper-pagination gooddt-pagination"></div>
    </div>
    <div class="gooddt-txt" style="margin-bottom: 0.2rem">
        <h5 style="font-size:0.32rem;"><?php echo $detail['name'] ?></h5>
        <p class="good-price">
            <em class="good-price1">
                <span class="price-icon">¥</span>
                <span class="price-num"><?php echo $detail['price'] ?></span>
            </em>
            <em class="good-price2" style="font-size:.2rem;">原价
                <span class="price-icon">¥</span>
                <span class="price-num"><?php echo $detail['show_price'] ?></span>
            </em>
        </p>
    </div>
    <div class="gooddt-num">
        <span>购买数量</span>
        <span>
            <i class="iconfont icon-jian" onclick="AddOrReduce(0)"></i>
            <em id="pro_num">1</em>
            <i class="iconfont icon-jia" onclick="AddOrReduce(1)"></i>
        </span>
    </div>
    <div class="gooddt-brand">
        <span>品牌名称</span>
        <span><?php echo $brand['name'] ?></span>
    </div>
    <div class="gooddt-canshu">
        <span>产品参数</span>
        <i class="iconfont icon-right"></i>
    </div>
</div>
<div class="gooddt-info">
    <h3 class="title">
        商品评价（<?php echo $detail['eva_count'] ?>）
    </h3>
    <ul class="gooddt-assess">
        <?php if ($comment != null) { ?>
            <li>
                <div class="gooddt-assessimg">
                    <img src="<?php echo base_url() . $comment['headimg'] ?>" alt="">
                </div>
                <div class="gooddt-assesstxt">
                    <p class="name"><?php echo $comment['user_name'] ?></p>
                    <p class="gooddt-assessdt">
                        <span>评分</span>
                        <span>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <?php if ($i < $comment['star']) { ?>
                                    <img src="<?php echo base_url() ?>assets/img/phone/asse1.png" alt="">
                                <?php } else { ?>
                                    <img src="<?php echo base_url() ?>assets/img/phone/asse.png" alt="">
                                <?php } ?>
                            <?php } ?>
                        </span>
                    </p>
                    <p class="gooddt-content"><?php echo $comment['desc'] ?></p>
                    <span class="date"><?php echo $comment['add_time'] ?></span>
                    <!--                <div class="assess-dt-img assess2">
                                        <ul>
                    <?php // foreach(explode(',',$comment['img']) as $k=>$v){  ?>
                                                <li>
                                                    <div class="assessimg">
                                                        <span><img src="<?php // echo base_url().$v    ?>" alt=""></span>
                                                    </div>
                                                </li>
                    <?php // }  ?>
                                        </ul>
                                    </div>-->
                </div>
            </li>
        <?php } ?>
        <a class="assess-more" href="AllEvaluation?id=<?php echo $detail['id'] ?>">查看全部评论</a>
    </ul>
</div>
</div>
<div class="gooddt-store">
    <div class="gooddt-store-info">
        <div class="gooddt-store-img">
            <img src="<?php echo base_url() . $company['headimg'] ?>" alt="">
        </div>
        <div class="gooddt-store-txt">
            <p class="name"><?php echo $company['name'] ?></p>
            <p class="dt">
                <span>
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <?php if ($i < $company['avg_star']) { ?>
                            <img src="<?php echo base_url() ?>assets/img/phone/asse1.png" alt="">
                        <?php } else { ?>
                            <img src="<?php echo base_url() ?>assets/img/phone/asse.png" alt="">
                        <?php } ?>
                    <?php } ?>
                </span>
                <a href="<?php echo base_url() ?>User/Company/CompanyDetail.html?id=<?php echo $company['id'] ?>" class="go-store">进店逛逛</a>
            </p>
        </div>
    </div>
    <div class="gooddt-store-atte">
        <ul>
            <li>
                <span><?php echo $company['collect_num'] ?></span>
                <span>关注人数</span>
            </li>
            <li>
                <span><?php echo $detail['pro_count'] ?></span>
                <span>全部商品</span>
            </li>
        </ul>
    </div>
</div>
<div class="gooddt-info">
    <h3 class="title">商品详情</h3>
    <div class="gooddt-info-edit"><?php echo $detail['detail'] ?></div>
</div>
<div class="gooddt-info">
    <h3 class="title">
        推荐商品
    </h3>
    <ul class="gooddt-rec">
        <?php foreach ($recommed as $k => $v) { ?>
            <li onclick="window.location.href = 'PProductDetail?type=2&id=<?php echo $v['id'] ?>'">
                <div class="gooddt-recimg">
                    <img src="<?php echo base_url() . $v['coverimg'] ?>" alt="">
                </div>
                <p class="name"><?php echo $v['name'] ?></p>
                <p class="price">¥<?php echo $v['price'] ?></p>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="gooddt-buybtn">
    <button class="cart" onclick="AddToCart()">
        <i class="iconfont icon-gouwuche"></i>加入购物车</button>
    <button class="buy" onclick="ConfirmOrder()">立即购买</button>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>
<div class="gooddt-parameter">
    <h5>产品参数</h5>
    <div class="parameter-list">
        <ul>
            <?php foreach (explode('@!', $detail['parameters']) as $k => $v) { ?>
                <li>
                    <span><?php echo explode('@:', $v)[0] ?></span>
                    <span><?php echo explode('@:', $v)[1] ?></span>
                </li>
            <?php } ?>
        </ul>
        <button>完成</button>
    </div>
</div>
<?php //$this->load->view('phone/foot',array('nav' => 3))  ?>

<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>

<script>
        var user_id = "<?php
if (isset($_SESSION['lerenuser'])) {
    echo $_SESSION['lerenuser']['id'];
} else {
    echo '';
}
?>";
        var pro_id = "<?php echo $detail['id'] ?>";
        var com_id = "<?php echo $detail['com_id'] ?>"
        var swiper1 = new Swiper('.gooddt-wrap', {
            pagination: '.gooddt-pagination',
            slidesPerView: 1,
            autoplayDisableOnInteraction: false,
            paginationClickable: true,
            observer: true,
            observeParents: true,
            loop: true,
            autoplay: 2500
        });
        $(".gooddt-canshu").click(function () {
            $(".mask").show();
            $(".gooddt-parameter").show();
        });
        $(".parameter-list button").click(function () {
            $(".mask").hide();
            $(".gooddt-parameter").hide();
        });
        window.onscroll = function (e) {
            h = $(this).scrollTop();
            if (h > 0) {
                $(".gooddt-hd2").show();
                $(".gooddt-hd1").hide();
            } else {
                $(".gooddt-hd2").hide();
                $(".gooddt-hd1").show();
            }
        };
        $(".gooddt-hd2 ul li").click(function () {
            var p = $(this).offset().top;
            $(this).addClass("active").siblings().removeClass("active");
            $("html, body").animate({scrollTop: $(".gooddt-info").eq($(this).index()).offset().top}, {duration: 500, easing: "swing"});
            return false;
        });

        function AddOrReduce(i) {
            if (i) {
                $("#pro_num").text(parseInt($("#pro_num").text()) + 1);
            } else {
                if (parseInt($("#pro_num").text()) != 1) {
                    $("#pro_num").text(parseInt($("#pro_num").text()) - 1);
                }
            }
        }

        function ChangeCollect() {
            if (user_id == '') {
                layer.msg('登录后可收藏!', {time: 1500});
                return;
            } else {
                var url = 'ChangeCollect';
                var data = {
                    equal: {
                        entity_type: 1,
                        entity_id: pro_id
                    }
                }
                $.post(url, data, function (res) {
                    if (res.status == 1) {
                        if (res.ope == 1) {
                            layer.msg('收藏成功!', {time: 1500}, function () {
                                $(".icon-shoucang").css("color", "#fba420")
                            });
                        } else {
                            layer.msg('取消收藏成功！', {time: 1500}, function () {
                                $(".icon-shoucang").css("color", "#fff")
                            });
                        }
                    } else {
                        layer.msg('登陆后可收藏!', {time: 1500})
                        return;
                    }
                }, 'json')
            }
        }

        function AddToCart() {
            if (user_id == '') {
                layer.msg('登录后可加入购物车', {time: 1500})
                return;
            } else {
                var url = "AddToCart";
                var data = {
                    save: {
                        user_id: user_id,
                        entity_id: pro_id,
                        entity_type: 1,
                        num: $("#pro_num").text()
                    }
                };
                $.post(url, data, function (res) {
                    if (res.status == 1) {
                        layer.msg("加入购物车成功!", {time: 1500})
                    } else {
                        layer.msg("登录失效，请重新登录后操作!", {time: 1500})
                    }
                }, 'json')
            }
        }

        function ConfirmOrder() {
            var num = $("#pro_num").text();
            if (user_id == '') {
                layer.msg('登录后可购买', {time: 1500})
                return;
            } else {
                var url = "<?php echo base_url() ?>User/Orders/ConfirmOrder?id=" + pro_id + '&entity_type=1&com_id=' + com_id + '&num=' + num;
                window.location.href = url;
            }
        }
</script>
