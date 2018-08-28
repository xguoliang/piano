<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>商品管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>商品管理</a>
            </li>
            <li>
                <strong>编辑商品</strong>
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
                    <label>编辑商品</label>
                </div>
<!--                <div class="ibox-tools">-->
<!--                    <a><span class="btn btn-primary" onclick="SaveOne()">保存信息</span></a>-->
<!--                </div>-->
                <div style="clear: both;"></div>
            </div>
            <div class="ibox-content">
                <div class="edit_info">
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>名称：</span>
                        <input  id="name" class="form-control left cwidth" type="text" placeholder="请填写商品名称" value="<?php if(isset($one)){echo $one['name'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>价格：</span>
                        <input  id="price" class="form-control left cwidth" type="number" value="<?php if(isset($one)){echo $one['price'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>原价：</span>
                        <input  id="show_price" class="form-control left cwidth" type="number" value="<?php if(isset($one)){echo $one['show_price'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>封面图：</span>
                        <div class="left">
                            <div class="upload pic_upload">上传图片
                                <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=coverimg&maker=product">
                            </div>
                            <div class="pic_box">
                                <span id="coverimg" class="no_pic" style="text-align: center;">
                                <?php if(isset($one)!=''){ ?>
                                    <img src="<?php echo base_url().$one['coverimg']?>">
                                <?php }else{ ?>
                                    暂无图片
                                <?php }?>
                                </span>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>图片：</span>
                        <div class="left" id="img">
                            <div class="upload pic_upload" style="display:block;">上传图片
                                <input type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img&maker=product">
                            </div>
                            <?php if(isset($one)){$img = explode(',',$one['img']);}?>
                            <?php if(isset($img)){?>
                                <?php foreach($img as $k=>$v){?>
                                    <div class="pic_box" style="position:relative;overflow:visible;">
                                        <span class="no_pic" style="text-align: center;">
                                            <img onclick="DeleteOne(this)" src="<?php echo base_url().$v;?>" style="width:100%;height:100%"/>
                                        </span>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
                        <div class="clear"></div>
                        <div style="margin:30px 0 0 75px;color:red;">注：此图片为商品图片</div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>琴行：</span>
                        <select id="com_id" style="background-color: #FFFFFF;background-image: none;border: 1px solid #e5e6e7;border-radius: 1px;color: inherit;padding: 6px 12px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;font-size: 14px;">
                            <option value="0">请选择琴行</option>
                            <?php foreach($company as $k=>$v){?>
                                <option <?php if(isset($one)){if($v['id'] == $one['com_id']){echo "selected";}}?> value="<?php echo $v['com_id']?>"><?php echo $v['name']?></option>
                            <?php }?>
                        </select>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>分类：</span>
                        <select id="cat_id" style="background-color: #FFFFFF;background-image: none;border: 1px solid #e5e6e7;border-radius: 1px;color: inherit;padding: 6px 12px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;font-size: 14px;">
                            <option value="0">请选择分类</option>
                        </select>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>品牌：</span>
                        <select id="brand_id" style="background-color: #FFFFFF;background-image: none;border: 1px solid #e5e6e7;border-radius: 1px;color: inherit;padding: 6px 12px;transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;font-size: 14px;">
                            <option value="0">请选择品牌</option>
                        </select>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>详情：</span>
                        <div class="clear"></div>
                    </div>
                    <script id="detail" type="text/plain"><?php if(isset($one)){echo $one['detail']; }?></script>
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
    var ue = UE.getEditor('detail',{
        initialFrameHeight: 300
    });
    $(function(){
        UploadImg();
        $("body").click(function(e){
            var idValue = $(e.target).attr("id");  //获取当前点击区域对象的id值
        })
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
                    if(resultJson[0] == 'img'){
                        var imgstr = '' +
                            '<div class="pic_box" style="position:relative;overflow:visible;">\n' +
                            '                                        <span class="no_pic" style="text-align: center;">\n' +
                            '                                        <img onclick="DeleteOne(this)" src="'+src+'" style="width:100%;"/>\n' +
                            '                                            暂无图片\n' +
                            '                                        </span>\n' +
                            '                                    </div>';
                        $('#' + resultJson[0]).append(imgstr);
                    }else{
                        $("#" + resultJson[0]).html('<img src="'+src+'" >')
                    }

                }
            },
            progress: function (e, data) {

            },
        });
    }
</script>