<div class="good">
    <div class="inside-title">
        <i class="back"></i>
        <p>消息</p>
    </div>
</div>
<div class="message-list">
    <ul id="neirong">

    </ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
    var pages = 1;
    $(function(){
        select_message()
    })
    function select_message() {
        var url = "SelectMessage";
        $.ajax({
            type: "post",
            url: url,
            data: {
                pagesize: 10,
                pages: pages
            },
            dataType: "json",
            success: function (data, textStatus) {
                for (var i = 0; i < data.length; i++) {
                    $('#neirong').append('<li>' +
                            '<a href="MessageDetail.html?id=' + data[i].id + '">' + data[i].title + '</a>' +
                            '<p id="caozuo_' + data[i].id + '"><span>' + data[i].add_time.split(' ')[0] + '</span><button class="del">删除</button></p>' +
                            '</li>');
                    if (data[i].is_read == 0) {
                        $('#caozuo_' + data[i].id).append('<button class="buy" onclick="ReadMessage('+data[i].id+',this)">未读</button>');
                    } else {
                        $('#caozuo_' + data[i].id).append('<button class="del">已读</button>');
                    }
                }
            }
        });
    }

    function ReadMessage(id,th){
        var url = "ReadMessage";
        var data ={
            id:id,
            save:{
                is_read:1
            }
        }
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg("保存成功！",{time:1500},function(){
                    $(th).removeClass("buy").addClass("del").text("已读");
                    $(th).removeAttr("onclick");
                })
            }else{
                layer.msg('登录失效，请重新登录后操作！',{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>User/Login/Login";
                })
            }
        },'json')
    }
</script>