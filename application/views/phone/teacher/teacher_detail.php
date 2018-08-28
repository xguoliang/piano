<div class="good">
    <div class="inside-title">
        <i class="back"></i>
    </div>
</div>
<div class="teacher-dt">
    <div class="teacher-dtinfo">
        <div class="teacher-img">
            <img src="<?php echo base_url() . $one['headimg'] ?>" alt="">
        </div>
        <p class="name"><?php echo $one['name'] ?></p>
    </div>
    <div class="teacher-dtspan">
        <ul>
            <li>
                <span>450</span>
                <span>人气</span>
            </li>
            <li>
                <span><?php echo $one['year'] ?>年</span>
                <span>教龄</span>
            </li>
            <li>
                <span><?php echo $one['profession'] ?></span>
                <span>专业</span>
            </li>
        </ul>
    </div>
</div>
<div class="teacher-txt" id="teacher_content">
    <div class="teacher-txt-hd">
        <ul id="change_data">
            <li type="" class="active"><span>教师信息</span></li>
            <li type="1"><span>视频</span><span style="border-bottom: 3px;"><?php echo $one['video_num'] ?></span></li>
            <li type="0"><span>音频</span><span style="border-bottom: 3px;"><?php echo $one['audio_num'] ?></span></li>
        </ul>
    </div>
    <div class="teacher-txt-bd teacher-intro"><?php echo $one['desc'] ?></div>

    <div class="teacher-txt-bd" style="display: none">
        <div class="media-list">
            <ul id="video_list"></ul>
        </div>
    </div>
    <div class="teacher-txt-bd" style="display: none">
        <div class="music-list">
            <ul id="audio_list"></ul>
        </div>
        <audio id="audio_content" style="opacity: 0;position: absolute;"></audio>
    </div>
</div>
<audio id="audio_content" style="display: none"></audio>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script>
    var teacher_id = "<?php echo $one['id'] ?>";
    var nowpage = 1;
    var page_limit = 5;
    var p = 0, t = 0;
    var type = '';
    $(function () {
        $("#change_data").find("li").click(function () {
            var i = $(this).index();
            $("#teacher_content").children("div").not(":first").hide();
            $("#teacher_content").children("div").eq(i + 1).show()
            $(".active").removeClass("active");
            $(this).addClass("active");
            type = $(this).attr('type');
            nowpage = 1;
            $("#video_list").empty();
            $("#audio_list").empty();
            if (type != '') {
                Fetchmedia();
            }
        })
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
    });
    function Fetchmedia() {
        var url = "Fetchmedia";
        var data = {
            equal: {
                type: type,
                teacher_id: teacher_id
            }, limit: 5
            , page: nowpage
        };
        $.post(url, data, function (res) {
            var htmlStr = '';
            if (type == 0) {
                for (var i = 0; i < res.length; i++) {
                    htmlStr += '' +
                            '<li>\n' +
                            '                    <i class="iconfont icon-yinlemusic214"></i>\n' +
                            '                    <div class="music-info">\n' +
                            '                        <p class="name">' + res[i].name + '</p>\n' +
                            '                        <p class="date">' + res[i].add_time + '</p>\n' +
                            '                    </div>\n' +
                            '                    <span>\n' +
                            '                                                <i class="iconfont icon-bofang3" onclick="Playvideo(\'' + res[i].url + '\',this)"></i>\n' +
                            '                                                <i class="iconfont icon-xiazai" onclick="downloadFile(\'' + res[i].url + '\')"></i>\n' +
                            '                                            </span>\n' +
                            '                </li>';
                }
                $("#audio_list").append(htmlStr);
            } else {
                for (var i = 0; i < res.length; i++) {
                    htmlStr += '' +
                            ' <li>\n' +
                            '                    <div class="video-info">\n' +
                            '                        <video id="my-video" class="video-js video-about" controls preload="auto"  data-setup="{}">\n' +
                            '                            <source src="<?php echo base_url() ?>' + res[i].url + '" type="video/mp4">\n' +
                            '                        </video>\n' +
                            '                        <div class="video-txt">\n' +
                            '                            <div class="video-txt-info">\n' +
                            '                                <p class="name">' + res[i].name + '</p>\n' +
                            '                                <p class="date">' + res[i].add_time + '</p>\n' +
                            '                            </div>\n' +
                            '                            <div class="video-down">\n' +
                            '                                <i class="iconfont icon-xiazai" onclick="downloadFile(\'' + res[i].url + '\')"></i>\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </li>';
                }
                $("#video_list").append(htmlStr);
            }
        }, 'json')
    }

    //判断滚动方向,上滚不触发
    function ScrollTo() {
        p = $(window).scrollTop();    //下拉高度  
        if (p >= t) {
            AddMore();
        }
    }

    function AddMore() {
        var range = 50;
        var totalheight = 0;
        var srollPos = $(window).scrollTop();    //下拉高度  
        t = srollPos;
        totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
        if (($(document).height() - range) <= totalheight ) {
            if (type != '') {
                nowpage += 1;
                Fetchmedia();
            }
        }
    }

    function downloadFile(url) {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            layer.msg('请通过外部浏览器下载!', {time: 1500}, function () {
            });
        } else {
            var url = "<?php echo base_url(); ?>" + url;
            window.open(url);
        }
    }

    function Playvideo(url, th) {
        var url = "<?php echo base_url() ?>" + url;
        if (url != $("#audio_content").attr('src')) {
            $("#audio_content").attr('src', url);
        }
        if ($(th).hasClass("icon-bofang3")) {
            $('#audio_list').find('i').eq(1).removeClass('icon-bofang2').addClass('icon-bofang3');
            $(th).removeClass("icon-bofang3").addClass("icon-bofang2");
            $("#audio_content")[0].play();
        } else {
            $(th).removeClass("icon-bofang2").addClass("icon-bofang3");
            $("#audio_content")[0].pause();
        }
    }

</script>
