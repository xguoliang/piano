<style>
    .filterbar-container .filter-sort ul .active span{
        color: #fba41f;
    }
</style>
<div class="activi good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>乐器培训</p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar">
            <ul>
                <li>
                    <span>区域</span>
                    <i class="down"></i>
                </li>
                <li>
                    <span>全部乐器</span>
                    <i class="down"></i>
                </li>
                <li>
                    <span>价格</span>
                    <i class="down"></i>
                </li>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <ul id="area">
                <li area="" class="active">
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
            <ul id="instrument_id">
                <li class="active" instrument_id="">
                    <span>全部分类</span>
                </li>
                <?php foreach ($instrument as $k => $v) { ?>
                    <li instrument_id="<?php echo $v['name'] ?>">
                        <span><?php echo $v['name']; ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter-sort filter-info" >
            <ul id="price">
                <li min_price="0" max_price="1000">
                    <span>0-1000</span>
                </li>
                <li min_price="1000" max_price="2000">
                    <span>1k-2k</span>
                </li>
                <li min_price="2000" max_price="5000">
                    <span>2k-5k</span>
                </li>
            </ul>
            <div class=" filter-dt-item">
                <h5><span>价格区间</span></h5>
                <p class="filter-dt-price-area"></span><input type="number" placeholder="最低价" id="min_price"><span>一</span><input type="number"  placeholder="最高价" id="max_price"></p>
            </div>
            <div class="filter-btn">
                <button class="reset" onclick="ResetSearch()">重 置</button>
                <button class="confirm" onclick="SearchData()">确 定</button>
            </div>
        </div>
    </div>
</div>
<!-- 精彩活动start -->
<div class="activi-list cousrse-list">
    <ul id="lesson_list"></ul>
</div>
<!-- 精彩活动end -->
<!-- 底部导航end -->
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>

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
                    var name = '<?php echo $name ?>';
                    $(function () {
                        FetchData();
                        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
                        $("#area").find("li").click(function () {
                            $(".cover-floor").click();
                            $(this).addClass("active").siblings("li").removeClass("active");
                            $("#lesson_list").empty();
                            nowpage = 1;
                            t = 0;
                            FetchData();
                        })

                        $("#instrument_id").find("li").click(function () {
                            $(this).addClass("active").siblings("li").removeClass();
                            $('#lesson_list').empty();
                            nowpages = 1;
                            t = 0;
                            FetchData();
                            $(".cover-floor").click();
                        })
                        $("#price").find("li").click(function () {
                            $('#min_price').val($(this).attr('min_price'));
                            $('#max_price').val($(this).attr('max_price'));
                        });
                        $("#min_price").focus(function () {

                        })

                    });

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
                            FetchData();
                        }
                    }

                    function FetchData() {
                        var url = "SelectLesson";
                        min_price = $("#min_price").val();
                        max_price = $("#max_price").val();
                        var data = {
                            pages: nowpage
                            , pagesize: page_limit
                            , area: $("#area").find(".active").attr('area')
                            , min_price: min_price
                            , max_price: max_price
                            , instrument_id: $("#instrument_id").find(".active").attr('instrument_id')
                            , name: name
                        };
                        $.post(url, data, function (res) {
                            var htmlStr = '';
                            for (var i = 0; i < res.length; i++) {
                                htmlStr += '' +
                                        '<li>\n' +
                                        '            <div class="activi-img" style="position:relative;">\n' +
                                        '                <a href="LessonDetail?id=' + res[i].id + '"><img src="<?php echo base_url() ?>' + res[i].coverimg.split(',')[0] + '" style="position:absolute;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);"></a>\n' +
                                        '            </div>\n' +
                                        '            <div class="activi-txt">\n' +
                                        '                <a href="LessonDetail?id=' + res[i].id + '"><h5>' + res[i].name + '</h5></a>\n' +
                                        '                <p class="activi-info" style="margin-top:0.2rem;"><em><i class="address"></i><span>' + res[i].address + '</span></em></p>\n' +
                                        '                <p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + res[i].price + '</span></em><button class="apply" onclick="javascript:window.location.href=\'<?php echo base_url(); ?>User/Orders/ConfirmOrder?id=' + res[i].id + '&entity_type=2&com_id=' + res[i].company_id + '&num=1\'">报名</button><button class="collect buy" onclick="javascript:window.location.href=\'<?php echo base_url(); ?>User/Orders/ConfirmOrder?id=' + res[i].id + '&entity_type=2&com_id=' + res[i].company_id + '&num=1\'">购买</button></p>\n' +
                                        '            </div>\n' +
                                        '        </li>'
                            }
                            $("#lesson_list").html(htmlStr);
                        }, 'json')
                    }

                    function ResetSearch() {
                        $("#price").find("li").removeClass("active");
                        $("#min_price").val('');
                        $("#max_price").val('');
                    }

                    function SearchData() {
                        $("#lesson_list").empty();
                        nowpage = 1;
                        FetchData();
                        $(".cover-floor").click();
                    }
</script>
