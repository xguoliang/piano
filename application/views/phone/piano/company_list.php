<style>
    .active{
        color: #fba41f!important;
    }
    .active span{
        color: #fba41f!important;
    }
    .address_icon{
        width: .3rem;
        height: .3rem;
        background: url(../../assets/img/phone/address.png) no-repeat;
        background-size: 100% 100%;
        vertical-align: -.02rem;
        margin-right: .1rem;
    }
    .phone_icon{
        width: .3rem;
        height: .3rem;
        background: url(../../assets/img/phone/tel.png) no-repeat;
        background-size: 100% 100%;
        vertical-align: -.02rem;
        margin-right: .1rem;
    }
</style>
<div class="my-order good">
    <div class="inside-title">
        <i class="back"></i>
        <p>琴行</p>
    </div>
</div>
<div class="store-fenlei store-fenlei-nav">
    <div class="filterbar-container">
        <div class="filter-bar">
            <ul>
                <li style="width:50%;">
                    <span>区域</span>
                    <i class="down"></i>
                </li>
                <li style="width:50%;">
                    <span>排序</span>
                    <i class="down"></i>
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
                <li class="active" sort="1">
                    <span>人气最高</span>
                </li>
                <li sort="2">
                    <span>距离最近</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="good-list store-good-list" style="margin-top:0.88rem">
    <ul id="company_list"></ul>
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
    var name = "<?php echo $name ?>";
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
                FetchCompany();
            } else {
                alert('failed' + this.getStatus());
            }
        });
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
        $("#area").find("li").click(function () {
            $(".cover-floor").click();
            $(this).addClass("active").siblings("li").removeClass();
            $("#company_list").empty();
            nowpage = 1;
            t = 0;
            FetchCompany();
        })
        $("#sort_type").find("li").click(function () {
            $(".cover-floor").click();
            $(this).addClass("active").siblings("li").removeClass();
            $("#company_list").empty();
            nowpage = 1;
            t = 0;
            FetchCompany();
        })
    });

    function SearchData() {
        $("#company_list").empty();
        nowpage = 1;
        t = 0;
        $(".cover-floor ").click();
        FetchCompany();
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
            FetchCompany();
        }
    }

    function FetchCompany() {
        var url = "SelectCompany";
        var data = {
            page: nowpage
            , limit: page_limit
            , area: $("#area").find(".active").attr('area') == '全部' ? "" : $("#area").find(".active").attr('area')
            , lng: lng
            , lat: lat
            , sort_type: $("#sort_type").find(".active").attr('sort')
            , name: name
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
                        ' <li>\n' +
                        '            <div class="good-img">\n' +
                        '                <a href="<?php echo base_url() ?>User/Company/CompanyDetail?id=' + res[i].id + '"><img src="<?php echo base_url() ?>' + res[i].headimg.split(',')[0] + '" alt=""></a>\n' +
                        '            </div>\n' +
                        '            <div class="good-txt">\n' +
                        '                <a href="<?php echo base_url() ?>User/Company/CompanyDetail?id=' + res[i].id + '"><p class="good-name">' + res[i].name + '</p></a>\n' +
                        '                <p class="store-score"><span class="store-assess" id="star_' + res[i].id + '">';
                for (var j = 0; j < res[i].avg_star; j++) {
                    htmlStr += '<img src="<?php echo base_url(); ?>assets/img/phone/assess1.png" style="width:.32rem;">';
                }
                for (var j = res[i].avg_star; j < 5; j++) {
                    htmlStr += '<img src="<?php echo base_url(); ?>assets/img/phone/assess.png" style="width:.32rem;">';
                }
                htmlStr += '' +
                        '</span></p>' +
                        '                <p class="good-dt"><i class="address_icon"></i><span class="good-add">' + res[i].area.split(' ')[2] + '</span>' +
                        '                   <span class="good-local">' + distance + '</span>' +
                        '                    </p>\n' +
                        '                <p class="good-price"><em class="good-price1"><i class="phone_icon"></i><span class="price-num" style="color:#727272;font-size:0.28rem;">' + res[i].phone + '</span></em><button onclick="CollectProduct(' + res[i].id + ')" class="collect">收藏</button></p>\n' +
                        '            </div>\n' +
                        '        </li>';
            }
            $("#company_list").append(htmlStr);
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
            var url = "CollectProduct";
            var data = {
                save: {
                    user_id: user_id,
                    entity_id: id,
                    entity_type: 1
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
