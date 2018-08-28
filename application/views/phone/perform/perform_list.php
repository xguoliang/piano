<style>
    .filterbar-container .filter-sort ul .active span {
        color: #fba41f; 
    }
</style>
<div class="show good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>各类演出</p>
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
                <li style="position:relative;">
                    <input type="text" style="position:absolute;width:100%;height:100%;top:0;left:0;opacity: 0;" id="demo2" readonly onchange="change_time()">
                    <span>日期</span>
                    <i class="down"></i>
                </li>
            </ul>
        </div>
        <div class="filter-sort filter-info area">
            <ul>
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
        <div class="filter-sort filter-info types">
            <ul>
                <li data="0">
                    <span>全部分类</span>
                </li>
                <li data="1">
                    <span>酒吧驻唱</span>
                </li>
                <li data="2">
                    <span>咖啡厅</span>
                </li>
                <li data="3">
                    <span>大型演唱会</span>
                </li>
                <li data="4">
                    <span>节日宣传</span>
                </li>
                <li data="5">
                    <span>乐队演出</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 演出start -->
<div class="show-list">
    <ul id="neirong">

    </ul>
</div>
<!-- 演出end -->
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/lCalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url(); ?>assets/js/xue_more.js"></script>
<script>
                        var calendardatetime = new lCalendar();
                        calendardatetime.init({
                            'trigger': '#demo2',
                            'type': 'date'
                        });
                        var area = "";
                        var type = 0;
                        var time = "";
                        var pages = 1;
                        $(".area").find('li').click(function () {
                            if ($(this).hasClass('active') == false) {
                                $('.area').find('li').removeClass('active');
                                $(this).addClass("active");
                                area = $(this).attr('data');
                                pages = 1;
                                $('#neirong').empty();
                                select_perform();
                                $(".cover-floor").click();
                            }
                        })
                        $(".types").find('li').click(function () {
                            if ($(this).hasClass('active') == false) {
                                $('.types').find('li').removeClass('active');
                                $(this).addClass("active");
                                type = $(this).attr('data');
                                pages = 1;
                                $('#neirong').empty();
                                select_perform();
                                $(".cover-floor").click();
                            }
                        })
                        $('body').on("click", ".lcalendar_finish", function () {
                            time = $('#demo2').val();
                            pages = 1;
                            $('#neirong').empty();
                            select_perform();
                        })
                        select_perform();
                        function change_time() {
                            time = $('#demo2').val();
                            pages = 1;
                            $('#neirong').empty();
                            select_perform();
                        }
                        function more() {
                            pages++;
                            select_perform();
                        }
                        function select_perform() {
                            var url = "SelectPerform";
                            $.ajax({
                                type: "post",
                                url: url,
                                data: {
                                    area: area,
                                    type: type,
                                    time: time,
                                    pagesize: 10,
                                    pages: pages
                                },
                                dataType: "json",
                                success: function (data, textStatus) {
                                    for (var i = 0; i < data.length; i++) {
                                        $('#neirong').append('<li style="padding:0.2rem 0.2rem;">' +
                                                '<div class="show-img">' +
                                                '<a href="PerformDetail.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '" alt=""></a>' +
//                            '<i class="show-fenlei show4">节日宣传</i>' +
                                                '</div>' +
                                                '<div class="show-txt">' +
                                                '<a class="show-name" href="PerformDetail.html?id=' + data[i].id + '"><h5>' + data[i].name + '</h5></a>' +
                                                '<p class="show-add"><i></i><span>' + data[i].area.split(' ')[0] + '</span></p>' +
                                                '<p class="show-time"><i></i><span>' + data[i].start_time + '</span><span>' + data[i].end_time + '</span></p>' +
                                                '<p class="show-price"><span>¥' + data[i].price + '/场</span><a href="tel:' + data[i].phone + '"><i class="tel"></i></a></p>' +
                                                '</div>' +
                                                '</li>');
                                    }
                                }
                            });
                        }
</script>