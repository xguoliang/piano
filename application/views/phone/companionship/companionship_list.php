<style>
    .filterbar-container .filter-sort ul .active span{
        color:#fba41f;
    }
</style>
<div class="partner good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="band-build" href="<?php echo base_url(); ?>User/Bandsman/PAddCampanionship.html"><i class="build-icon"></i><span>发起</span></a>
        <p>陪伴练习</p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar band">
            <ul>
                <li>
                    <span>区域</span>
                    <i class="down"></i>
                </li>
                <li>
                    <span>乐器</span>
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
        <div class="filter-sort filter-info instrument">
            <ul>
                <li data="" class="active">
                    <span>全部分类</span>
                </li>
                <?php foreach ($instrument as $data_item): ?>
                    <li data="<?php echo $data_item['name']; ?>">
                        <span><?php echo $data_item['name']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 陪伴练习start -->
<div class="partner-list">
    <ul id="neirong">

    </ul>
</div>

<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url(); ?>assets/js/xue_more.js"></script>
<script>
    var area = "";
    var instrument_id = "";
    var pages = 1;
    $('.area').find('li').click(function () {
        if ($(this).hasClass('active') == false) {
            $('.area').find('li').removeClass('active');
            $(this).addClass('active');
            area = $(this).attr('data');
            pages = 1;
            $('#neirong').empty();
            select_companionship();
            $(".cover-floor").click();
        }
    })
    $('.instrument').find('li').click(function () {
        if ($(this).hasClass('active') == false) {
            $('.instrument').find('li').removeClass('active');
            $(this).addClass('active');
            instrument_id = $(this).attr('data');
            pages = 1;
            $('#neirong').empty();
            select_companionship();
            $(".cover-floor").click();
        }
    })
    select_companionship();
    function more() {
        pages++;
        select_companionship();
    }
    function select_companionship() {
        var url = "SelectCompanionship";
        $.ajax({
            type: "post",
            url: url,
            data: {
                area: area,
                instrument_id: instrument_id,
                pagesize: 10,
                pages: pages
            },
            dataType: "json",
            success: function (data, textStatus) {
                for (var i = 0; i < data.length; i++) {
                    $('#neirong').append('<li>' +
                            '<p><a class="partner-name" href="">' + data[i].name + '</a><a href="tel:' + data[i].phone + '"><i class="tel"></i></a></p>' +
                            '<p><i class="time"></i><span>陪练时间:' + data[i].companionship_time + '</span></p>' +
                            '<p class="partner-add"><span><i class="add"></i><span>' + data[i].area.split(' ')[0] + '</span><button onclick="apply(' + data[i].id + ')">我来陪练</button></p>' +
                            '</li>');
                }
            }
        });
    }
    function apply(companionship_id) {
<?php if (isset($_SESSION['lerenuser'])) { ?>
            var url = "ApplyCompanionship";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    companionship_id: companionship_id
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (data == 1) {
                        layer.msg("申请成功！", {time: 1500})
                    } else if (data == 2) {
                        layer.msg("已申请过！", {time: 1500})
                    } else if (data == 3) {
                        layer.msg("请不要申请自己的陪伴练习！", {time: 1500})
                    } else {

                    }
                }
            });
<?php } else {
    ?>
            window.location.href = "<?php echo base_url(); ?>User/Login/PLogin.html";
<?php }
?>
    }
</script>