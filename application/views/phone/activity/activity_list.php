<style>
    .active{
        color: #fba41f!important;
    }
    .active span{
        color: #fba41f!important;
    }
</style>

<div class="activi good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>精彩活动</p>
    </div>
    <div class="filterbar-container">
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
                <h5 style="border:none;">
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
<div class="activi-list cousrse-list">
    <ul id="activity_list"></ul>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>

<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>

<script>
                    var user_id = "<?php if (isset($_SESSION['lerenuser'])) {
                    echo $_SESSION['lerenuser']['id'];
                } else {
                    echo '';
                } ?>";
                    var nowpage = 1;
                    var page_limit = 5;
                    var p = 0, t = 0;

                    $(function () {
                        FetchProduct();
                        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
                        $("#area").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass("active");
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
                        var url = "<?php echo base_url() ?>User/Company/FetchCompanyActivity";
                        var data = {
                            name: ''
                            , page: nowpage
                            , limit: page_limit
                            , id: ''
                            , area: $("#area").find(".active").attr('area') == '全部' ? "" : $("#area").find(".active").attr('area')
                            , min_price: $("#min_price").val()
                            , max_price: $("#max_price").val()
                            , sort_type: $("#sort_type").find(".active").attr('sort')
                        };
                        $.post(url, data, function (res) {
                            var htmlStr = '';
                            for (var i = 0; i < res.length; i++) {
                                htmlStr += '' +
                                        '      <li>\n' +
                                        '                                <div class="activi-img">\n' +
                                        '                                    <a href="<?php echo base_url() ?>User/Activity/ActivityDetail.html?id=' + res[i].id + '"><img src="<?php echo base_url() ?>' + res[i].coverimg.split('|')[0] + '"></a>\n' +
                                        '                                </div>\n' +
                                        '                                <div class="activi-txt">\n' +
                                        '                                  <a href="<?php echo base_url() ?>User/Activity/ActivityDetail.html?id=' + res[i].id + '"><h5>' + res[i].name + '</h5></a>\n' +
                                        '                                  <p class="activi-info"><em><i class="address"></i><span>' + res[i].area.split(' ')[2] + '</span></em><em><i class="time"></i><span>' + res[i].start_time + '</span></em></p>\n' +
                                        '                                  <p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + res[i].price + '</span></em><button class="apply" onclick="ConfirmOrder(' + res[i].company_id + ',' + res[i].id + ')">报名</button><button onclick="CollectProduct(' + res[i].id + ')" class="collect">收藏</button></p>\n' +
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
                            var url = "<?php echo base_url() ?>index.php/User/Company/CollectProduct"
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


                    function ConfirmOrder(com_id, pro_id) {
                        var num = $("#pro_num").text();
                        if (user_id == '') {
                            layer.msg('登录后可购买', {time: 1500})
                            return;
                        } else {
                            var url = "<?php echo base_url() ?>User/Orders/ConfirmOrder?id=" + pro_id + '&entity_type=3&com_id=' + com_id + '&num=' + 1;
                            window.location.href = url;
                        }
                    }
</script>
