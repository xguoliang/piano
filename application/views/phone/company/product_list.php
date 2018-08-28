<style>
    .good .filter-sort {
        display: none;
        background: #fff;
        padding: .2rem 0;
    }
    .good .filter-sort ul {
        padding: 0 .2rem;
        max-height: 2.5rem;
        overflow: hidden;
        overflow-y: auto;
    }
    .good .filter-sort ul li {
        font-size: 0.28rem;
        line-height: .6rem;
    }
    .good .filter-sort ul .active span {
        color: #fba41f;
    }
</style>
<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <!--<a class="save" href="PAddProduct.html">发布</a>-->
        <p>商品管理</p>
    </div>
    <div class="search-area" style="border-bottom: 1px solid #e9e9e9;margin-bottom: 0;">
        <span class="search-filter">
            <input type="text" placeholder="吉他" id="search"><i class="iconfont icon-sousuo" onclick="searchs()"></i>
        </span>
        <span class="search-filter-btn">
            全部乐器<i class="iconfont icon-cc-down"></i>
        </span>
    </div>
    <div class="filter-sort filter-info area">
        <ul>
            <li data="0" class="active">
                <span>全部乐器</span>
            </li>
            <?php for ($i = 0; $i < count($instrument); $i++) { ?>
                <li data="<?php echo $instrument[$i]['id']; ?>">
                    <span><?php echo $instrument[$i]['name']; ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="good-list">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var search = "";
        var instrument_id = 0;
        var pages = 1;
        select_product();
        $('.search-filter-btn').click(function () {
            if ($('.mask').css('display') == "none") {
                $('.mask').show();
                $('.area').show();
                $('.icon-cc-down').css('transform', 'rotate(180deg)');
            } else {
                $('.mask').hide();
                $('.area').hide();
                $('.icon-cc-down').css('transform', '');
            }
        })
        $('.cover-floor').click(function () {
            $('.mask').hide();
            $('.area').hide();
            $('.icon-cc-down').css('transform', '');
        });
        $('.area').find('li').click(function () {
            $('.area').find('li').removeClass('active');
            $(this).addClass('active');
            $('.mask').hide();
            $('.area').hide();
            $('.icon-cc-down').css('transform', '');
            instrument_id = $(this).attr('data');
            pages = 1;
            $('#neirong').empty();
            select_product();
        })
        function searchs() {
            search = $('#search').val();
            pages = 1;
            $('#neirong').empty();
            select_product();
        }
        function more() {
            pages++;
            select_product();
        }
        function select_product() {
            var url = "SelectProduct";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    search: search,
                    instrument_id: instrument_id,
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
                                '<a href="<?php echo base_url() ?>User/Product/PProductDetail.html?type=2&id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split(',')[0] + '" alt=""></a>' +
                                '</div>' +
                                '<div class="good-txt">' +
                                '<a><p class="good-name" onclick="window.location.href=\'<?php echo base_url() ?>User/Product/PProductDetail.html?type=2&id=' + data[i].id + '\'">' + data[i].name + '</p></a>' +
                                '<p class="good-price"><em class="good-price1"><span class="price-icon">¥</span><span class="price-num">' + data[i].price + '</span></em><button class="del" onclick="deletes(' + data[i].id + ')">删除</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeleteProduct";
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