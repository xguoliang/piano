<div class="right-down">
    <div class="right-down-title display1">
        <h2>课程编辑</h2>
        <p class="display1">
            <span class="dj display1" onclick="SaveOne()">
                 <i class="display1"><img src="<?php echo base_url()?>assets/back/img/bc.png"></i>
                 <span style="display: block;" >保存</span>
            </span>
        </p>

    </div>
    <div class="bj-sp-box">
        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">课程名称：</p>
            <input id="name" type="text" value="<?php if(isset($one)){echo $one['name'];}?>">
            <span>0/30</span>
        </div>
        <div class="bj-sp display1" style="margin-bottom: 21px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">开始时间：</p>
            <input id="start_time" type="text" value="<?php if(isset($one)){echo $one['start_time'];}?>">
        </div>
        <div class="bj-sp display1" style="margin-bottom: 24px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">结束时间：</p>
            <input id="end_time" type="text" value="<?php if(isset($one)){echo $one['end_time'];}?>">
        </div>
        <div class="bj-sp display1" style="margin-bottom: 24px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">课程类别：</p>
            <select id="instrument_id">
                <option value="0">请选择课程类别</option>
                <?php foreach($instrument as $k=>$v){?>
                <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select>
        </div>
        <div class="bj-sp display1" style="margin-bottom: 27px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">课程价格：</p>
            <input id="price" type="text" value="<?php if(isset($one)){echo $one['price'];}?>">
        </div>
        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">所在城市：</p>
            <input id="area" type="text" value="<?php if(isset($one)){echo $one['area'];}?>">
        </div>
        <div class="bj-sp display1" style="margin-bottom: 36px;align-items: flex-start;height: 116px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">详细地址：</p>
            <input id="address" type="text" value="<?php if(isset($one)){echo $one['address'];}?>">
        </div>


        <div class="bj-sp bj-tp display1" style="height: auto">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">商品图片：</p>
            <div class="display1" style="flex-wrap: wrap" id="img">
                <i class="kong">
                    <img src="<?php echo base_url() ?>assets/back/img/tp.png">
                    <input multiple type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img&maker=product&width=1&height=1">
                </i>
                <?php if(isset($one)){foreach(explode(',',$one['coverimg']) as $k => $v){?>
                    <i class="youtu" style="position:relative">
                        <img src="<?php echo base_url().$v ?>">
                        <img onclick="$(this).parent('i').remove()" src="<?php echo base_url()?>assets/back/img/del.png" style="position:absolute;top:-12px;right:-12px;width:24px;height:24px;cursor: pointer;">
                    </i>
                <?php }}?>

            </div>
        </div>
        <div class="bj-sp display1" style="margin-top: 41px">
            <p>商品详情：</p>
        </div>
        <script id="desc" type="text/plain"><?php if(isset($one)){echo $one['desc']; }?></script>
    </div>
    <div style="display:none" id="allmap"></div>
</div>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=0GgDGcoRZiNm8FVHMjIiMu53H9KiOHPU"></script>
<script src="<?php echo base_url()?>assets/laydate/laydate.js"></script>
<script>
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var point = new BMap.Point(116.331398,39.897445);
    map.centerAndZoom(point,12);
    // 创建地址解析器实例
    var myGeo = new BMap.Geocoder();
    //修改资讯的id
    var id = "<?php if(isset($one)){echo $one['id'];}else{echo '';}?>";
    var ue = UE.getEditor('desc',{
        initialFrameHeight: 300
    });
    $(function(){
        UploadImg();
        laydate.render({
            elem: '#start_time' //指定元素
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#end_time' //指定元素
            ,type: 'datetime'
        });
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

    function SaveOne(){

        var url = 'SaveOne';
        var save = {};
        save.name = $("#name").val();
        save.start_time = $("#start_time").val();
        save.end_time = $("#end_time").val();
        save.instrument_id = $("#instrument_id").val();
        save.price = $("#price").val();
        save.area = $("#area").val();
        save.address = $("#address").val();
        save.desc = ue.getContent();
        save.coverimg = '';
        $("#img").find(".youtu").each(function(i,t){
            if(i == 0){
                save.coverimg += $(t).find("img").attr('src').replace("<?php echo base_url()?>","");
            }else{
                save.coverimg += ',' + $(t).find("img").attr('src').replace("<?php echo base_url()?>","");
            }
        });
        if(save.name == '' || save.start_time == '' || save.end_time == '' || save.instrument_id == 0 || save.price == '' || save.area == '' || save.address == '' || save.desc == ''){
            layer.msg('信息填写不完整！',{time: 1500});
            return;
        }
        if(save.coverimg == '' || save.coverimg == 'assets/back/img/tp.png'){
            layer.msg('信息填写不完整！',{time: 1500});
            return;
        }
        save.lat = '';
        save.lng = '';
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(save.address, function(point){

            if (point) {
                save.lat = point.lat;
                save.lng = point.lng;
            }else{

            }
            if(save.lat == '' || save.lng == ''){
                layer.msg("您输入的地址没有解析到结果！",{time:1500});
                return;
            }
            var data = {
                id: id,
                save: save
            };
            $.post(url,data,function(res){
                layer.msg(res.msg,{time:1500},function(){
                    window.location.href = '<?php echo base_url()?>Back/Lesson/LessonList';
                })
            },'json')
        }, "中国");


    }
</script>