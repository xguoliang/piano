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
            <li class="active" onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail3?id=<?php echo $company['id'] ?>'">活动</li>
            <li onclick="window.location.href = '<?php echo base_url() ?>User/Company/CompanyDetail4?id=<?php echo $company['id'] ?>'">头条</li>
        </ul>
    </div>
    <div class="filterbar-container" style="display:none">
        <div class="filter-bar">
            <ul>
                <li>
                    <span>区域</span>
                    <i class="down"></i>
                </li>
                <li>
                    <span>分类</span>
                    <i class="down"></i>
                </li>
                <li onclick="filter()">
                    <i class="filter-icon"></i>
                    <span>筛选</span>
                </li>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <ul id="area">
                <li class="active" area="全部">
                    <span>全部</span>
                </li>
                <?php foreach ($area as $k => $v) { ?>
                    <li area="<?php echo $v; ?>">
                        <span><?php echo $v; ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <ul id="sort_type">
                <li class="active" sort="3">
                    <span>价格从高到底</span>
                </li>
                <li sort="4">
                    <span>价格从低到高</span>
                </li>
            </ul>
        </div>
        <div class="filter-dt">
            <div class=" filter-dt-item">
                <h5>
                    <span>价格区间</span>
                </h5>
                <p class="filter-dt-price-area">
                    </span>
                    <input type="number" placeholder="最低价" id="min_price">
                    <span>一</span>
                    <input type="number" placeholder="最高价"  id="max_price">
                </p>
            </div>
            <div class="filter-btn">
                <button class="reset" onclick="ResetSearch()">重置</button>
                <button class="confirm" onclick="SearchData()">确定</button>
            </div>
        </div>
    </div>
</div>
<div class="activi-list cousrse-list" style="margin-top:.2rem;">
    <ul id="activity_list"></ul>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>

<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=0GgDGcoRZiNm8FVHMjIiMu53H9KiOHPU"></script>
<div id="allmap" style="display:none"></div>
<script>
                    var user_id = "<?php
                if (isset($_SESSION['lerenuser'])) {
                    echo $_SESSION['lerenuser']['id'];
                } else {
                    echo '';
                }
                ?>";
                    var nowpage = 1;
                    var page_limit = 5;
                    var p = 0, t = 0;
                    var com_id = "<?php
                if (isset($company)) {
                    echo $company['id'];
                } else {
                    echo '';
                }
                ?>";
                    var lng = '';
                    var lat = '';
                    var map = new BMap.Map("allmap");
                    var point = new BMap.Point(116.331398, 39.897445);
                    map.centerAndZoom(point, 12);
                    var geolocation = new BMap.Geolocation();
                    $(function () {
                        geolocation.getCurrentPosition(function (r) {
                            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                                lng = r.point.lng;
                                lat = r.point.lat;
                                FetchProduct();
                            } else {
                                alert('failed' + this.getStatus());
                            }
                        });
                        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
                        $("#area").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass();
                            $("#activity_list").empty();
                            nowpage = 1;
                            t = 0;
                            FetchProduct();
                        })
                        $("#sort_type").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass();
                            $("#activity_list").empty();
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
                        $("#activity_list").empty();
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
                        var url = "FetchCompanyActivity";
                        var data = {
                            name: $("#name").val()
                            , page: nowpage
                            , limit: page_limit
                            , id: com_id
                            , area: $("#area").find(".active").attr('area') == '全部' ? "" : $("#area").find(".active").attr('area')
                            , lng: lng
                            , lat: lat
                            , min_price: $("#min_price").val()
                            , max_price: $("#max_price").val()
                            , sort_type: $("#sort_type").find(".active").attr('sort')
                        };
                        $.post(url, data, function (res) {
                            var htmlStr = '';
                            for (var i = 0; i < res.length; i++) {
                                var point0 = new BMap.Point(lng, lat);
                                var point1 = new BMap.Point(res[i].lng, res[i].lat);
                                var distance = ((map.getDistance(point0, point1)).toFixed(2));
                                if (parseFloat(distance) >= 1000) {
                                    distance = (parseFloat(distance) / 1000).toFixed(1) + 'KM'
                                } else {
                                    distance = parseFloat(distance) + 'M'
                                }
                                htmlStr += '' +
                                        '      <li>\n' +
                                        '                                <div class="activi-img">\n' +
                                        '                                    <a href="<?php echo base_url() ?>User/Activity/ActivityDetail.html?id=' + res[i].id + '"><img src="<?php echo base_url() ?>' + res[i].coverimg.split(',')[0] + '"></a>\n' +
                                        '                                </div>\n' +
                                        '                                <div class="activi-txt">\n' +
                                        '                                  <a href="<?php echo base_url() ?>User/Activity/ActivityDetail.html?id=' + res[i].id + '"><h5>' + res[i].name + '</h5></a>\n' +
                                        '                                  <p class="activi-info"><em><i class="address"></i><span>' + res[i].area + '</span></em><em><i class="time"></i><span>' + res[i].add_time + '</span></em></p>\n' +
                                        '                                  <p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + res[i].price + '</span></em><button class="apply">报名</button><button onclick="CollectProduct(' + res[i].id + ')" class="collect">收藏</button></p>\n' +
                                        '                                </div>\n' +
                                        '                            </li>';
                            }
                            $("#activity_list").append(htmlStr);
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
                            $(".store-page1").hide();
                            $(".store-page2").show();
                            $(".store-fenlei").addClass("store-fenlei-nav");
                            $(".filterbar-container").css("display", "block");
                        }
                        if (h == 0) {
                            $(".store-page1").show();
                            $(".store-page2").hide();
                            $(".store-fenlei").removeClass("store-fenlei-nav");
                            $(".filterbar-container").css("display", "none");
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

                    function CollectProduct(id) {
                        if (user_id == '') {
                            layer.msg('登录后可收藏!', {time: 1500});
                            return;
                        } else {
                            var url = "CollectProduct"
                            var data = {
                                save: {
                                    user_id: user_id,
                                    entity_id: id,
                                    entity_type: 3
                                }
                            };
                            $.post(url, data, function (res) {
                                if (res.status == 1) {
                                    if (res.coll == 1) {
                                        layer.msg("收藏成功！", {time: 1500})
                                    } else {
                                        layer.msg("当前商品已经在您的收藏列表中!", {time: 1500})
                                    }
                                } else {
                                    layer.msg("登录失效，请重新登录后操作!", {time: 1500})
                                }
                            }, 'json')
                        }

                    }

</script>
