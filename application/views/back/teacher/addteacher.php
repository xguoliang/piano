<style>
    .icon-shanchu1{
        cursor:pointer;
    }
    .icon-bianji1{
        cursor:pointer;
    }
</style>
<div class="mengceng"></div>
<!--视频弹出-->
<div class="sp-tc">
    <i class="iconfont icon--X"></i>
    <div class="sp-tc-title display1">
        <p>标题：</p>
        <input id="v_name" type="text" placeholder="2-30字">
    </div>
    <div class="sp-tc-video">
        <h3>上传视频：</h3>
        <div class="tc-video display1">
            <div class="kong-video" style="display:none">
                <i class="iconfont icon-tianjiashipin-m"></i>
                <p>添加视频</p>
                <input id="upload_video" file_type="video" type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadVideo?id=video_content&maker=media">
            </div>
            <video id="video_content" style="display: none" controls poster=""></video>
            <i id="click_video" class="iconfont icon-bianji1" onclick="$('#upload_video').click()" style="font-size: 20px;color: #fba420;padding-left: 10px;"></i>

            <div class="fm-video display1">
                <p>设置封面</p>
                <span>(默认视频第一帧为封面)</span>
                <input id="video_upload" file_type="img" type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=video_img&maker=teacher">
                <img style="cursor: pointer" id="video_img" onclick="$('#video_upload').click()">
            </div>
        </div>
    </div>
    <div class="sp-tc-button display1">
        <button class="qx" onclick="CancelVideo()">取消</button>
        <button class="qr" onclick="ConfirmVideo()">确认</button>
    </div>
</div>


<!--音频弹出-->
<div class="yp-tc">
    <i class="iconfont icon--X"></i>
    <div class="yp-tc-title display1">
        <p>标题：</p>
        <input type="text" placeholder="2-30字" id="s_name">
        <input type="text" style="display: none" id="s_url">
    </div>
    <div class="yp-tc-mp3">
        <h3>上传音频：</h3>
        <div id="m_content">
            <div class="bj-yp you-mp3" style="margin-left: 20px;" id="edit_music">
                <div class="you-mp3-left" style="align-items: center">
<!--                    <i class="iconfont icon-bofang3" style=""></i>-->
                    <p style="padding-left: 10px"><img src="<?php echo base_url()?>assets/back/img/yp.png"></p>
                    <div>
                        <h4 id="music_name"></h4>
                        <span id="music_time"></span>
                    </div>
                </div>
                <p class="you-mp3-right" >
                    <a>
                        <i class="iconfont icon-bianji1" onclick="$('#music_upload').click()"></i>
                    </a>
                    <input id="music_upload" type="file" file_type="music" name="files"  style="display:none;" data-url="<?php echo base_url(); ?>index.php/Example/UploadMusic?id=edit_music&maker=media">
                </p>
            </div>
            <div class="bj-yp kong-mp3" id="add_music" style="margin-left: 20px;" >
                <i><img src="<?php echo base_url()?>assets/back/img/yy.png"></i>
                <p style="margin-left: 20px">添加音频</p>
                <input type="file" file_type="music" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadMusic?id=edit_music&maker=media">
            </div>
        </div>
        <div class="sp-tc-button display1" style="margin-top: 30px">
            <button class="qx" onclick="CancelMusic()">取消</button>
            <button class="qr" onclick="ConfirmMusic()">确认</button>
        </div>
    </div>
