<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a href="PAddPerform.html" class="save">添加</a>
        <p>演出管理</p>
    </div>
    <div class="search-area">
        <span class="search-filter bigwidth">
            <input type="text" placeholder="吉他" id="search"><i class="iconfont icon-sousuo" onclick="searchs()"></i>
        </span>
    </div>
</div>
<div class="show-list">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var search = "";
        var pages = 1;
        select_perform();
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
                                '<div class="show-img">' +
                                '<a href="<?php echo base_url()?>User/Perform/PerformDetail.html?id='+data[i].id+'"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '" alt=""></a>' +
//                                '<i class="show-fenlei show1">酒吧</i>' +
                                '</div>' +
                                '<div class="show-txt">' +
                                '<a class="show-name" href="<?php echo base_url()?>User/Perform/PerformDetail.html?id='+data[i].id+'"><h5>' + data[i].name + '</h5></a>' +
                                '<p class="show-add"><i></i><span>' + data[i].area.split(' ')[0] + '</span></p>' +
                                '<p class="show-time"><i></i><span>' + data[i].start_time + '</span>-<span>' + data[i].end_time + '</span></p>' +
                                '<p class="show-price"><span>¥' + data[i].price + '</span>><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="changes(' + data[i].id + ')">编辑</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function changes(id) {
            window.location.href = "PChangePerform.html?id=" + id;
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeletePerform";
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