<?php $this->load->view('upload'); ?>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>设备租赁</p>
    </div>
</div>
<div class="my-edit" >
    <div class="edit-item edit-textarea">
            <!-- <p>图    片</p><span class="max-img">（最多不超过9张）</span> -->
        <div class="add-pic">
            <img src="<?php echo base_url(); ?>assets/img/phone/liu.png">
            <div class="upload-img">
                <span class="uploadimg"><i class="iconfont icon-camera1"></i><input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=coverimg&maker=lease"></span>
            </div>
        </div>
        <div class="uploadimg-list">
            <ul id="coverimg">

            </ul>
        </div>
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" placeholder="2-30字" id="name">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>开始时间</span>
        <input readonly id="demo1">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>结束时间</span>
        <input readonly id="demo2">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>租金</span>
        <input type="text" id="money">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>电话</span>
        <input type="number" id="phone">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">乐器</span>
        <select id="instrument">
            <?php foreach ($instrument as $data_item): ?>
                <option value="<?php echo $data_item['id']; ?>"><?php echo $data_item['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div data-toggle="distpicker">
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">省</span>
                <select class="form-control" id="province1"></select>
            </div>

        </div>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">市</span>
                <select class="form-control" id="city1"></select>
            </div>

        </div>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">区</span>
                <select class="form-control" id="district1"></select>
            </div>
        </div>
        <div class="edit-item">
            <span class="edit-fenlei">详细地址</span>
            <input type="text" placeholder="5-30字" id="address">
        </div>
    </div>

    <div class="edit-item edit-textarea">
        <p>详    情</p>
        <textarea name="" id="desc" placeholder="琴行详情介绍1-100字"></textarea>
    </div>

</div>
<script src="<?php echo base_url(); ?>assets/js/distpicker.data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lCalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
            var calendardatetime = new lCalendar();
            calendardatetime.init({
                'trigger': '#demo2',
                'type': 'datetime'
            });
            var calendardatetimes = new lCalendar();
            calendardatetimes.init({
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
                        coverimg = coverimg + "|" + $('#coverimg').find('img').eq(i).attr('src');
                    }
                }
                var name = $('#name').val();
                var start_time = $('#demo1').val();
                var end_time = $('#demo2').val();
                var money = $('#money').val();
                var phone = $('#phone').val();
                var instrument_id = $('#instrument option:selected').val();
                var area = $('#province1').val() + ' ' + $('#city1').val() + ' ' + $('#district1').val();
                var address = $('#address').val();
                var desc = $('#desc').val();
                if (coverimg != "" && name != "" && start_time != "" && end_time != "" && money != "" && phone != "" && area != "" && address != "") {
                    var url = "InsertLease";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            coverimg: coverimg,
                            name: name,
                            start_time: start_time,
                            end_time: end_time,
                            money: money,
                            phone: phone,
                            instrument_id: instrument_id,
                            area: area,
                            address: address,
                            desc: desc
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