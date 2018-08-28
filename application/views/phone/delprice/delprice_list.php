<style>
    .active{
        color: #fba41f!important;
    }
    .active span{
        color: #fba41f!important;
    }
</style>
<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>降价排行</p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar">
            <ul>
                <li>
                    <span>区域</span>
                    <i class="down"></i>
                </li>
                <li>
                    <span>排序</span>
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
                <li class="active" area="">
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
                <li class="active" sort="1">
                    <span>人气最高</span>
                </li>
                <li sort="2">
                    <span>距离最近</span>
                </li>
                <li sort="3">
                    <span>降价从高到低</span>
                </li>
                <li sort="4">
                    <span>降价从低到高</span>
                </li>
            </ul>
        </div>
        <div class="filter-dt">
            <div class="filter-dt-item">
                <h5><span>价格区间</span></h5>
                <p class="filter-dt-price-area">
                    <input type="number" placeholder="最低价" id="min_price">
                    <span>一</span>
                    <input type="number" placeholder="最高价"  id="max_price">
                </p>
            </div>
            <div class=" filter-dt-item">
                <h5><span>品牌</span><i></i></h5>
                <ul class="filter-dt-brand" id="brand_id">
                    <?php foreach ($brand as $k => $v) { ?>
                        <li brand_id="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="filter-btn">
                <button class="reset" onclick="ResetSearch()">重置</button>
                <button class="confirm" onclick="SearchData()">确定</button>
            </div>
        </div>
    </div>
</div>
<div class="good-list delprice-list">
    <ul id="delprice_list"></ul>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>
<div id="allmap" style="display:none"></div>

<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=0GgDGcoRZiNm8FVHMjIiMu53H9KiOHPU"></script>

<script>
                    var user_id = "<?php if (isset($_SESSION['lerenuser'])) {
                        echo $_SESSION['lerenuser']['id'];
                    } else {
                        echo '';
                    } ?>";
                    var nowpage = 1;
                    var page_limit = 5;
                    var p = 0, t = 0;
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
                                FetchDelprice();
                            } else {
                                alert('failed' + this.getStatus());
                            }
                        });
                        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
                        $("#area").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass();
                            $("#delprice_list").empty();
                            nowpage = 1;
                            t = 0;
                            FetchDelprice();
                        })
                        $("#sort_type").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass();
                            $("#delprice_list").empty();
                            nowpage = 1;
                            t = 0;
                            FetchDelprice();
                        })
                        $("#brand_id").find("li").click(function () {
                            if ($(this).hasClass("active")) {
                                $(this).removeClass("active");
                            } else {
                                $(this).addClass("active").siblings("li").removeClass();
                            }
                        })
                    });

                    function SearchData() {
                        $("#delprice_list").empty();
                        nowpage = 1;
                        t = 0;
                        $(".cover-floor ").click();
                        FetchDelprice();
                    }

                    function ResetSearch() {
                        $("#area").find("li").removeClass("active").eq(0).addClass('active');
                        $("#brand_id").find('.active').removeClass("active");
                        $("#sort_type").find("li").removeClass('active').eq(0).addClass("active");
                        $("#min_price").val('');
                        $("#max_price").val('');
                    }

                    function FetchDelprice() {
                        var url = "GetDelprice";
                        var data = {
                            page: nowpage
                            , limit: page_limit
                            , area: $("#area").find(".active").attr('area') == '全部' ? "" : $("#area").find(".active").attr('area')
                            , lng: lng
                            , lat: lat
                            , min_price: $("#min_price").val()
                            , max_price: $("#max_price").val()
                            , sort_type: $("#sort_type").find(".active").attr('sort')
                            , brand_id: ($("#brand_id").find(".active").length > 0) ? $("#brand_id").find(".active").attr('brand_id') : ''
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
                                        '<li>\n' +
                                        '            <div class="good-img">\n' +
                                        '                <a href="<?php echo base_url() ?>User/Product/PProductDetail?id=' + res[i].id + '"><img src="<?php echo base_url() ?>' + res[i].coverimg.split(',')[0] + '" alt=""><i class="discount"></i></a>\n' +
                                        '            </div>\n' +
                                        '            <div class="good-txt">\n' +
                                        '                <a href="<?php echo base_url() ?>User/Product/PProductDetail?id=' + res[i].id + '"><p class="good-name">' + res[i].name + '</p></a>\n' +
                                        '                <a href="<?php echo base_url() ?>User/Company/CompanyDetail?id=' + res[i].com_id + '"><p class="shop-name">' + res[i].com_name + '</p></a>\n' +
                                        '                <p class="good-dt"><span class="good-add">' + res[i].area.split(' ')[2] + '</span><span class="good-fenlei">' + res[i].ins_name + '</span><span class="good-local">' + distance + '</span></p>\n' +
                                        '                <p class="good-price"><em class="good-price1"><span class="price-icon">¥</span><span class="price-num">' + res[i].price + '</span></em><em class="good-price2">原价<span class="price-icon" style="font-size:0.2rem;">¥</span><span class="price-num" style="font-size:0.2rem;">' + res[i].show_price + '</span></em><button class="collect" onclick="ChangeCollect(' + res[i].id + ')">收藏</button></p>\n' +
                                        '            </div>\n' +
                                        '        </li>';
                            }
                            $("#delprice_list").append(htmlStr);
                        }, 'json')
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
                            FetchDelprice();
                        }
                    }


                    function ChangeCollect(id) {
                        if (user_id == '') {
                            layer.msg('登录后可收藏!', {time: 1500});
                            return;
                        } else {
                            var url = '<?php echo base_url() ?>index.php/User/Product/ChangeCollect';
                            var data = {
                                equal: {
                                    entity_type: 1,
                                    entity_id: id
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