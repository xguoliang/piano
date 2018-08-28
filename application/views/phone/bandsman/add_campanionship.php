<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>陪伴练习编辑</p>
    </div>
</div>
<div class="my-edit" data-toggle="distpicker">
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>标题</span>
        <input type="text" placeholder="2-30字" id="name">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>陪练时间</span>
        <input type="text" placeholder="例：每周四下午14:00-16:00" id="companionship_time">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>电话</span>
        <input type="number" id="phone">
    </div>
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
    <div class="edit-item edit-textarea">
        <p>详    情</p>
        <textarea name="" id="desc" placeholder="详情介绍1-100字"></textarea>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/distpicker.data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script> 
<script>
            function save() {
                var name = $('#name').val();
                var companionship_time = $('#companionship_time').val();
                var phone = $('#phone').val();
                var area = $('#province1').val() + ' ' + $('#city1').val() + ' ' + $('#district1').val();
                var address = $('#address').val();
                var desc = $('#desc').val();
                if (name != "" && companionship_time != "" && phone != "" && area != "") {
                    var url = "InsertCampanionship";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            name: name,
                            companionship_time: companionship_time,
                            phone: phone,
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