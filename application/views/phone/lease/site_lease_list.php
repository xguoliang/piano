<style>
    #area .active span{
        color: #fba41f;
    }
    #instrument .active span{
        color: #fba41f;
    }
    #type .active span{
        color: #fba41f;
    }
</style>
<div class="rent good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>场地租赁</p>
    </div>
    <div class="filterbar-container band">
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
                <li>
                    <i class="filter-icon"></i>
                    <span>筛选</span>
                </li>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <ul id="area">
                <li data="" class="active">
                    <span>全部地区</span>
                </li>
                <?php for ($i = 0; $i < count($area); $i++) { ?>
                    <li data="<?php echo $area[$i]; ?>">
                        <span><?php echo $area[$i]; ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <ul id="type">
                <li data="0" class="active">
                    <span>全部分类</span>
                </li>
                <li data="1">
                    <span>排练场</span>
                </li>
                <li data="2">
                    <span>演出场</span>
                </li>
                <li data="3">
                    <span>相亲角</span>
                </li>
                <li data="4">
                    <span>弄堂里</span>
                </li>
                <li data="5">
                    <span>交友角</span>
                </li>
            </ul>
        </div>
        <div class="filter-sort filter-info" >
            <ul id="prices">
                <li data="0" value="1000">
                    <span>0-1000</span>
                </li>
                <li data="1000" value="2000">
                    <span>1k-2k</span>
                </li>
                <li data="2000" value="5000">
                    <span>2k-5k</span>
                </li>
            </ul>
            <div class=" filter-dt-item">
                <h5><span>价格区间</span></h5>
                <p class="filter-dt-price-area"></span><input type="number" placeholder="最低价" id="min_price"><span>一</span><input type="number"  placeholder="最高价" id="max_price"></p>
            </div>
            <div class="filter-btn">
                <button class="reset" onclick="resets()">重 置</button>
                <button class="confirm" onclick="searchs()">确 定</button>
            </div>
        </div>
    </div>
</div>
<!-- 设备租赁start -->
<div class="rent-list">
    <ul id="neirong">

    </ul>
</div>
<!-- 设备租赁end -->
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url(); ?>assets/js/xue_more.js"></script>
<script>
                    var pages = 1;
                    var area = "";
                    var type = 0;
                    var min_price = "";
                    var max_price = "";
                    var name = '<?php echo $name ?>';
                    $(function () {
                        $('#area li').click(function () {
                            $('#area li').removeClass('active');
                            $(this).addClass('active');
                            area = $(this).attr('data');
                            pages = 1;
                            $('#neirong').empty();
                            select_lease();
                            $(".cover-floor").click();
                        })
                        $('#type li').click(function () {
                            $('#type li').removeClass('active');
                            $(this).addClass('active');
                            type = $(this).attr('data');
                            pages = 1;
                            $('#neirong').empty();
                            select_lease();
                            $(".cover-floor").click();
                        })
                        $('#prices li').click(function () {
                            $('#min_price').val($(this).attr('data'));
                            $('#max_price').val($(this).attr('value'));
                        })
                    })
                    select_lease();
                    function resets() {
                        $('#area li').removeClass('active');
                        $('#type li').removeClass('active');
                        $('#min_price').val('');
                        $('#max_price').val('');
//                        area = "";
//                        type = 0;
//                        min_price = "";
//                        max_price = "";
//                        pages = 1;
//                        $('#neirong').empty();
//                        select_lease();
//                        $(".cover-floor").click();
                    }
                    function searchs() {
                        min_price = $('#min_price').val();
                        max_price = $('#max_price').val();
                        pages = 1;
                        $('#neirong').empty();
                        select_lease();
                        $(".cover-floor").click();
                    }
                    function more() {
                        pages++;
                        select_lease();
                    }
                    function select_lease() {
                        var url = "SelectSiteLease";
                        $.ajax({
                            type: "post",
                            url: url,
                            data: {
                                area: area,
                                type: type,
                                min_price: min_price,
                                max_price: max_price,
                                pagesize: 10,
                                pages: pages,
                                name: name
                            },
                            dataType: "json",
                            success: function (data, textStatus) {
                                for (var i = 0; i < data.length; i++) {
                                    $('#neirong').append('<li>' +
                                            '<div class="rent-img">' +
                                            '<a href="SiteLeaseDetail.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '" alt=""></a>' +
                                            '</div>' +
                                            '<div class="rent-txt">' +
                                            '<a href="tel:' + data[i].phone + '"><i class="tel"></i></a>' +
                                            '<a href="SiteLeaseDetail.html?id=' + data[i].id + '"><h5 class="rent-name">' + data[i].name + '</h5></a>' +
                                            '<p>可租时间:' + data[i].start_time + '-' + data[i].end_time + '</p>' +
                                            '<p>地址：' + data[i].address + '</p>' +
                                            '<span class="rent-price">¥' + data[i].money + '/天</span>' +
                                            '</div>' +
                                            '</li>');
                                }
                            }
                        });
                    }
</script>