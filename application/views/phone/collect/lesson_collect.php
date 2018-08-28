<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>课程收藏</p>
    </div>
</div>
<div class="activi-list cousrse-list collect-course">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        select_lesson();
        function more() {
            pages++;
            select_lesson();
        }
        function select_lesson() {
            var url = '<?php echo base_url(); ?>User/Student/MyCollectLesson';
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
                                '<a href="<?php echo base_url(); ?>User/Lesson/LessonDetail.html?id=' + data[i].entity_id + '"><img src="<?php echo base_url(); ?>' + data[i].lesson.coverimg.split(',')[0] + '"></a>' +
                                '</div>' +
                                '<div class="activi-txt">' +
                                '<a href="<?php echo base_url(); ?>User/Lesson/LessonDetail.html?id=' + data[i].entity_id + '"><h5>' + data[i].lesson.name + '</h5></a>' +
                                '<p class="activi-info"><em><i class="address"></i><span>' + data[i].lesson.area.split(' ')[2] + '</span></em></p>' +
                                '<p class="activi-btn"><em class="activi-price"><span class="price-icon">¥</span><span class="price-num">' + data[i].lesson.price + '</span></em><button class="del" onclick="deletes(' + data[i].id + ')">删除</button></p>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
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