<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>场地租赁收藏</p>
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
        select_lease();
        function more(){
            pages++;
            select_lease();
        }
        function select_lease() {
            var url = "<?php echo base_url(); ?>User/Student/MyCollectSiteLease";
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
                                '<a href="<?php echo base_url(); ?>User/Lease/SiteLeaseDetail.html?id=' + data[i].entity_id + '"><img src="<?php echo base_url(); ?>' + data[i].lease.coverimg.split('|')[0] + '" alt=""></a>' +
                                '</div>' +
                                '<div class="rent-txt">' +
                                '<a href="<?php echo base_url(); ?>User/Lease/SiteLeaseDetail.html?id=' + data[i].entity_id + '"><h5 class="rent-name">' + data[i].lease.name + '</h5></a>' +
                                '<p>可租时间:' + data[i].lease.start_time + '-' + data[i].lease.end_time + '</p>' +
                                '<p>地址：' + data[i].lease.address + '</p>' +
                                '<p><span class="rent-price">¥' + data[i].lease.money + '/天</span><button class="del" onclick="deletes(' + data[i].id + ')">删除</button></p>' +
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