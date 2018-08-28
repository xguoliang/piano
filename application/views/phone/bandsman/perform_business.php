<?php $this->load->view('upload'); ?>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>演出买卖编辑</p>
    </div>
</div>
<div class="my-edit" >
    <div class="edit-item edit-textarea">
            <!-- <p>图    片</p><span class="max-img">（最多不超过9张）</span> -->
        <div class="add-pic">
            <img src="<?php echo base_url(); ?>assets/img/phone/liu.png">
            <div class="upload-img">
                <span class="uploadimg"><i class="iconfont icon-camera1"></i><input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=coverimg&maker=activity"></span>
            </div>
        </div>
        <div class="uploadimg-list">
            <ul id="coverimg">
                <?php
                $coverimg = explode('|', $detail['coverimg']);
                for ($i = 0; $i < count($coverimg); $i++) {
                    if ($coverimg[$i] != "") {
                        ?>
                        <li>
                            <i class="iconfont icon-htmal5icon19"></i>
                            <img src="<?php echo base_url() . $coverimg[$i]; ?>" alt="">
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" id="name" value="<?php echo $detail['name']; ?>" placeholder="2-30字">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>出场费</span>
        <input type="text" placeholder="例：1000元 / 次" id="price" value="<?php echo $detail['price']; ?>">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            类别</span>
        <select name="" id="type">
            <option value="1" <?php
            if ($detail['type'] == 1) {
                echo 'selected="selected"';
            }
            ?>>类别一</option>
            <option value="2" <?php
            if ($detail['type'] == 2) {
                echo 'selected="selected"';
            }
            ?>>类别二</option>
        </select>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>电话</span>
        <input type="number" id="phone" value="<?php echo $detail['phone']; ?>">
    </div>
    <div class="edit-item edit-textarea">
        <p>详    情</p>
        <textarea name="" id="desc" placeholder="请输入详情"><?php echo $detail['desc']; ?></textarea>
    </div>

</div>
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
                        coverimg = coverimg + '|' + $('#coverimg').find('img').eq(i).attr('src');
                    }
                }
                var name = $('#name').val();
                var price = $('#price').val();
                var type = $('#type option:selected').val();
                var phone = $('#phone').val();
                var desc = $('#desc').val();
                if (coverimg != "" && name != "" && price != "" && phone != "") {
                    var url = "SaveBusiness";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            coverimg: coverimg,
                            name: name,
                            price: price,
                            type: type,
                            phone: phone,
                            desc: desc
                        },
                        dataType: "json",
                        success: function (data, textStatus) {
                            layer.msg('保存成功!',{time:1500},function(){
                                window.history.go(-1)
                            })
                        }
                    });
                } else {
                    layer.msg('请填写必填项!',{time:1500})

                }
            }
</script>