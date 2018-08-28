<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <a href="PAddTeacher.html" class="save">添加</a>
        <p>老师管理</p>
    </div>
</div>
<div class="teacher-manage">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more()" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var pages = 1;
        select_teacher();
        function more() {
            pages++;
            select_teacher();
        }
        function select_teacher() {
            var url = "SelectTeacher";
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
                                '<div class="teacher-img">' +
                                '<a href="<?php echo base_url()?>User/Teacher/TeacherDetail.html?id='+data[i].id+'"><img src="<?php echo base_url(); ?>' + data[i].headimg + '" alt=""></a>' +
                                '</div>' +
                                '<div class="teacher-txt">' +
                                '<p><a href="<?php echo base_url()?>User/Teacher/TeacherDetail.html?id='+data[i].id+'" class="teacher-name">' + data[i].name + '</a><span class="teacher-dt">' + data[i].profession + '</span></p>' +
                                '<p><span class="teacher-course">现有' + data[i].count + '个课程</span><span class="teacher-years">教龄' + data[i].year + '年</span></p>' +
                                '<span class="teacher-btn"><button class="del" onclick="deletes(' + data[i].id + ')">删除</button><button class="buy" onclick="goto(' + data[i].id + ')">编辑</button></span>' +
                                '</div>' +
                                '</li>');
                    }
                }
            });
        }
        function deletes(id) {
            if (confirm("确认删除吗")) {
                var url = "DeleteTeacher";
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
        function goto(id) {
            window.location.href = "PChangeteacher.html?id=" + id;
        }
</script>