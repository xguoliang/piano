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
            <em>*</em>昵称</span>
        <input type="text" placeholder="2-30字" maxlength="30" id="name" value="<?php echo $detail['name']; ?>">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>电话</span>
        <input type="number" id="phone" value="<?php echo $detail['phone']; ?>">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em></em>性别
        </span>
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
    <div data-toggle="distpicker">
        <?php $area = explode(' ', $detail['area']); ?>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">省</span>
                <select class="form-control" id="province1" data-province="<?php echo $area[0]; ?>"></select>
            </div>

        </div>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">市</span>
                <select class="form-control" id="city1" data-city="<?php
                if (isset($area[1])) {
                    echo $area[1];
                }
                ?>"></select>
            </div>

        </div>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">区</span>
                <select class="form-control" id="district1" data-district="<?php
                if (isset($area[2])) {
                    echo $area[2];
                }
                ?>"></select>
            </div>
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">详细地址</span>
        <input type="text" placeholder="5-30字" id="address" value="<?php $detail['address']; ?>">
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
                var phone = $('#phone').val();
                var name = $('#name').val();
                var sex = $('#sex option:selected').val();
                var area = $('#province1').val() + " " + $('#city1').val() + " " + $('#district1').val();
                var address = $('#address').val();
                if (headimg != "" && name != "" && phone != "") {
                    var url = "UpdateStudent";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            headimg: headimg,
                            name: name,
                            phone: phone,
                            sex: sex,
                            area: area,
                            address: address
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            layer.msg('保存成功！',{time:1500},function(){
                                window.history.go(-1);

                            })
                        }
                    });
                } else {
                    layer.msg('请填写必填项！',{time:1500})

                }
            }
</script>