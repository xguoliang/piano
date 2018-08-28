<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a href="PAddSound" class="save">发布</a>
        <p>演唱录音</p>
    </div>
</div>
<div class="rent-list">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        select_sound();
        function more() {
            pages++;
            select_sound();
        }
        function select_sound() {
            var url = "SelectSound";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    pagesize: 10,
                    pages: pages
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (data.length < 10) {
                        $('#more').hide();
                    }
                    for (var i = 0; i < data.length; i++) {
                        $('#neirong').append('<li id="li_' + data[i].id + '">' +
                                '<div class="rent-img">' +
                                '<a href="PChangeSound.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '" alt=""></a>' +
                                '</div>' +
                                '<div class="rent-txt">' +
                                '<a href="PChangeSound.html?id=' + data[i].id + '"><h5 class="rent-name">' + data[i].name + '</h5></a>' +
                                '<p>可租时间:' + data[i].start_time + '-' + data[i].end_time + '</p>' +
                                '<p>地址：' + data[i].address + '</p>' +
                                '<p><span class="rent-price">¥' + data[i].price + '/天</span><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="goto(' + data[i].id + ')">编辑</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function goto(id) {
            window.location.href = "PChangeSound.html?id=" + id;
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeleteSound";
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (data, textStatus) {
                        $('#li_' + id).remove();
                    }
                });
            }
        }
</script>