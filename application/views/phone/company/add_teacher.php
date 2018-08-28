<?php $this->load->view('upload'); ?>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">添加</a>
        <p>添加老师</p>
    </div>
</div>
<div class="my-edit">
    <div class="edit-item">
        <span class="edit-fenlei ">
            <em>*</em>头像</span>
        <div style="width:1.2rem;height:1.2rem;float:right;border-radius: 100%;position:relative;">
            <img src="<?php echo base_url(); ?>assets/img/phone/expert.png" alt="" id="headimg">
            <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=headimg&maker=user" style="position:absolute;opacity: 0;width: 100%;height:100%;top:0;left:0;">
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" placeholder="2-30字" id="name">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            专业</span>
        <input type="text" placeholder="吉他" id="profession">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            教龄</span>
        <input type="text" placeholder="10年" id="year">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>课程</span>
    </div>
    <div class="edit-item" >
        <ul class="choose-course">
            <?php foreach ($lesson as $data_item): ?>
                <li><i class="iconfont icon-checkboxround0" data="<?php echo $data_item['id']; ?>"></i><span><?php echo $data_item['name']; ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="edit-item edit-textarea">
        <p>简    介</p>
        <textarea name="" id="desc" placeholder="琴行详情介绍1-100字"></textarea>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/distpicker.data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
            $(function () {
                $("input[type=file]").fileupload({
                    done: function (e, result) {
                        var resultJson = $.parseJSON(result.result);
                        if (resultJson == 1) {
                            alert('上传失败');
                        } else if (resultJson == 2) {
                            alert('文件类型错误');
                        } else if (resultJson == 3) {
                            alert('文件太大');
                        } else {
                            var a = resultJson[1].split('.');
                            var src = '<?php echo base_url(); ?>' + a[1] + '.' + a[2];
                            $('#' + resultJson[0]).attr('src', src);
                        }
                    },
                    progress: function (e, data) {
                    },
                });
                $(".choose-course").find('i').click(function () {
                    if ($(this).hasClass('icon-checkboxround0') == true) {
                        $(this).removeClass('icon-checkboxround0');
                        $(this).addClass('icon-checkboxround1');
                    } else {
                        $(this).removeClass('icon-checkboxround1');
                        $(this).addClass('icon-checkboxround0');
                    }
                })
            });
            function save() {
                var headimg = $('#headimg').attr('src');
                var name = $('#name').val();
                var profession = $('#profession').val();
                var year = $('#year').val();
                var desc = $('#desc').val();
                var lesson_id = "";
                for (var i = 0; i < $('.choose-course').find('.icon-checkboxround1').length; i++) {
                    if (i == 0) {
                        lesson_id = $('.choose-course').find('.icon-checkboxround1').eq(i).attr('data');
                    } else {
                        lesson_id = lesson_id + '|' + $('.choose-course').find('.icon-checkboxround1').eq(i).attr('data');
                    }
                }
                var works = "";
                if (headimg != "" && name != "" && lesson_id != "") {
                    var url = "InsertTeacher";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            headimg: headimg,
                            name: name,
                            profession: profession,
                            year: year,
                            desc: desc,
                            lesson_id: lesson_id,
                            works: works
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            layer.msg('保存成功！',{time:1500},function(){
                                window.history.go(-1);
                            })
                        }
                    });
                } else {
                    layer.msg('请填写必填项!',{time:1500})
                }
            }
</script>