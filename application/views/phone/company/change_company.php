<?php $this->load->view('upload'); ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=oG3ojtavdO9jFiuUoz2HhHv7V7MaLTDi"></script>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>信息编辑</p>
    </div>
</div>
<div class="my-edit" data-toggle="distpicker">
    <div class="edit-item">
        <span class="edit-fenlei ">
            <em>*</em>头像</span>
        <div style="width:1.2rem;height:1.2rem;float:right;border-radius: 100%;position:relative;">
            <img src="<?php echo base_url() . $detail['headimg']; ?>" alt="" id="headimg">
            <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=headimg&maker=user" style="position:absolute;opacity: 0;width: 100%;height:100%;top:0;left:0;" onclick="change_type(1)">
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" id="name" placeholder="2-30字" value="<?php echo $detail['name']; ?>">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>电话</span>
        <input type="number" id="phone" value="<?php echo $detail['phone']; ?>">
    </div>
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
    <div class="edit-item">
        <span class="edit-fenlei"><em>*</em>详细地址</span>
        <input type="text" id="address" placeholder="5-30字" value="<?php echo $detail['address']; ?>">
    </div>
    <div class="edit-item edit-textarea">
        <p><em style="color:red;">*</em>简    介</p>
        <textarea name="" id="desc" placeholder="琴行详情介绍1-100字"><?php echo $detail['desc']; ?></textarea>
    </div>
    <div class="edit-item edit-textarea">
        <p>图    片</p><span class="max-img">（最多不超过9张）</span>
        <div class="add-pic">
            <img src="<?php echo base_url(); ?>assets/img/phone/liu.png">
            <div class="upload-img">
                <span class="uploadimg"><i class="iconfont icon-camera1"></i><input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img&maker=coverimg" style="position:absolute;opacity: 0;width: 100%;height:100%;top:0;left:0;" onclick="change_type(2)"></span>
            </div>
        </div>
        <div class="uploadimg-list">
            <ul id="img">
                <?php
                $img = explode(',', $detail['img']);
                for ($i = 0; $i < count($img); $i++) {
                    if ($img[$i] != "") {
                        ?>
                        <li>
                            <i class="iconfont icon-htmal5icon19"></i>
                            <img src="<?php echo base_url() . $img[$i]; ?>" alt="">
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.js"></script>
<script>
                    var upload_type = 0;
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
                                    if (upload_type == 1) {
                                        $('#' + resultJson[0]).attr('src', src);
                                    } else {
                                        $('#' + resultJson[0]).append('<li>' +
                                                '<i class="iconfont icon-htmal5icon19"></i>' +
                                                '<img src="' + src + '" alt="">' +
                                                '</li>');
                                    }
                                }
                            },
                            progress: function (e, data) {
                            },
                        });
                    });
//                    $('.icon-htmal5icon19').click(function(){
//                        $(this).parent().remove();
//                    })
                    $("body").on("click", ".icon-htmal5icon19", function () {
                        $(this).parent().remove();
                    })
                    function change_type(type) {
                        upload_type = type;
                    }
                    function save() {
                        var headimg = $('#headimg').attr('src');
                        var name = $('#name').val();
                        var phone = $('#phone').val();
                        var area = $('#province1').val() + " " + $('#city1').val() + " " + $('#district1').val();
                        var address = $('#address').val();
                        var desc = $('#desc').val();
                        var img = "";
                        for (var i = 0; i < $('#img').find('img').length; i++) {
                            if (i == 0) {
                                img = $('#img').find('img').eq(i).attr('src');
                            } else {
                                img = img + "," + $('#img').find('img').eq(i).attr('src');
                            }
                        }
                        var lng = "";
                        var lat = "";
                        var myGeo = new BMap.Geocoder();
                        myGeo.getPoint(address, function (point) {
                            if (point) {
                                lng = point.lng;
                                lat = point.lat;
                                if (headimg != "" && name != "" && phone != "" && address != "" && desc != "") {
                                    var url = "UpdateCompany";
                                    $.ajax({
                                        type: "post",
                                        url: url,
                                        data: {
                                            headimg: headimg,
                                            name: name,
                                            phone: phone,
                                            area: area,
                                            address: address,
                                            desc: desc,
                                            img: img,
                                            lng: lng,
                                            lat: lat
                                        },
                                        dataType: "json",
                                        success: function (data, textStatus) {
                                            layer.msg('保存成功!', {time: 1500}, function () {
                                                window.history.go(-1)
                                            })
                                        }
                                    });
                                } else {
                                    layer.msg('请填写必填项!', {time: 1500})

                                }
                            } else {
                                layer.msg('您选择地址没有解析到结果!', {time: 1500})

                            }
                        }, "北京市");
                    }
</script>