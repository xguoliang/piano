<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>活动收藏</p>
    </div>
</div>
<div class="activi-list collect-activi">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        select_activity();
        function more() {
            pages++;
            select_activity();
        }
        function select_activity() {
            var url = "<?php echo base_url(); ?>User/Student/MyCollectActivity";
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
                                '<div class="activi-img">' +
                                '<a href="<?php echo base_url(); ?>User/Activity/ActivityDetail.html?id=' + data[i].entity_id + '"><img src="<?php echo base_url(); ?>' + data[i].activity.coverimg.split('|')[0] + '"></a>' +
                                '</div>' +
                                '<div class="activi-txt">' +
                                '<a href="<?php echo base_url(); ?>User/Activity/ActivityDetail.html?id=' + data[i].entity_id + '"><h5>' + data[i].activity.name + '</h5></a>' +
                                '<p class="activi-info"><em><i class="address"></i><span>' + data[i].activity.area.split(' ')[0] + '</span></em><em><i class="time"></i><span>' + data[i].activity.add_time.split(' ')[0] + '</span></em></p>' +
                                '<p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + data[i].activity.price + '</span></em><button class="del" onclick="deletes(' + data[i].id + ')">删除</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function deletes(id) {
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
</script>