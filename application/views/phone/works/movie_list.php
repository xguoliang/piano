<style>
    .tel{
        position: absolute;
        top: 0.2rem;
        right: 0.2rem;
        width: .52rem;
        height: .52rem;
        background: url(../../assets/img/phone/rent-tel.png) no-repeat;
        background-size: 100% 100%;
    }
</style>
<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>影音制作</p>
    </div>
</div>
<div class="rent-list video-list collect-video">
    <ul id="neirong">

    </ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url(); ?>assets/js/xue_more.js"></script>
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
                for (var i = 0; i < data.length; i++) {
                    $('#neirong').append('<li>' +
                            '<div class="rent-img">' +
                            '<a href="MovieDetail.html?id=' + data[i].id + '"><img src="<?php echo base_url(); ?>' + data[i].coverimg.split('|')[0] + '" alt=""></a>' +
                            '</div>' +
                            '<div class="rent-txt" style="width:3.83rem;overflow:hidden;">' +
                            '<a href="MovieDetail.html?id=' + data[i].id + '"><h5 class="rent-name">' + data[i].name + '</h5></a>' +
                            '<p><span class="rent-price">¥' + data[i].price + '/天</span></p>' +
                            '</div>' +
                            '<a href="tel:' + data[i].phone + '"><i class="tel"></i></a>' +
                            '</li>');
                }
            }
        });
    }
</script>