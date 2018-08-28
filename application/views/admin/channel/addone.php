<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>频道管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>频道管理</a>
            </li>
            <li>
                <strong>编辑频道</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="row rowtop" style="margin-top: 180px;">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="input-group" style="float: left;width: 40%;margin-top: 8px;">
                    <label>编辑频道</label>
                </div>
                <div class="ibox-tools">
                    <a><span class="btn btn-primary" onclick="SaveOne()">保存信息</span></a>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="ibox-content">
                <div class="edit_info">
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>名称：</span>
                        <input id="name" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['name'];}?>">
                        <div class="clear"></div>
                    </div>

                    <div class="form-group">
                        <span class="left"><span class="required">*</span>图片：</span>
                        <div class="left">
                            <div class="upload pic_upload">上传图片
                                <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img&maker=channel">
                            </div>
                            <div class="pic_box">
                                <span id="img" class="no_pic" style="text-align: center;">
                                <?php if(isset($one)!=''){ ?>
                                    <img src="<?php echo base_url().$one['img']?>">
                                <?php }else{ ?>
                                    暂无图片
                                <?php }?>
                                </span>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">排序：</span>
                        <input id="sort" class="form-control left cwidth" type="number" value="<?php if(isset($one)){echo $one['sort'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">简介：</span>
                        <input id="desc" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['desc'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>链接：</span>
                        <input id="link" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['link'];}?>">
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.all.min.js"></script>
<script>
    //修改资讯的id
    var id = "<?php if(isset($one)){echo $one['id'];}else{echo '';}?>";

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
                    $("#" + resultJson[0]).html('<img src="'+src+'" >')
                }
            },
            progress: function (e, data) {

            },
        });
    }

    //
    function SaveOne(){
        var url = "SaveOne";
        var save = {};
        save.name = $("#name").val();
        save.link = $("#link").val();
        if(save.name == ''){
            layer.msg('名称不可为空！',{time:1500});
            return;
        }
        if(save.link == ''){
            layer.msg('链接不可为空！',{time:1500});
            return;
        }
        save.sort = $("#sort").val();
        if(save.sort == ''){
            save.sort = 99;
        }
        save.desc = $("#desc").val();

        if($("#img").find("img").length > 0){
            save.img = $("#img").find("img").attr('src').replace("<?php echo base_url()?>","");
        }else{
            layer.msg('请上传图片',{time:1500});
            return;
        }
        var data = {
            id: id,
            save: save
        }
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg("保存成功!",{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>Admin/Channel/ChannelList";
                })
            }else{
                layer.msg('登录失效，请重新登录后操作!',{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>Admin/Login/Login";
                })
            }
        },'json')
    }
</script>