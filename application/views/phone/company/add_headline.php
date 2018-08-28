<?php $this->load->view('upload'); ?>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>新闻头条编辑</p>
    </div>
</div>
<div class="my-edit" >
    <div class="edit-item edit-textarea">
            <!-- <p>图    片</p><span class="max-img">（最多不超过9张）</span> -->
        <div class="add-pic">
            <img src="<?php echo base_url(); ?>assets/img/phone/liu.png">
            <div class="upload-img">
                <span class="uploadimg"><i class="iconfont icon-camera1"></i><input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=coverimg&maker=headline"></span>
            </div>
        </div>
        <div class="uploadimg-list">
            <ul id="coverimg">

            </ul>
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>标题</span>
        <input type="text" placeholder="2-30字" id="title">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            日期</span>
        <input readonly id="demo1">
    </div>

    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>标签</span>
        <input type="text" placeholder="不超过5个字" id="tag">
    </div>
    <div class="edit-item edit-textarea">
        <p><em style="color:red;">*</em>内    容</p>
        <textarea name="" id="desc" placeholder="新闻内容1-100字"></textarea>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/lCalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
            var calendardatetime = new lCalendar();
            calendardatetime.init({
                'trigger': '#demo1',
                'type': 'datetime'
            });
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
                            $('#' + resultJson[0]).append('<li>' +
                                    '<i class="iconfont icon-htmal5icon19"></i>' +
                                    '<img src="' + src + '" alt="">' +
                                    '</li>');
                        }
                    },
                    progress: function (e, data) {
                    },
                });
                $("body").on("click", ".icon-htmal5icon19", function () {
                    $(this).parent().remove();
                })
            });
            function save() {
                var coverimg = "";
                for (var i = 0; i < $('#coverimg').find('img').length; i++) {
                    if (i == 0) {
                        coverimg = $('#coverimg').find('img').eq(i).attr('src');
                    } else {
                        coverimg = coverimg + ',' + $('#coverimg').find('img').eq(i).attr('src');
                    }
                }
                var title = $('#title').val();
                var time = $('#demo1').val();
                var tag = $('#tag').val();
                var desc = $('#desc').val();
                if (coverimg != "" && title != "" && tag != "" && desc != "") {
                    var url = "InsertHeadline";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            coverimg: coverimg,
                            title: title,
                            time: time,
                            tag: tag,
                            desc: desc
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            layer.msg('保存成功！', {time: 1500}, function () {
                                window.history.go(-1);
                            })
                        }
                    });
                } else {
                    layer.msg('请填写必填项!', {time: 1500})
                }
            }
</script>