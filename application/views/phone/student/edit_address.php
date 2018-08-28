<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/phone/magic-check.css">
<style>
    body{font-size: 0.32rem;}
    .display {display: flex;display: -webkit-box;display: -moz-box;display: -webkit-flex;display: -ms-flexbox;}
    .conter{display:flex;align-items:center;justify-content:space-between;}
    .pos_f_btn{width:100%;position:fixed;bottom:0;background:#fba420;height:0.9rem;line-height:0.9rem;color:#fff;text-align: center;}

    /**************以上是三个页面共用的*************************/
    .mall{background:#f5f5f5!important;font-size:0.24rem!important; height: 0.8rem !important; line-height: 0.8rem !important;border: none!important;color:#999;}
    .new_add p{background:#fff;line-height:0.9rem;height:0.9rem;border-bottom:1px solid #e9e9e9;padding:0 0.25rem;font-size:0.28rem;}
    .new_add p input{ padding: 0.2rem;width: 80%;}
    .mor_top{margin-top:0.15rem;}
    .mor_top label{display: initial;}
    .add_new_left{width:18%;display: inline-block;}
</style>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save"></a>
        <p>修改收获地址</p>
    </div>
</div>
<div class="new_add my-edit">
    <p class="mall">收货人</p>
    <p><span class="add_new_left">姓名</span> <input type="text" id="name" value="<?php echo isset($detail['name']) ? $detail['name'] : ''; ?>"></p>
    <p><span class="add_new_left">联系电话</span> <input type="text" id="phone" value="<?php echo isset($detail['phone']) ? $detail['phone'] : ''; ?>"></p>
    <p class="mall">收货地址</p>
    <div data-toggle="distpicker">
        <?php
        if (isset($detail['area'])) {
            $area = explode(' ', $detail['area']);
        } else {
            $area = array('', '', '');
        }
        ?>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">省</span>
                <select class="form-control" id="province1" data-province="<?php echo $area[0]; ?>"></select>
            </div>

        </div>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">市</span>
                <select class="form-control" id="city1" data-city="<?php echo $area[1]; ?>"></select>
            </div>
        </div>
        <div class="edit-item">
            <div class="form-group">
                <span class="edit-fenlei">区</span>
                <select class="form-control" id="district1" data-district="<?php echo $area[2]; ?>"></select>
            </div>
        </div>
        <div class="edit-item">
            <span class="edit-fenlei">详细地址</span>
            <input type="text" placeholder="5-30字" id="address" value="<?php echo isset($detail['address']) ? $detail['address'] : ''; ?>">
        </div>
    </div>
    <p class="conter display mor_top">
        <span>设置为默认地址</span>
        <span><input class="magic-checkbox" type="checkbox" name="layout" id="c10" <?php
            if (isset($detail['is_default'])) {
                if ($detail['is_default'] == 1) {
                    echo 'checked="checked"';
                }
            }
            ?>><label for="c10"></label></span>
    </p>
    <?php if (isset($detail['id'])) { ?>
        <p class="mor_top" onclick="deletes(<?php echo $detail['id']; ?>)">删除该地址</p>
    <?php } ?>
</div>
<p class="pos_f_btn" onclick="save()">保存并使用</p>
<script src="<?php echo base_url(); ?>assets/js/distpicker.data.js"></script>
<script src="<?php echo base_url(); ?>assets/js/distpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
    function save() {
        var id = '<?php echo $id; ?>';
        var name = $('#name').val();
        var phone = $('#phone').val();
        var area = $('#province1').val() + ' ' + $('#city1').val() + ' ' + $('#district1').val();
        var address = $('#address').val();
        var is_default = 0;
        if ($('#c10').is(':checked') == true) {
            is_default = 1;
        }
        if (name != "" && phone != "" && area != "" && address != "") {
            var url = "SaveAddress";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    id: id,
                    name: name,
                    phone: phone,
                    area: area,
                    address: address,
                    is_default: is_default
                },
                dataType: "json",
                success: function (data, textStatus) {
                    layer.msg('保存成功!', {time: 1500}, function () {
                        window.history.go(-1);
                    });
                }
            });
        } else {
            layer.msg('请填写完整', {time: 1500});
        }
    }
    function deletes(id) {
        if (confirm('确认删除吗')) {
            var url = "DeleteAddress";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data, textStatus) {
                    layer.msg('删除成功!', {time: 1500}, function () {
                        window.history.go(-1);
                    });
                }
            });
        }
    }
</script>