<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a href="PAddMovie.html" class="save">发布</a>
        <p>影音制作</p>
    </div>
</div>
<div class="rent-list video-list collect-video">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
    var pages = 1;
    select_movie();
    function more() {
        pages++;
        select_movie();
    }
    function select_movie() {
        var url = "SelectMovie";
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
                            '<a href="PChangeMovie.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split(' ')[0] + '" alt=""></a>' +
                            '</div>' +
                            '<div class="rent-txt">' +
                            '<a href="PChangeMovie.html?id=' + data[i].id + '"><h5 class="rent-name">' + data[i].name + '</h5></a>' +
                            '<p><span class="rent-price">¥' + data[i].price + '/天</span><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="goto(' + data[i].id + ')">编辑</button></p>' +
                            '</div>' +
                            '</li>');
                }
            }
        });
    }
    function deletes(id) {
        if (confirm("确认删除吗")) {
            var url = "DeleteMovie";
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
    function goto(id) {
        window.location.href = "PChangeMovie.html?id=" + id;
    }
</script>