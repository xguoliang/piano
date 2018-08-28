<div class="business good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>演出买卖</p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar band">
            <ul>
                <li class="active">
                    <span>乐手</span>
                    <i class="down"></i>
                </li>
                <li>
                    <span>乐队</span>
                    <i class="down"></i>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 陪伴练习start -->
<div class="business-list">
    <ul id="neirong">

    </ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url(); ?>assets/js/xue_more.js"></script>
<script>
    var type = 1;
    var pages = 1;
    select_business();
    function more() {
        pages++;
        select_business();
    }
    function select_business() {
        var url = "SelectBusiness";
        $.ajax({
            type: "post",
            url: url,
            data: {
                type: type,
                pagesize: 10,
                pages: pages
            },
            dataType: "json",
            success: function (data, textStatus) {
                if (type == 1) {
                    for (var i = 0; i < data.length; i++) {
                        $('#neirong').append('<li>' +
                                '<div class="business-img">' +
                                '<a href="BusinessDetail.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].headimg + '" alt="" style="position:absolute;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);"></a>' +
                                '<span class="business-span">乐手</span>' +
                                '</div>' +
                                '<div class="business-txt">' +
                                '<p><a href="BusinessDetail.html?id=' + data[i].id + '" class="business-name">' + data[i].name + '</a><span class="bandsman">擅长乐器：' + data[i].instrument_name + '</span></p>' +
                                '<p class="business-price"><span>出场费</span><span>¥' + data[i].price + '/次</span><button class="yaoqing" data="' + data[i].price + '">邀请</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        $('#neirong').append('<li>' +
                                '<div class="business-img">' +
                                '<a href="band-dt.html"><img src="assets/img/expert.png" alt=""></a>' +
                                '<span class="business-span">乐队</span>' +
                                '</div>' +
                                '<div class="business-txt">' +
                                '<p><a href="band-dt.html" class="business-name">乐队名称</a></p>' +
                                '<p class="business-price"><span>出场费</span><span>¥12000/次</span><button>邀请</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
                $('.yaoqing').click(function () {
                    var phone = $(this).attr('data');
                    window.location.href = "tel:" + phone;
                })
            }
        });
    }
</script>