</div>
<div class="right-down">
    <div class="right-down-title display1">
        <h2>老师信息编辑</h2>
        <p class="display1">
            <span onclick="SaveOne()" class="dj display1">
                 <i class="display1"><img src="<?php echo base_url()?>assets/back/img/bc.png"></i>
                 <span style="display: block;">保存</span>
            </span>
        </p>
    </div>
    <div class="bj-sp-box">
        <div class="bj-sp display1" style="height:116px;margin-bottom: 36px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">老师头像：</p>
            <?php if(isset($one)){if($one['headimg'] != ''){?>
                <i class="tx display1 youtu">
                    <img id="headimg" src="<?php echo base_url().$one['headimg']?>">
                    <input file_type="img" type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=headimg&maker=teacher&width=1&height=1">
                </i>
            <?php }else{?>
                <i class="tx display1">
                    <img id="headimg" src="<?php echo base_url()?>assets/back/img/xj.png">
                    <input  file_type="img"  type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=headimg&maker=teacher&width=1&height=1">
                </i>
            <?php }}else{?>
                <i class="tx display1">
                    <img id="headimg" src="<?php echo base_url()?>assets/back/img/xj.png">
                    <input  file_type="img"  type="file" name="files" data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=headimg&maker=teacher&width=1&height=1">
                </i>
            <?php }?>
        </div>
        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">老师名称：</p>
            <input id="name" type="text" value="<?php if(isset($one)){echo $one['name'];}?>">
        </div>
        <div class="bj-sp display1">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">教&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄：</p>
            <input id="year" type="text" value="<?php if(isset($one)){echo $one['year'];}?>">
        </div>
        <div class="bj-sp display1" style="margin-bottom: 17px">
            <p style="">专&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;业：</p>
            <input id="profession" type="text" value="<?php if(isset($one)){echo $one['profession'];}?>">
        </div>
        <div class="bj-sp display1" style="margin-bottom: 25px;height:auto;align-items: flex-start">
            <p>课程选择：</p>
            <div class="display1 kc">
                <?php foreach($lesson as $k=>$v){?>
                    <h3>
                        <input type="checkbox" name="course" <?php if(isset($one)){if(in_array($v['id'],$my_lesson_id)){echo "checked";}}?> lesson_id="<?php echo $v['id']?>"><?php echo $v['name']?>
                    </h3>
                <?php }?>
            </div>
        </div>
        <div class="bj-sp display1" style="align-items: flex-start;height: 128px">
            <span style="color:red;">*</span>
            <p style="padding-left: 0">简&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;介：</p>
            <textarea placeholder="老师详情介绍1-100字" style="padding-top: 5px" id="desc"><?php if(isset($one)){echo $one['desc'];}?></textarea>
        </div>
        <div id="audio_lists" class="bj-sp display1" style="height:auto;align-items: flex-start">
            <p style="">上传音频：</p>
            <div>
                <?php foreach($sound as $k=>$v){?>
                    <div id="media_<?php echo $v['id']?>" class="bj-yp you-mp3 display1 audio_content">
                        <div class="you-mp3-left display1" style="align-items: center">
                            <i onclick="PlayAudio(this)" lurl="<?php echo $v['url']?>" class="iconfont icon-bofang3"></i>
                            <p><img src="<?php echo base_url()?>assets/back/img/yp.png"></p>
                            <div>
                                <h4><?php echo $v['name']?></h4>
                                <span><?php echo $v['add_time']?></span>
                            </div>
                        </div>
                        <p class="you-mp3-right">
                            <a onclick="ShowMusicAdd(<?php echo "'".$v['name']."'"?>,<?php echo "'".$v['add_time']."'"?>,<?php echo $v['id']?>,this)"><i class="iconfont icon-bianji1"></i></a>
                            <i class="iconfont icon-shanchu1" onclick="DeleteVideo(this)"></i>
                        </p>
                    </div>
                <?php }?>
                <audio id="audio_content" style="opacity: 0;position: absolute;"></audio>

                <div  id="empty_auido" class="bj-yp kong-mp3 display1" onclick="ShowMusicAdd('','','',this)" >
                    <i><img src="<?php echo base_url()?>assets/back/img/yy.png"></i>
                    <p>添加音频</p>
                </div>
            </div>


        </div>
        <div id="video_lists" class="bj-sp display1" style="height:auto;align-items: flex-start">
            <p style="">上传视频：</p>
            <div  class="sp-box display1" style="">
                <?php foreach($video as $k=>$v){?>
                    <div id="media_<?php echo $v['id']?>"  class="you-sp video_content">
                        <video src="<?php echo base_url().$v['url']?>" controls poster="<?php echo base_url().$v['img']?>"></video>
                        <div>
                            <p><?php echo $v['name']?></p>
                            <p class="display1">
                                <span><?php echo $v['add_time']?></span>
                                <span>
                             <a onclick="ShowVideoAdd(<?php echo "'".$v['name']."'"?>,<?php echo "'".base_url().$v['url']."'"?>,<?php echo "'".base_url().$v['img']."'"?>,<?php echo "'".$v['id']."'"?>,this)"><i class="iconfont icon-bianji1"></i></a>
                             <i class="iconfont icon-shanchu1" onclick="DeleteVideo(this)"></i>
                        </span>
                            </p>
                        </div>
                    </div>
                <?php }?>

                <div id="empty_video"  class="kong-sp display1" onclick="ShowVideoAdd('','','','',this)">
                    <i class="iconfont icon-tianjiashipin-m"></i>
                    <p>添加视频</p>
                </div>
                <!--<div class="kong-sp display1 "></div>-->
            </div>

        </div>
    </div>
