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
        <!--<i class="search"></i>-->
        <p>发现好货</p>
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
                <li  class="active">
                    <span>全部</span>
                </li>
                <?php foreach ($area as $k => $v) { ?>
                    <li>
                        <span><?php echo $v ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <ul id="sort_type">
                <li sort="1" class="active">
                    <span>人气最高</span>
                </li>
                <li sort="2">
                    <span>距离最近</span>
                </li>
                <li sort="3">
                    <span>价格从高到底</span>
                </li>
                <li sort="4">
                    <span>价格从低到高</span>
                </li>
            </ul>
        </div>
        <div class="filter-dt">
            <div class="filter-dt-item">
                <h5>
                    <span>全部类目</span>
                    <i></i>
                </h5>
                <ul class="filter-dt-all" id="type">
                    <li class="active" type="1">课程</li>
                    <li type="2">乐器</li>
                    <li type="3">场地</li>
                    <!--                    <li type="4">视频</li>-->
                </ul>
            </div>
            <div class=" filter-dt-item">
                <h5 style="border:none;">
                    <span>价格区间</span>
                </h5>
                <p class="filter-dt-price-area">
                    <input id="min_price" type="number" placeholder="最低价">
                    <span>一</span>
                    <input id="max_price" type="number" placeholder="最高价">
                </p>
            </div>
            <div class=" filter-dt-item" id="pinpai" style="display:none;">
                <h5>
                    <span>品牌</span>
                    <i></i>
                </h5>
                <ul class="filter-dt-brand" id="brand_id">
                    <?php foreach ($brand as $k => $v) { ?>
                        <li brand_id="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="filter-btn">
                <button class="reset" onclick="ResetSearch()">重置</button>
                <button class="confirm" onclick="$('.cover-floor').click();nowpage = 0;select_good()">确定</button>
            </div>
        </div>
    </div>

</div>
<div class="good-list">
    <ul id="good_list"></ul>
</div>
<div class="mask">
    <div class="cover-floor"></div>
</div>
<div style="display:none" id="allmap"></div>
<?php $this->load->view('phone/foot', array('nav' => 3)) ?>

<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=0GgDGcoRZiNm8FVHMjIiMu53H9KiOHPU"></script>
<script>
                    var user_id = "<?php
if (isset($_SESSION['lerenuser'])) {
    echo $_SESSION['lerenuser']['id'];
} else {
    echo '';
}
?>";
                    var entity_type = 2;
                    var nowpage = 0;
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
                                select_good();
                            } else {
                                alert('failed' + this.getStatus());
                            }
                        });
                        $("#area").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass();
                            nowpage = 0;
                            select_good();
                        })
                        $("#sort_type").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass();
                            nowpage = 0;
                            select_good();
                        })
                        $("#type").find("li").click(function () {
                            $(this).addClass("active").siblings("li").removeClass();
                            if ($(this).index() == 1) {
                                $('#pinpai').show();
                            } else {
                                $('#pinpai').hide();
                            }
                            // nowpage = 0;
                        })
                        $("#brand_id").find("li").click(function () {
                            if ($(this).hasClass("active")) {
                                $(this).removeClass("active");
                            } else {
                                $(this).addClass("active").siblings("li").removeClass();
                            }
                            // nowpage = 0;
                        })
                    });
                    function select_good() {
                        if (nowpage == 0) {
                            $("#good_list").empty()
                        }
                        nowpage += 1;
                        var url = 'SelectGood';
                        var data = {};
                        if ($("#area").find(".active").length > 0) {
                            data.area = $("#area").find(".active").find("span").text();
                            if (data.area == '全部') {
                                data.area = '';
                            }
                        } else {
                            data.area = '';
                        }
                        if ($("#sort_type").find(".active").length > 0) {
                            data.sort_type = $("#sort_type").find(".active").attr('sort');
                        } else {
                            data.sort_type = '';
                        }
                        if ($("#type").find(".active").length > 0) {
                            data.type = $("#type").find(".active").attr('type');
                        } else {
                            data.type = 1;
                        }
                        if (data.type == 1) {
                            entity_type = 2;
                        } else if (data.type == 2) {
                            entity_type = 1;
                        } else {
                            entity_type = 6;
                        }

                        if ($("#brand_id").find(".active").length > 0) {
                            data.brand_id = $("#brand_id").find(".active").attr('brand_id');
                        } else {
                            data.brandid = 0;
                        }
                        data.lng = lng;
                        data.lat = lat;
                        data.pagesize = 5;
                        data.pages = nowpage;
                        data.min_price = $("#min_price").val();
                        data.max_price = $("#max_price").val();
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
                                        '            <div class="good-img">\n';
                                if (data.type == 1) {
                                    htmlStr += '' +
                                            '                <a href="<?php echo base_url() ?>User/Lesson/LessonDetail?id=' + res[i].id + '">\n';
                                } else {
                                    htmlStr += '' +
                                            '                <a href="PProductDetail?type=' + data.type + '&id=' + res[i].id + '">\n';
                                }
                                htmlStr += '' +
                                        '                    <img src="<?php echo base_url() ?>' + res[i].coverimg.split(',')[0] + '" alt="">\n' +
                                        '                </a>\n' +
                                        '            </div>\n' +
                                        '            <div class="good-txt">\n';
                                if (data.type == 1) {
                                    htmlStr += '' +
                                            '                <a href="<?php echo base_url() ?>User/Lesson/LessonDetail?id=' + res[i].id + '">\n';
                                } else {
                                    htmlStr += '' +
                                            '                <a href="PProductDetail?type=' + data.type + '&id=' + res[i].id + '">\n';
                                }
                                htmlStr += '' +
                                        '                    <p class="good-name">' + res[i].name + '</p>\n' +
                                        '                </a>\n' +
                                        '                <a>\n' + //进入店铺详情
                                        '                    <p class="shop-name">' + res[i].com_name + '</p>\n' +
                                        '                </a>\n' +
                                        '                <p class="good-dt">\n' +
                                        '                    <span class="good-add">' + res[i].area.split(' ')[2] + '</span>\n' +
                                        '                    <span class="good-fenlei">' + res[i].ins_name + '</span>\n';
                                if (data.type != 3) {
                                    htmlStr += '' +
                                            '                    <span class="good-local">' + distance + '</span>\n';
                                }
                                htmlStr += '' +
                                        '                </p>\n' +
                                        '                <p class="good-price">\n' +
                                        '                    <em class="good-price1">\n' +
                                        '                        <span class="price-icon">¥</span>\n' +
                                        '                        <span class="price-num">' + (data.type == 3 ? res[i].money : res[i].price) + '</span>\n' +
                                        '                    </em>\n';
                                if (data.type == 2) {
                                    htmlStr += '' +
                                            '                    <em class="good-price2">原价\n' +
                                            '                        <span class="price-icon">¥</span>\n' +
                                            '                        <span class="price-num">' + res[i].show_price + '</span>\n' +
                                            '                    </em>\n';
                                }
                                htmlStr += '' +
                                        '                    <button class="collect" onclick="Favorite(' + res[i].id + ')">收藏</button>\n' +
                                        '                </p>\n' +
                                        '            </div>\n' +
                                        '        </li>';
                            }


                            $("#good_list").html(htmlStr);
                        }, 'json')
                    }

                    function ResetSearch() {
                        $("#area").find("li").removeClass("active").eq(0).addClass("active");
                        $("#sort_type").find("li").removeClass("active").eq(0).addClass("active");
                        $("#min_price").val('')
                        $("#max_price").val('')
                        $("#brand_id").find("li").removeClass("active");
                    }

                    function Favorite(id) {
                        if (user_id == '') {
                            layer.msg('登录后可收藏!', {time: 1500});
                            return;
                        } else {
                            var url = '<?php echo base_url() ?>index.php/User/Product/ChangeCollect';
                            var data = {
                                equal: {
                                    entity_type: entity_type,
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
