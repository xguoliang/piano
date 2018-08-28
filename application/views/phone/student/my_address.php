<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/phone/magic-check.css">
<style>
    body{
        font-size: 0.32rem;
    }
    .display {display: flex;display: -webkit-box;display: -moz-box;display: -webkit-flex;display: -ms-flexbox;}
    .conter{display:flex;align-items:center;justify-content:space-between;}
    .pos_f_btn{width:100%;position:fixed;bottom:0;background:#fba420;height:0.9rem;line-height:0.9rem;color:#fff;text-align: center;}

    /**************以上是三个页面共用的*************************/
    .add_box{margin-top:0.2rem;padding-bottom:1rem;}
    .add_box>div{background:#fff;margin-bottom:0.1rem;}
    .add_box>div p{padding:0 0.25rem;}
    .add_t{font-size:0.28rem;}
    .add_box>div p span{font-size:0.26rem;}
    .add_box>div p span>span{color:#444;}
    .add_box>div p span i{font-size:0.36rem;color:#999;padding:0 0.1rem;}
    .add_box>div p:nth-child(1){padding:0.3rem 0.25rem;}
    .add_box>div p:nth-child(2){font-size:0.26rem;padding-bottom:0.26rem;border-bottom:1px solid #e9e9e9;}
    .add_box>div p:nth-child(3){padding:0.1rem 0.25rem;}
    label{font-size:0.26rem;}
    /********************************/
    .label_actiyity{color:#fba420;}
    /************点击input label挂的类***************/
    .add_box .icon-checkboxround1{
        color: #fba41f;
    }
</style>
<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save"></a>
        <p>收货地址</p>
    </div>
</div>
<div class="add_box">
    <?php foreach ($address as $data_item): ?>
        <div>
            <p class="conter display"><span><?php echo $data_item['name']; ?></span> <span class="add_t"><?php echo $data_item['phone']; ?></span></p>
            <p><?php echo $data_item['address']; ?></p>
            <p class="display conter">
                <span><i class="iconfont <?php if ($data_item['is_default'] == 0) { ?>icon-checkboxround0<?php } else { ?>icon-checkboxround1<?php } ?>" data="<?php echo $data_item['id']; ?>"></i><label for="c<?php echo $data_item['id']; ?>">默认地址</label></span>
                <span>
                    <span onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Student/EditAddress.html?id=<?php echo $data_item['id']; ?>';"><i class="iconfont">&#xe68d;</i>编辑</span>
                    <span onclick="deletes(<?php echo $data_item['id']; ?>)"><i class="iconfont">&#xe66a;</i>删除</span>
                </span>
            </p>
        </div>
    <?php endforeach; ?>
</div>
<p class="pos_f_btn" onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Student/EditAddress.html'">新增地址</p>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
    $(".add_box").find('i').click(function () {
        if ($(this).hasClass('icon-checkboxround0') == true) {
            for (var i = 0; i < $(".add_box").find('i').length; i++) {
                if ($(".add_box").find('i').eq(i).hasClass('icon-checkboxround1') == true) {
                    $(".add_box").find('i').eq(i).removeClass('icon-checkboxround1');
                    $(".add_box").find('i').eq(i).addClass('icon-checkboxround0');
                }
            }
            $(this).removeClass('icon-checkboxround0');
            $(this).addClass('icon-checkboxround1');
        } else {
            $(this).removeClass('icon-checkboxround1');
            $(this).addClass('icon-checkboxround0');
        }
        var id = $(this).attr('data');
        var is_default = 0;
        if ($(this).hasClass('icon-checkboxround1') == true) {
            is_default = 1;
        }
        var url = "ChangeDefault";
        $.ajax({
            type: "post",
            url: url,
            data: {
                id: id,
                is_default: is_default
            },
            dataType: "json",
            success: function (data, textStatus) {

            }
        });
    })
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
                    window.location.reload();
                }
            });
        }
    }
</script>