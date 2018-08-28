<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a href="PAddLease.html" class="save">发布</a>
        <p>设备租赁</p>
    </div>
    <div class="search-area">
        <span class="search-filter bigwidth">
            <input type="text" placeholder="吉他" id="search"><i class="iconfont icon-sousuo" onclick="searchs()"></i>
        </span>
    </div>
</div>
<div class="rent-list">
    <ul id="neirong">

    </ul>
    <div onclick="more()" id="more" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var search = "";
        var pages = 1;
        select_lease();
        function searchs() {
            search = $('#search').val();
            $('#more').show();
            pages = 1;
            $('#neirong').empty();
            select_lease();
        }
        function more() {
            pages++;
            select_lease();
        }
        function select_lease() {
            var url = "SelectLease";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    search: search,
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
                                '<a href="PChangeLease.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '" alt=""></a>' +
                                '</div>' +
                                '<div class="rent-txt">' +
                                '<a href="PChangeLease.html?id=' + data[i].id + '"><h5 class="rent-name">' + data[i].name + '</h5></a>' +
                                '<p>可租时间:' + data[i].start_time + '-' + data[i].end_time + '</p>' +
                                '<p>地址：' + data[i].address + '</p>' +
                                '<p><span class="rent-price">¥' + data[i].money + '/天</span><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="changes(' + data[i].id + ')">编辑</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function changes(id) {
            window.location.href = "PChangeLease.html?id=" + id;
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeleteLease";
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