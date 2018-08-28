<div class="my good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="save" onclick="save()">完成</a>
        <p>乐队组建编辑</p>
    </div>
</div>
<div class="my-edit">
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>名称</span>
        <input type="text" placeholder="2-30字" id="name">
    </div>
    <div class="edit-item">
        <span class="edit-fenlei">
            <em>*</em>截止日期</span>
        <input readonly id="demo1">
    </div>
    <div class="edit-item edit-textarea">
        <p><em>*</em>需要成员</p>
        <textarea name="" id="need" placeholder="详情1-100字"></textarea>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lCalendar.min.js"></script>
<script>
            var calendardatetime = new lCalendar();
            calendardatetime.init({
                'trigger': '#demo1',
                'type': 'datetime'
            });
            function save() {
                var name = $('#name').val();
                var end_time = $('#demo1').val();
                var need = $('#need').val();
                if (name != "" && end_time != "" && need != "") {
                    var url = "InsertBand";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            name: name,
                            end_time: end_time,
                            need: need
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