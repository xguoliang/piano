<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>推送管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>推送管理</a>
            </li>
            <li>
                <strong>编辑推送</strong>
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
                    <label>编辑推送</label>
                </div>
                <div class="ibox-tools">
                    <a><span class="btn btn-primary" onclick="SaveOne()">保存信息</span></a>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="ibox-content">
                <div class="edit_info">
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>标题：</span>
                        <input id="title" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['title'];}?>">
                        <div class="clear"></div>
                    </div>

                    <div class="form-group">
                        <span class="left">排序：</span>
                        <input id="sort" class="form-control left cwidth" type="number" value="<?php if(isset($one)){echo $one['sort'];}?>">
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

    //
    function SaveOne(){
        var url = "SaveOne";
        var save = {};
        save.sort = $("#sort").val();
        if(save.sort == ''){
            save.sort = 99;
        }
        save.link = $("#link").val();
        save.title = $("#title").val();
        if(save.title == '' || save.link == ''){
            layer.msg('信息填写不完整！',{time:1500});
            return;
        }
        var data = {
            id: id,
            save: save
        };
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg("保存成功!",{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>Admin/Push/PushList";
                })
            }else{
                layer.msg('登录失效，请重新登录后操作!',{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>Admin/Login/Login";
                })
            }
        },'json')
    }
</script>