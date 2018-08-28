<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" href="PAddActivity.html">添加</a>
        <p>活动中心</p>
    </div>
    <div class="search-area">
        <span class="search-filter bigwidth">
            <input type="text" placeholder="吉他" id="search"><i class="iconfont icon-sousuo" onclick="searchs()"></i>
        </span>
    </div>
</div>
<div class="activi-list">
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
        select_activity();
        function more() {
            pages++;
            select_activity();
        }
        function searchs() {
            search = $('#search').val();
            pages = 1;
            $('#neirong').empty();
            select_activity();
        }
        function select_activity() {
            var url = "SelectActivity";
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
                                '<div class="activi-img">' +
                                '<a href="PChangeActivity.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '"></a>' +
                                '</div>' +
                                '<div class="activi-txt">' +
                                '<a href="PChangeActivity.html?id=' + data[i].id + '"><h5>' + data[i].name + '</h5></a>' +
                                '<p class="activi-info"><em><i class="address"></i><span>' + data[i].area.split(' ')[0] + '</span></em><em><i class="time"></i><span>' + data[i].add_time.split(' ')[0] + '</span></em></p>' +
                                '<p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + data[i].price + '</span></em><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="changes(' + data[i].id + ')">编辑</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function changes(id) {
            window.location.href = "PChangeActivity.html?id=" + id;
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeleteActivity";
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