<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>演出收藏</p>
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
        var pages = 1;
        select_perform();
        function more() {
            pages++;
            select_perform();
        }
        function select_perform() {
            var url = "<?php echo base_url(); ?>User/Student/MyCollectPerform";
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
                                '<div class="show-img">' +
                                '<a href="User/Perform/PerformDetail.html?id=' + data[i].entity_id + '"><img src="<?php echo base_url(); ?>' + data[i].perform.coverimg.split('|')[0] + '" alt=""></a>' +
                                '</div>' +
                                '<div class="show-txt">' +
                                '<a class="show-name" href="User/Perform/PerformDetail.html?id=' + data[i].entity_id + '"><h5>' + data[i].perform.name + '</h5></a>' +
                                '<p class="show-add"><i></i><span>' + data[i].perform.area.split(' ')[0] + '</span></p>' +
                                '<p class="show-time"><i></i>' + data[i].perform.start_time + '-' + data[i].perform.end_time + '</p>' +
                                '<p class="show-price"><span>¥' + data[i].perform.price + '/场</span><button class="del" onclick="deletes(' + data[i].perform.id + ')">删除</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function deletes(id) {
            if (confirm('确认删除吗')) {
                var url = "<?php echo base_url(); ?>User/Student/StudentDeleteCollect";
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