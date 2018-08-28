<style>
    .filterbar-container .bands ul li{
        width:100%;
    }
    .filterbar-container .filter-sort ul .active span{
        color:#fba41f;
    }
</style>
<div class="bandbuild good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="band-build" href="<?php echo base_url(); ?>User/Bandsman/PAddBand.html"><i class="build-icon"></i><span>发起</span></a>
        <p>乐队组建</p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar bands">
            <ul>
                <!--                <li>
                                    <span>区域</span>
                                    <i class="down"></i>
                                </li>-->
                <li>
                    <span>擅长乐器</span>
                    <i class="down"></i>
                </li>
            </ul>
        </div>
        <!--        <div class="filter-sort filter-info">
                    <ul>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                        <li>
                            <span>浦东新区</span>
                        </li>
                    </ul>
                </div>-->
        <div class="filter-sort filter-info">
            <ul id="need">
                <li class="active" data="">
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
<!-- 乐队组建start -->
<div class="bandbuild-list">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<!-- 乐队组建end -->
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        var need = "";
        var name = "<?php echo $name ?>";
        select_band();
        $('#need li').click(function () {
            $('#need li').removeClass('active');
            $(this).addClass('active');
            need = $(this).attr('data');
            $('#neirong').empty();
            pages = 1;
            select_band();
            $(".cover-floor ").click();
        })
        function more() {
            pages++;
            select_band();
        }
        function select_band() {
            var url = "SelectBand";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    pagesize: 10,
                    pages: pages,
                    name: name,
                    need: need
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (data.length < 10) {
                        $('#more').hide();
                    }
                    for (var i = 0; i < data.length; i++) {
                        $('#neirong').append('<li id="li_' + data[i].id + '">' +
                                '<p><a class="band-name" href="PBandDetail.html?id=' + data[i].id + '">' + data[i].name + '</a><span class="band-state" id="status_' + data[i].id + '"></span></p>' +
                                '<div class="need-member">' +
                                '<h5>需要成员：</h5>' +
                                '<p><span>' + data[i].need + '</span></p>' +
                                '</div>' +
                                '<p class="bandbuild-date" id="caozuo_' + data[i].id + '"><span>' + data[i].add_time + '</span><button id="button_' + data[i].id + '" onclick="applys(' + data[i].id + ')">加 入</button></p>' +
                                '</li>');
                        if (data[i].status == 0) {
                            $('#status_' + data[i].id).text('正在组建中...');
                        } else {
                            $('#status_' + data[i].id).text('组建完成');
                            $('#button_' + data[i].id).remove();
                        }
                    }
                }
            });
        }
        function applys(id) {
            var url = "ApplyBand";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (data == 1) {
                        layer.msg('申请成功!', {time: 1500})
                    } else if (data == 2) {
                        layer.msg('请先编辑乐手信息!', {time: 1500})
                    } else if (data == 3) {
                        layer.msg('已申请过!', {time: 1500})
                    } else if (data == 4) {
                        layer.msg('请先登录!', {time: 1500})
                    } else if (data == 5) {
                        layer.msg('请不要申请自己的乐队!', {time: 1500})
                    } else {

                    }
                }
            });
        }
</script>