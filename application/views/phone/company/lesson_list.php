<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" href="PAddLesson.html">发布</a>
        <p>课程管理</p>
    </div>
    <div class="search-area">
        <span class="search-filter">
            <input type="text" placeholder="吉他" id="search"><i class="iconfont icon-sousuo" onclick="searchs()"></i>
        </span>
        <span class="search-filter-btn">
            全部乐器<i class="iconfont icon-cc-down"></i>
        </span>
    </div>
</div>
<div class="activi-list cousrse-list collect-course">
    <ul id="neirong">

    </ul>
    <div onclick="more()" id="more" class="click_more">
        查看更多
    </div>
</div>
<?php $this->load->view('phone/foot', array('nav' => 4)); ?>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var search = "";
        var pages = 1;
        var instrument_id = 0;
        select_lesson();
        function more() {
            pages++;
            select_lesson();
        }
        function searchs() {
            search = $('#search').val();
            pages = 1;
            $('#neirong').empty();
            $('#more').show();
            select_lesson();
        }
        function select_lesson() {
            var url = "SelectLesson";
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
                                '<div class="activi-img">' +
                                '<img onclick="window.location.href=\'<?php echo base_url()?>User/Lesson/LessonDetail.html?id='+data[i].id+'\'" src="<?php echo base_url(); ?>' + data[i].coverimg.split(',')[0] + '">' +
                                '</div>' +
                                '<div class="activi-txt">' +
                                '<a href="<?php echo base_url()?>User/Lesson/LessonDetail.html?id='+data[i].id+'"><h5>' + data[i].name + '</h5></a>' +
                                '<p class="activi-info course-info"><em><i class="address"></i><span>' + data[i].area + '</span></em></p>' +
                                '<p class="activi-num">已报名人数：' + data[i].count + '人</p>' +
                                '<p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + data[i].price + '</span></em><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="collect buy" onclick="change_lesson(' + data[i].id + ')">编辑</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function deletes(id) {
            var url = "DeleteLesson";
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
        function change_lesson(id) {
            window.location.href = "PChangeLesson?id=" + id;
        }
</script>