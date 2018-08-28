<?php $this->load->view('upload'); ?>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>作品编辑</p>
    </div>
</div>
<div class="my-edit">
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" id="name">
    </div>
    <div class="upload-media">
        <i class="iconfont icon-yinle"></i><span id="url">上传音频</span>
        <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadMovie?id=url&maker=works">
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
                            $('#' + resultJson[0]).text(src);
                        }
                    },
                    progress: function (e, data) {
                    },
                });
            });
            function save() {
                var name = $('#name').val();
                var url = $('#url').text();
                if (name != "" && url != "上传音频") {
                    var urls = "InsertWorks";
                    $.ajax({
                        type: "post",
                        url: urls,
                        data: {
                            name: name,
                            url: url
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            layer.msg('添加成功！',{time:1500},function(){
                                window.history.go(-1);

                            })
                        }
                    });
                } else {
                    layer.msg('请填写必填项！',{time:1500})

                }
            }
</script>