<?php $this->load->view('upload'); ?>
<style>
    body{
        padding-top: 1.2rem;
    }
    .my-edit .edit-item img {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>信息编辑</p>
    </div>
</div>
<div class="my-edit">
    <div class="edit-item">
        <span class="edit-fenlei ">
            <em>*</em>头像</span>
        <div style="width:1.2rem;height:1.2rem;float:right;border-radius: 100%;position:relative;">
            <img src="<?php echo base_url() . $detail['headimg']; ?>" alt="" id="headimg">
            <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=headimg&maker=user" style="position:absolute;opacity: 0;width: 100%;height:100%;top:0;left:0;">
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" placeholder="2-30字" id="name" value="<?php echo $detail['name']; ?>">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>电话</span>
        <input type="number" id="phone" value="<?php echo $detail['phone']; ?>">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>性别</span>
        <select id="sex">
            <option value="1" <?php
            if ($detail['sex'] == 1) {
                echo 'selected="selected"';
            }
            ?>>男</option>
            <option value="2" <?php
            if ($detail['sex'] == 2) {
                echo 'selected="selected"';
            }
            ?>>女</option>
        </select>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>擅长乐器</span>
        <select name="" id="instrument">
            <?php foreach ($instrument as $data_item): ?>
                <option value="<?php echo $data_item['id']; ?>" <?php
                if ($data_item['id'] == $detail['instrument_id']) {
                    echo 'selected="selected"';
                }
                ?>><?php echo $data_item['name']; ?></option>
                    <?php endforeach; ?>
        </select>
    </div>
    <div class="edit-item edit-textarea">
        <p><em style="color:red;">*</em>简    介</p>
        <textarea name="" id="desc" placeholder="乐手详情介绍1-100字"><?php echo $detail['desc']; ?></textarea>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.js"></script>
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
            });
            function save() {
                var headimg = $('#headimg').attr('src');
                var name = $('#name').val();
                var phone = $('#phone').val();
                var sex = $('#sex option:selected').val();
                var instrument_id = $('#instrument option:selected').val();
                var desc = $('#desc').val();
                if (headimg != "" && name != "" && phone != "" && instrument_id != 0 && desc != "") {
                    var url = "UpdateBandsman";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            headimg: headimg,
                            name: name,
                            phone: phone,
                            sex: sex,
                            instrument_id: instrument_id,
                            desc: desc
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            layer.msg('保存成功！', {time: 1500}, function () {
                                window.history.go(-1);

                            })
                        }
                    })
                } else {
                    layer.msg('请填写必填项！', {time: 1500})

                }
            }
</script>