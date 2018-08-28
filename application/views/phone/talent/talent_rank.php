<div class="expert good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>达人精选 </p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar band">
            <ul>
                <li class="active" data="1">
                    <span>乐手</span>
                    <i class="down"></i>
                </li>
                <li data="2">
                    <span>乐队</span>
                    <i class="down"></i>
                </li>
            </ul>
        </div>
        <div class="filter-sort filter-info">
            <h5 class="title">性别</h5>
            <p class="expert-span sex"><span class="active" data="0">全部</span><span data="1">男</span><span data="2">女</span></p>
            <h5 class="title">擅长乐器</h5>
            <p class="expert-span instrument">
                <span data="0" class="active">全部</span>
                <?php foreach ($instrument as $data_item): ?>
                    <span data="<?php echo $data_item['id']; ?>"><?php echo $data_item['name']; ?></span>
                <?php endforeach; ?>
            </p>
        </div>
        <div class="filter-sort filter-info">
            <h5 class="title">乐队风格</h5>
            <p class="expert-span music_style">
                <span data="0" class="active">全部</span>
                <?php foreach ($style as $data_item): ?>
                    <span data="<?php echo $data_item['id']; ?>"><?php echo $data_item['name']; ?></span>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
</div>
<!-- 乐手 乐队start -->
<div class="expert-list">
    <!-- 乐手 -->
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
    var pages = 1;
    var role = 1;
    var sex = 0;
    var instrument_id = 0;
    var music_style = 0;
    var rank = 1;
    var name = '<?php echo $name ?>';
    select_talent();
    $('.filter-bar').find('li').click(function () {
        if ($(this).hasClass('active') == false) {
            role = $(this).attr('data');
            emptys();
        }
    })
    $('.sex').find('span').click(function () {
        if ($(this).hasClass('active') == false) {
            $('.sex').find('span').removeClass('active');
            $(this).addClass('active');
            sex = $(this).attr('data');
            emptys();
        }
    })
    $('.instrument').find('span').click(function () {
        if ($(this).hasClass('active') == false) {
            $('.instrument').find('span').removeClass('active');
            $(this).addClass('active');
            instrument_id = $(this).attr('data');
            emptys();
        }
    })
    $('.music_style').find('span').click(function () {
        if ($(this).hasClass('active') == false) {
            $('.music_style').find('span').removeClass('active');
            $(this).addClass('active');
            music_style = $(this).attr('data');
            emptys();
        }
    })
    function emptys() {
        pages = 1;
        rank = 1;
        $('#neirong').empty();
        select_talent();
    }
    function more() {
        pages++;
        select_talent();
    }
    function select_talent() {
        var url = "SelectTalent";
        $.ajax({
            type: "post",
            url: url,
            data: {
                role: role,
                sex: sex,
                instrument_id: instrument_id,
                music_style: music_style,
                pagesize: 10,
                pages: pages,
                name: name
            },
            dataType: "json",
            success: function (data, textStatus) {
                if (role == 1) {
                    for (var i = 0; i < data.length; i++) {
                        $('#neirong').append('<li id="li_' + data[i].id + '">' +
                                '<div class="expert-num">' + rank + '</div>' +
                                '<div class="expert-img">' +
                                '<a href="<?php echo base_url(); ?>User/Band/BandsmanDetail.html?id=' + data[i].id + '"><img style="padding-top:0;position:absolute;top:.35rem;left:.13rem;height:1.45rem;" src="<?php echo base_url(); ?>' + data[i].headimg + '" alt=""></a>' +
                                '<span>乐手</span>' +
                                '</div>' +
                                '<div class="expert-info">' +
                                '<a  href="<?php echo base_url(); ?>User/Band/BandsmanDetail.html?id=' + data[i].id + '" class="expert-name">' + data[i].name + '</a>' +
                                '<p class="expert-fenlei">擅长乐器：' + data[i].instrument_name + '</p>' +
                                '</div>' +
                                '<div class="expert-atte">' +
                                '<p><i></i>人气指数<span id="count_' + data[i].id + '">' + data[i].count + '</span>人</p>' +
                                '<button onclick="collects(' + data[i].id + ',10)">关注</button>' +
                                '</div>' +
                                '</li>');
                        if (rank <= 3) {
                            $('#li_' + data[i].id).addClass('top' + rank);
                        }
                        rank++;
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        $('#neirong').append('<li id="li_' + data[i].id + '">' +
                                '<div class="expert-num">' + rank + '</div>' +
                                '<div class="expert-img">' +
                                '<a href="band-dt.html"><img src="<?php echo base_url(); ?>' + data[i].headimg + '" alt=""></a>' +
                                '<span>乐队</span>' +
                                '</div>' +
                                '<div class="expert-info">' +
                                '<a  href="band-dt.html" class="expert-name">' + data[i].name + '</a>' +
                                '</div>' +
                                '<div class="expert-atte">' +
                                '<p><i></i>人气指数<span id="count_' + data[i].id + '">' + data[i].count + '</span>人</p>' +
                                '<button onclick="collects(' + data[i].id + ',11)">关注</button>' +
                                '</div>' +
                                '</li>')
                        if (rank <= 3) {
                            $('#li_' + data[i].id).addClass('top' + rank);
                        }
                        rank++;
                    }
                }
            }
        });
    }
    function collects(id, type) {
<?php if (isset($_SESSION['lerenuser'])) {
    ?>
            var url = '<?php echo base_url(); ?>User/Product/ChangeCollect';
            var data = {
                equal: {
                    entity_type: type,
                    entity_id: id
                }
            }
            $.post(url, data, function (res) {
                if (res.status == 1) {
                    if (res.ope == 1) {
                        layer.msg('关注成功!',{time:500})

                        $('#count_' + id).text(parseInt($('#count_' + id).text()) + 1);
                    } else {
                        layer.msg('已取消关注!',{time:500})

                        $('#count_' + id).text(parseInt($('#count_' + id).text()) - 1);
                    }
                } else {
                    layer.msg('登录后可关注!',{time:500})

                }
            }, 'json')
<?php } else {
    ?>
            window.location.href = "<?php echo base_url(); ?>User/Login/PLogin.html?history=1";
    <?php
}
?>
    }
</script>