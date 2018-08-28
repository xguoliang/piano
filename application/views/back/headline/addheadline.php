<div class="right-down">
    <div class="right-down-title display1">
        <h2>头条编辑</h2>
        <p class="display1">
            <span class="dj display1" onclick="SaveOne()">
                 <i class="display1"><img src="<?php echo base_url() ?>assets/back/img/bc.png"></i>
                 <span style="display: block;">保存</span>
            </span>
        </p>
    </div>
    <div class="bj-sp-box">
        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">标&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题：</p>
            <input type="text" id="title" value="<?php if (isset($one)) {
                echo $one['title'];
            } ?>">
            <span>0/30</span>
        </div>

        <div class="bj-sp bj-tp display1" style="height: auto">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品图片：</p>
            <div class="display1" style="flex-wrap: wrap" id="img">
                <i class="kong">
                    <img src="<?php echo base_url() ?>assets/back/img/tp.png">
                    <input multiple type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img&maker=headline&width=1&height=1">
                </i>
                <?php if(isset($one)){foreach(explode(',',$one['coverimg']) as $k => $v){?>
                    <i class="youtu" style="position:relative">
                        <img src="<?php echo base_url().$v ?>">
                        <img onclick="$(this).parent('i').remove()" src="<?php echo base_url()?>assets/back/img/del.png" style="position:absolute;top:-12px;right:-12px;width:24px;height:24px;cursor: pointer;">
                    </i>
                <?php }}?>

            </div>
        </div>


        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">标&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;签：</p>
            <input id="tag" type="text" value="<?php if (isset($one)) {
                echo $one['tag'];
            } ?>">
        </div>
        <div class="bj-sp display1" style="margin-top: 41px">
            <p>商品详情：</p>
        </div>
        <script id="desc" type="text/plain"><?php if (isset($one)) {
                echo $one['desc'];
            } ?></script>
        <div style="margin-top: 9px"></div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.all.min.js"></script>
<script>
    var ue = UE.getEditor('desc', {
        initialFrameHeight: 300
    });
    var id = '<?php if (isset($one)) {
        echo $one['id'];
    } else {
        echo '';
    }?>';
    $(function(){
        UploadImg();
    });
    //上传图片
    function UploadImg(){
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
                    var htmlStr = '' +
                        ' <i class="youtu" style="position:relative">\n' +
                        '                        <img src="'+src+'">\n' +
                        '                        <img onclick="$(this).parent(\'i\').remove()" src="<?php echo base_url()?>assets/back/img/del.png" style="position:absolute;top:-12px;right:-12px;width:24px;height:24px;cursor: pointer;">\n' +
                        '                    </i>';
                    $("#"+resultJson[0]).append(htmlStr);
                }
            },
            progress: function (e, data) {

            },
        });
    }

    function SaveOne() {
        var url = 'SaveOne';
        var save = {};
        save.title = $("#title").val();
        save.tag = $("#tag").val();
        save.desc = ue.getContent();
        save.coverimg = '';
        $("#img").find(".youtu").each(function(i,t){
            if(i == 0){
                save.coverimg += $(t).find("img").attr('src').replace("<?php echo base_url()?>","");
            }else{
                save.coverimg += ',' + $(t).find("img").attr('src').replace("<?php echo base_url()?>","");
            }
        });
        var data = {
            id: id,
            save: save
        };
        if (save.title == '' || save.tag == '' || save.desc == '' || save.coverimg == '') {
            layer.msg("信息填写不完整!", {time: 1500});
            return;
        }
        $.post(url, data, function (res) {
            layer.msg(res.msg, {time: 1500}, function () {
                window.location.href = '<?php echo base_url()?>Back/Headline/HeadlineList';
            })
        },'json')
    }
</script>