</div>
<script>
    var music_url = '';
    var music_index = '';
    var video_index = '';

    var teacher_id = '<?php if(isset($one)){echo $one['id'];}else{echo '';}?>';
    $(function () {
        $(".icon--X").click(function () {
            $(".mengceng").css("display","none");
            $(".yp-tc").css({"top":"-40%"});
            $(".sp-tc").css({"top":"-40%"});
        });
        $(".qx").click(function () {
            $(".mengceng").css("display","none");
            $(".yp-tc").css({"top":"-40%"});
            $(".sp-tc").css({"top":"-40%"});
        });
        var i =1;

        $("#audio_content")[0].onended = function() {
            $(".icon-bofang2").removeClass("icon-bofang2").addClass("icon-bofang3");
        };
    });

    $(function(){
        UploadImg();
        UploadVoice();
        UploadVideo();
    });

    function ShowMusicAdd(name,time,id = '',th){
        music_index = $(th).parents(".audio_content").index();
        var lurl = $(th).parents(".audio_content").find("i").eq(0).attr('lurl');
        $("#s_url").val(lurl);
        $(".mengceng").css("display","block");
        $(".yp-tc").css({"top":"50%","transition":"all 1s"});
        if(id == ''){
            $("#music_name").text('');
            $("#music_time").text('');
            $("#s_name").val('');
            $("#add_music").css('display','flex');
            $("#edit_music").css('display','none');

        }else{
            $("#edit_music").css('display','flex');
            $("#add_music").css('display','none');
            $("#music_name").text(name);
            $("#s_name").val(name);
            $("#music_time").text(time)
        }
    }

    function ShowVideoAdd(name,src,img,id = '',th){
        video_index = $(th).parents(".video_content").index();
        $(".mengceng").css("display","block")
        $(".sp-tc").css({"top":"50%","transition":"all 1s"});
        if(id == ''){
            $("#video_content").removeAttr('src');
            $("#video_img").removeAttr('src').css('display','none');
            $("#v_name").val('');
            $(".kong-video").css('display','flex');
            $("#video_content").css('display','none');
            $("#click_video").hide();
        }else{
            $(".kong-video").css('display','none');
            $("#video_content").css('display','flex');
            $("#video_content").attr('src',src);
            $("#video_img").attr('src',img).css('display','flex');
            $("#v_name").val(name);
            $("#click_video").show();

        }
        $(".mengceng").css("display","block");
        $(".sp-tc").css({"top":"50%","transition":"all 1s"});
    }

    //上传图片
    function UploadImg(){
        $("input[file_type='img']").fileupload({
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
                    $("#"+resultJson[0]).attr('src',src);
                    if(resultJson[0] == 'video_img'){
                        $("#video_upload").css('display','none');
                        $("#video_img").css('display','flex');
                    }
                }
            },
            progress: function (e, data) {

            },
        });
    }

    function UploadVoice(){
        $("input[file_type='music']").fileupload({
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
                    $("#add_music").css('display','none');
                    $("#edit_music").css('display','flex');
                    $("#music_name").text(a[1].split('/').pop() + '.' + a[2]);
                    $("#music_time").text(GetDateTime);
                    $("#s_url").val(a[1] + '.' +a[2]);
                    music_url = src;
                }
            },
            progress: function (e, data) {

            },
        });
    }

    function UploadVideo(){
        $("input[file_type='video']").fileupload({
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
                    $(".kong-video").css('display','none');
                    $("#video_content").css('display','flex');
                    $("#"+resultJson[0]).attr('src',src);
                    $("#click_video").show();

                }
            },
            progress: function (e, data) {

            },
        });
    }

    function DeleteVideo(th){
        layer.confirm('确定删除？',{btn:['确定','取消']}
            ,function(){
                $(th).parents('.you-mp3').remove();
                $(th).parents('.you-sp').remove();
                layer.closeAll();
            }
            ,function(){
                layer.closeAll();
            }
        )
    }

    function PlayAudio(th){
        var src="<?php echo base_url()?>"+$(th).attr('lurl');
        if($(th).hasClass("icon-bofang3")){
            $(".icon-bofang2").removeClass("icon-bofang2").addClass("icon-bofang3");
            $(th).removeClass("icon-bofang3").addClass("icon-bofang2");
            if(src != $("#audio_content").attr('src')){
                $("#audio_content").attr('src',src);
                $("#audio_content")[0].load();

            }
            $("#audio_content")[0].play();
        }else{
            $(th).removeClass("icon-bofang2").addClass("icon-bofang3");
            $("#audio_content")[0].pause();
        }

    }

    function PauseAudio(){
        $("#audio_content").pause();
    }

    function GetDateTime(){
        var myDate = new Date;
        var year = myDate.getFullYear();//获取当前年
        var yue = ((myDate.getMonth()+1) < 10) ?'0' + (myDate.getMonth()+1) :myDate.getMonth()+1;//获取当前月
        var date = (myDate.getDate() < 10) ? '0'+ myDate.getDate() : myDate.getDate();//获取当前日
        var h = (myDate.getHours() < 10) ? '0' + myDate.getHours():myDate.getHours();//获取当前小时数(0-23)
        var m = (myDate.getMinutes() < 10) ? '0' + myDate.getMinutes():myDate.getMinutes();//获取当前分钟数(0-59)
        var s = (myDate.getSeconds()< 10) ? '0' + myDate.getSeconds():myDate.getSeconds() ;//获取当前秒
        return year + '-' + yue + '-' + date + ' ' + h + ':' + m + ':' + s;
    }

    function CancelMusic(){
        $("#music_name").text('');
        $("#music_time").text('');
    }

    function ConfirmMusic(){
        layer.confirm('确定上传音频?',{btn:['确定','取消']}
            ,function(){
                var a = $("#s_name").val();
                var b = $("#music_time").text();
                if(a == '' || b == ''){
                    layer.msg("请填写名称或上传文件！",{time:1500});
                    return;
                }
                if(music_index == ''){
                    $(".audio_content").eq(music_index).find("h4").text(a);
                    $(".audio_content").eq(music_index).find("span").text(b);
                    $(".audio_content").eq(music_index).find("a").attr('onclick','ShowMusicAdd(\''+a+'\',\''+b+'\',1,this)');
                    $(".audio_content").eq(music_index).find("i").eq(0).attr('lurl',$('#s_url').val());
                }else{
                    var htmlStr = '' +
                        '   <div class="bj-yp you-mp3 display1 audio_content">\n'+
                        '                        <div class="you-mp3-left display1" style="align-items: center">\n'+
                        '                            <i onclick="PlayAudio(this)" lurl='+$('#s_url').val()+'  class="iconfont icon-bofang3"></i>\n'+
                        '                            <p><img src="<?php echo base_url()?>assets/back/img/yp.png"></p>\n'+
                        '                            <div>\n'+
                        '                                <h4>'+a+'</h4>\n'+
                        '                                <span>'+b+'</span>\n'+
                        '                            </div>\n'+
                        '                        </div>\n'+
                        '                        <p class="you-mp3-right">\n'+
                        '                            <a onclick="ShowMusicAdd(\''+a+'\',\''+b+'\',1,this)"><i class="iconfont icon-bianji1"></i></a>\n'+
                        '                            <i class="iconfont icon-shanchu1" onclick="DeleteVideo(this)"></i>\n'+
                        '                        </p>\n'+
                        '                    </div>';
                        if($(".audio_content").length>0){
                            $(".audio_content").last().after(htmlStr);
                        }else{
                            $("#empty_auido").before(htmlStr);
                        }
                }
                $("#music_name").text('');
                $("#music_time").text('');
                $("#s_name").val('');
                $(".icon--X").click();
                layer.closeAll();
                UploadVoice();
                music_index = '';
            }
            ,function(){
                layer.closeAll();
            }
        )
    }

    function CancelVideo(){
        $(".icon--X").click();
        $("#video_content").removeAttr('src');
        $("#video_img").removeAttr('src').css('display','none');
        $("#v_name").val('');
        $(".kong-video").css('display','flex');
        $("#video_content").css('display','none');
    }

    function ConfirmVideo(){
        layer.confirm('确定上传视频？',{btn:['确定','取消']}
            ,function(){
                var a = $("#video_content").attr('src');
                var b = $("#video_img").attr('src');
                var c = $("#v_name").val();
                if(a == '' || b == '' || c == ''){
                    layer.msg('信息填写不完整!',{time:1500})
                }
                if(video_index == ''){
                    $(".video_content").eq(video_index).find("span").eq(0).text(GetDateTime());
                    $(".video_content").eq(video_index).find("a").eq(0).attr('src','ShowVideoAdd(\''+c+'\',\''+a+'\',\''+b+'\',1,this)');
                    $(".video_content").eq(video_index).find("p").eq(0).text(c);
                    $(".video_content").eq(video_index).find("video").eq(0).attr('src',a);
                    $(".video_content").eq(video_index).find("video").eq(0).attr('poster',b);

                }else{
                    var htmlStr = '' +
                        '   <div  class="you-sp video_content">\n'+
                        '                        <video src="'+a+'" controls poster="'+b+'"></video>\n'+
                        '                        <div>\n'+
                        '                            <p>'+c+'</p>\n'+
                        '                            <p class="display1">\n'+
                        '                                <span>'+GetDateTime()+'</span>\n'+
                        '                                <span>\n'+
                        '                             <a onclick="ShowVideoAdd(\''+c+'\',\''+a+'\',\''+b+'\',1,this)"><i class="iconfont icon-bianji1"></i></a>\n'+
                        '                             <i class="iconfont icon-shanchu1" onclick="DeleteVideo(this)"></i>\n'+
                        '                        </span>\n'+
                        '                            </p>\n'+
                        '                        </div>\n'+
                        '                    </div>';
                    if($(".video_content").length>0){
                         $('.video_content').last().after(htmlStr);

                    }else{
                        $("#empty_video").before(htmlStr);
                    }

                }

                $("#video_content").removeAttr('src');
                $("#video_img").removeAttr('src').css('display','none');
                $("#v_name").val('');
                $(".kong-video").css('display','flex');
                layer.closeAll();
                $(".icon--X").click();
                UploadVideo();
            }
            ,function(){
                layer.closeAll();
            }
        )
    }

    function SaveOne(){
        var url = 'SaveOne';
        var teacher = {};
        teacher.name = $("#name").val();
        teacher.year = $("#year").val();
        teacher.profession = $("#profession").val();
        teacher.headimg = $("#headimg").attr('src').replace("<?php echo base_url()?>","");
        teacher.desc = $("#desc").val();
        var my_lesson = {};
        $(".kc").find("input[type='checkbox']:checked").each(function(i,e){
            my_lesson[i] = $(e).attr('lesson_id');
        });
        var music = {};
        $(".audio_content").each(function(i,e){
            music[i] = {};
            music[i].name = $(e).find('h4').text();
            music[i].url = $(e).find("i").eq(0).attr('lurl');
            music[i].type = 0;
            music[i].add_time = $(e).find("span").eq(0).text();

        });
        var video = {};
        $(".video_content").each(function(i,e){
            video[i] = {};
            video[i].name = $(e).find("p").eq(0).text();
            video[i].url =  $(e).find("video").attr('src').replace("<?php echo base_url()?>","");
            video[i].img =  $(e).find("video").attr('poster').replace("<?php echo base_url()?>","");
            video[i].add_time = $(e).find("span").eq(0).text();
            video[i].type = 1;

        });
        var data = {
            id: teacher_id,
            teacher: teacher,
            my_lesson:my_lesson,
            music: music,
            video: video
        };
        $.post(url,data,function(res){
            layer.msg(res.msg,{time:1500},function(){
                window.location.href = "TeacherList.html";
            })
        },'json')
    }
</script>
