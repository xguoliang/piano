<div class="good ">
    <div class="inside-title">
        <i class="back"></i>
        <a href="PAddHeadline.html" class="save">发布</a>
        <p>新闻头条</p>
    </div>
</div>
<div class="news-list">
    <ul class="news-item" id="neirong">

    </ul>
    <div onclick="more()" id="more" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        select_headline();
        function more() {
            pages++;
            select_headline();
        }
        function select_headline() {
            var url = "SelectHeadline";
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
                        var coverimg = data[i].coverimg.split(',');
                        if (coverimg.length < 3) {
                            $('#neirong').append('<li class="one-img" id="li_' + data[i].id + '">' +
                                    '<a href="PChangeHeadline.html?id=' + data[i].id + '">' +
                                    '<div class="news-txt">' +
                                    '<h5>' + data[i].title + '</h5>' +
                                    '<div class="news-item-info">' +
                                    '<span class="news-fenlei">' + data[i].tag + '</span><span class="date">' + data[i].time.split(' ')[0] + '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="news-img">' +
                                    '<ul class="news-info">' +
                                    '<li>' +
                                    '<img src="<?php echo base_url(); ?>' + coverimg[0] + '" alt="">' +
                                    '</li>' +
                                    '</ul>' +
                                    '</div>' +
                                    '<div class="news-item-info" style="float:left;">' +
                                    '<button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="goto(' + data[i].id + ')">编辑</button>' +
                                    '</div>' +
                                    '</a>' +
                                    '</li>');
                        } else {
                            $('#neirong').append('<li id="li_' + data[i].id + '">' +
                                    '<a href="PChangeHeadline.html?id=' + data[i].id + '">' +
                                    '<div class="news-txt">' +
                                    '<h5>' + data[i].title + '</h5>' +
                                    '</div>' +
                                    '<div class="news-img">' +
                                    '<ul class="news-info">' +
                                    '<li>' +
                                    '<img src="<?php echo base_url(); ?>' + coverimg[0] + '" alt="">' +
                                    '</li>' +
                                    '<li>' +
                                    '<img src="<?php echo base_url(); ?>' + coverimg[1] + '" alt="">' +
                                    '</li>' +
                                    '<li>' +
                                    '<img src="<?php echo base_url(); ?>' + coverimg[2] + '" alt="">' +
                                    '</li>' +
                                    '</ul>' +
                                    '</div>' +
                                    '<div class="news-item-info">' +
                                    '<span class="news-fenlei">' + data[i].tag + '</span><span class="date">' + data[i].time.split(' ')[0] + '</span><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="goto(' + data[i].id + ')">编辑</button>' +
                                    '</div>' +
                                    '</a>' +
                                    '</li>');
                        }
                    }
                }
            });
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeleteHeadline";
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
            window.location.href = "PChangeHeadline.html?id=" + id;
        }
</script>