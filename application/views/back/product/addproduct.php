<div class="right-down">
    <div class="right-down-title display1">
        <h2>商品编辑</h2>
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
            <p style="padding-left: 0">商品名称：</p>
            <input id="name" type="text" value="<?php if(isset($one)){echo $one['name'];}?>">
            <span>0/30</span>
        </div>
        <div class="bj-sp display1" style="margin-bottom: 17px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品品牌：</p>
            <select id="brand_id">
                <option value="0">请选择商品品牌</option>
                <?php foreach($brand as $k=>$v){?>
                    <option <?php if(isset($one)){if($one['brand_id'] == $v['id']){echo "selected";}}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select>
        </div>
        <div class="bj-sp display1" style="margin-bottom: 25px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品类别：</p>
            <select id="instrument_id">
                <option value="0">请选择商品类别</option>
                <?php foreach($instrument as $k=>$v){?>
                    <option <?php if(isset($one)){if($one['instrument_id'] == $v['id']){echo "selected";}}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select>
        </div>

        <div class="bj-sp-cs display1" style="margin-bottom: 22px">
            <p>商品参数：</p>
            <div class="sp-cs">
                <ul class="display1" id="parameter_list">
                    <?php if(isset($one)){?>
                        <?php $parameters = explode('@!',$one['parameters'])?>
                        <?php foreach($parameters as $k=>$v){?>
                            <?php $key = explode("@:",$v)[0];$value = explode("@:",$v)[1]?>
                            <li>
                                <p>
                                    <input style="width:48px;padding-left: 2px" type="text" value="<?php echo $key?>">
                                </p>
                                <span style="margin-left:12px;">：</span>
                                <input type="text" value="<?php echo $value?>">
                                <img style="margin-left:5px;cursor: pointer" src="<?php echo base_url()?>assets/back/img/del.png" onclick="$(this).parents('li').remove()">
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
                <div><span style="cursor:pointer" onclick="AddParameter()">添加参数</span></div>
            </div>
        </div>

        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品价格：</p>
            <input id="price" type="number" value="<?php if(isset($one)){echo $one['price'];}?>">
        </div>
        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品原价：</p>
            <input id="show_price" type="number" value="<?php if(isset($one)){echo $one['show_price'];}?>">
        </div>
        <div class="bj-sp bj-tp display1" style="height: auto">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品图片：</p>
            <div class="display1" style="flex-wrap: wrap" id="img">
                <i class="kong">
                    <img src="<?php echo base_url() ?>assets/back/img/tp.png">
                    <input multiple type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img&maker=product&width=1&height=1">
                </i>
                <?php if(isset($one)){foreach(explode(',',$one['img']) as $k => $v){?>
                    <i class="youtu" style="position:relative">
                        <img src="<?php echo base_url().$v ?>">
                        <img onclick="$(this).parent('i').remove()" src="<?php echo base_url()?>assets/back/img/del.png" style="position:absolute;top:-12px;right:-12px;width:24px;height:24px;cursor: pointer;">
                    </i>
                <?php }}?>

            </div>
        </div>
        <div class="bj-sp display1" style="margin-top: 41px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品详情：</p>
        </div>
        <script id="detail" type="text/plain"><?php if(isset($one)){echo $one['detail']; }?></script>

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
    });
    function AddParameter(){
        var htmlStr = '' +
            '<li>\n' +
            '                            <p>\n' +
            '                                <input style="width:48px;padding-left: 2px" type="text">\n' +
            '                            </p>\n' +
            '                            <span style="margin-left:12px;">：</span>\n' +
            '                            <input type="text" >\n' +
            '                            <img style="margin-left:5px;cursor: pointer" src="<?php echo base_url()?>assets/back/img/del.png" onclick="$(this).parents(\'li\').remove()">\n' +
            '                        </li>';
            $("#parameter_list").append(htmlStr);
    }

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

    function SaveOne(){
        var url = "SaveOne";
        var save = {};
        save.name = $("#name").val();
        save.brand_id = $("#brand_id").val();
        save.instrument_id = $("#instrument_id").val();
        save.price = $("#price").val();
        save.show_price = $("#show_price").val();
        save.detail = ue.getContent();
        save.parameters = '';
        save.img = '';
        $("#img").find(".youtu").each(function(i,t){
            if(i == 0){
                save.img += $(t).find("img").attr('src').replace("<?php echo base_url()?>","");
            }else{
                save.img += ',' + $(t).find("img").attr('src').replace("<?php echo base_url()?>","");
            }
        });
        if(save.name == '' || save.brand_id == 0 || save.instrument_id == 0 || save.price == '' || save.detail == '' || save.img == ''){
            layer.msg('商品信息不完整!')
        }
        var a = 0;
        $("#parameter_list").find("li").each(function(i,th){
            if($(th).find("input").eq(0).val() == '' || $(th).find("input").eq(1).val() == ''){
                a = 1;
                return;
            }
            if(i == 0){
                save.parameters += $(th).find("input").eq(0).val() + '@:' + $(th).find("input").eq(1).val()
            }else{
                save.parameters += '@!' + $(th).find("input").eq(0).val() + '@:' + $(th).find("input").eq(1).val()
            }
        });
        if(a){
            layer.msg('参数填写不完整!');
            return;
        }
        var data = {
            id: id,
            save: save
        };
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg('保存成功!',{time:1500},function(){
                    window.location.href = 'ProductList.html';
                })
            }else{
                layer.msg('保存失败，请重新登录后重试',{time:1500},function(){
                    window.location.href = "<?php echo base_url()?>Back/Login/Login.html"
                })
            }
        },'json')
    }
</script>
