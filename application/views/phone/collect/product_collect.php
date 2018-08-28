<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>商品收藏</p>
    </div>
</div>
<div class="good-list">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        select_collect();
        function more() {
            pages++;
            select_collect();
        }
        function select_collect() {
            var url = "<?php echo base_url(); ?>User/Student/MyCollectProduct";
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
                                '<div class="good-img">' +
                                '<a href="<?php echo base_url(); ?>User/Product/PProductDetail.html?id=' + data[i].entity_id + '"><img src="<?php echo base_url(); ?>' + data[i].product.coverimg.split(',')[0] + '" alt=""></a>' +
                                '</div>' +
                                '<div class="good-txt">' +
                                '<a href="<?php echo base_url(); ?>User/Product/PProductDetail.html?id=' + data[i].entity_id + '"><p class="good-name">' + data[i].product.name + '</p></a>' +
                                '<a href="store-page.html"><p class="shop-name">' + data[i].product.com_name + '</p></a>' +
                                '<p class="good-dt"><span class="good-add">' + data[i].product.area.split(' ')[2] + '</span><span class="good-fenlei">' + data[i].product.instrument_name + '</span></p>' +
                                '<p class="good-price"><em class="good-price1"><span class="price-icon">¥</span><span class="price-num">' + data[i].product.price + '</span></em><button class="del" onclick="deletes(' + data[i].id + ')">删除</button></p>' +
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