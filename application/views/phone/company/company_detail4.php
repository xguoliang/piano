<style>
    .active{
        color: #fba41f!important;
    }
    .active span{
        color: #fba41f!important;
    }
</style>
<div class="store-page good store-page1">
    <div class="inside-title">
        <i class="back"></i>
        <i class="share"></i>
        <i class="collect" onclick="ChangeCollect()"></i>
    </div>
</div>
<div class="good store-page2">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search" onclick="SearchData()"></i>
        <p class="store-search"><input id="name" type="text"></p>
    </div>
</div>
<!-- 主页start -->
<div class="store-intro">
    <div class="store-hd">
        <div class="store-coverimg">
            <img src="<?php echo base_url() . $company['headimg']; ?>" alt="">
        </div>
        <div class="store-dt">
            <p class="store-name"><span><?php echo $company['name'] ?></span></p>
            <p class="store-assess">
                <?php for ($i = 0; $i < 5; $i++) { ?>
                    <?php if ($i < $company['avg_star']) { ?>
                        <img src="<?php echo base_url() ?>assets/img/phone/assess1.png" alt="">
                    <?php } else { ?>
                        <img src="<?php echo base_url() ?>assets/img/phone/assess.png" alt="">
                    <?php } ?>
                <?php } ?>
            </p>
            <p class="store-tel"><i></i><span><?php echo $company['address'] ?></span></p>
            <p class="store-add"><i></i><span><?php echo $company['phone'] ?></span></p>
        </div>
    </div>
    <div class="store-bd">
        <div class="store-bd-t">
            <h5>琴行简介</h5>
            <p><?php echo $company['desc'] ?></p>
            <span class="expand">展开</span>
        </div>
        <div class="store-bd-img swiper-container">
            <div class="swiper-wrapper">
                <?php foreach (explode(',', $company['img']) as $k => $v) { ?>
                    <div class="swiper-slide">
                        <img src="<?php echo base_url() . $v ?>" alt="">
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<div class="store-fenlei">
    <div class="store-fenlei-info">
        <ul id="type">
            <li onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail?id=<?php echo $company['id'] ?>'">商品</li>
            <li onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail1?id=<?php echo $company['id'] ?>'">课程</li>
            <li onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail2?id=<?php echo $company['id'] ?>'">老师</li>
            <li onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail3?id=<?php echo $company['id'] ?>'">活动</li>
            <li class="active" onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail4?id=<?php echo $company['id'] ?>'">头条</li>
        </ul>
    </div>
</div>
<div class="news-list">
    <ul class="news-item" id="headline_list"></ul>
</div>

<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>
<div id="allmap" style="display:none"></div>
<script>
                var user_id = "<?php if (isset($_SESSION['lerenuser'])) {
                    echo $_SESSION['lerenuser']['id'];
                } else {
                    echo '';
                } ?>";
                var nowpage = 1;
                var page_limit = 5;
                var p = 0, t = 0;
                var com_id = "<?php if (isset($company)) {
                    echo $company['id'];
                } else {
                    echo '';
                } ?>";

                $(function () {

                    FetchProduct();

                    window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
                    $("#area").find("li").click(function () {
                        $(".cover-floor").click();
                        $(this).addClass("active").siblings("li").removeClass();
                        $("#headline_list").empty();
                        nowpage = 1;
                        t = 0;
                        FetchProduct();
                    })
                    $("#sort_type").find("li").click(function () {
                        $(".cover-floor").click();
                        $(this).addClass("active").siblings("li").removeClass();
                        $("#headline_list").empty();
                        nowpage = 1;
                        t = 0;
                        FetchProduct();
                    })
                    $("#brand_id").find("li").click(function () {
                        if ($(this).hasClass("active")) {
                            $(this).removeClass("active");
                        } else {
                            $(this).addClass("active").siblings("li").removeClass();
                        }
                    })
                    $('.expand').click(function () {
                        if ($(this).prev().css('overflow') == "hidden") {
                            $(this).prev().css('overflow', 'auto');
                            $(this).prev().css('height', 'auto');
                            $(this).text('收起');
                        } else {
                            $(this).prev().css('overflow', 'hidden');
                            $(this).prev().css('height', '0.6rem');
                            $(this).text('展开');
                        }
                    })
                });

                function SearchData() {
                    $("#headline_list").empty();
                    nowpage = 1;
                    t = 0;

                    $(".cover-floor ").click();
                    FetchProduct();
                }

                function ResetSearch() {
                    $("#name").val('');
                    $("#min_price").val('');
                    $("#max_price").val('');
                    $("#brand_id").find('.active').removeClass("active");
                    $("#sort_type").find("li").removeClass('active').eq(0).addClass("active");
                }

                //判断滚动方向,上滚不触发
                function ScrollTo() {
                    p = $(window).scrollTop();    //下拉高度  
                    if (p >= t) {
                        AddMore();
                    }
                }

                function AddMore() {
                    var range = 50;
                    var totalheight = 0;
                    var srollPos = $(window).scrollTop();    //下拉高度  
                    t = srollPos;
                    totalheight = parseFloat($(window).height()) + parseFloat(srollPos);

                    if (($(document).height() - range) <= totalheight ) {
                        nowpage += 1;
                        FetchProduct();
                    }
                }

                function FetchProduct() {
                    var url = "FetchCompanyHeadline";
                    var data = {
                        name: $("#name").val()
                        , page: nowpage
                        , limit: page_limit
                        , id: com_id
                    };
                    $.post(url, data, function (res) {
                        var htmlStr = '';
                        for (var i = 0; i < res.length; i++) {
                            if (res[i].coverimg.split(',').length > 1) {
                                htmlStr += '' +
                                        '            <li>\n';
                            } else {
                                htmlStr += '' +
                                        '            <li class="one-img">\n';
                            }
                            htmlStr += '' +
                                    '                                    <a href="<?php echo base_url() ?>User/Headline/PHeadlineDetail?id=' + res[i].id + '">\n' +
                                    '                                        <div class="news-txt">\n' +
                                    '                                            <h5>' + res[i].title + '</h5>\n' +
                                    '                                        </div>\n' +
                                    '                                        <div class="news-img">\n' +
                                    '                                            <ul class="news-info">\n';
                            for (var j = 0; j < res[i].coverimg.split(',').length; j++) {
                                htmlStr += '' +
                                        ' <li>\n' +
                                        '                                                    <img src="<?php echo base_url() ?>' + res[i].coverimg.split(',')[j] + '" alt="">\n' +
                                        '                                                </li>';
                            }
                            htmlStr += '' +
                                    '                                            </ul>\n' +
                                    '                                        </div>\n' +
                                    '                                        <div class="news-item-info">\n' +
                                    '                                            <span class="news-fenlei">' + res[i].tag + '</span><span class="date">' + res[i].add_time + '</span>\n' +
                                    '                                        </div>\n' +
                                    '                                    </a>\n' +
                                    '                                </li>';
                        }
                        $("#headline_list").append(htmlStr);
                    }, 'json')
                }
                var swiper1 = new Swiper('.store-bd-img', {
                    slidesPerView: 3,
                    autoplayDisableOnInteraction: false,
                    paginationClickable: true,
                    observer: true,
                    observeParents: true,
                    spaceBetween: 5,
                    loop: true
                });

                window.onscroll = function (e) {
                    var h = $(this).scrollTop();
                    var m = $(".store-fenlei").offset().top;
                    var n = $(".store-page1").height();
                    if (m - h <= n) {
                        $(".store-page2").show();
                    }
                    if (h == 0) {
                        $(".store-page2").hide();
                    }
                };

                function ChangeCollect() {
                    if (user_id == '') {
                        layer.msg('登录后可收藏!', {time: 1500});
                        return;
                    } else {
                        var url = '<?php echo base_url() ?>index.php/User/Product/ChangeCollect';
                        var data = {
                            equal: {
                                entity_type: 9,
                                entity_id: com_id
                            }
                        };
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
                                layer.msg('登陆后可收藏!', {time: 1500});
                                return;
                            }
                        }, 'json')
                    }
                }
</script>
