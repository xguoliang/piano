<style>
    .video-js{
        width: 100%!important;
    }
    .music-list ul li span a .icon-xiazai{
        margin-left: .4rem;
        font-size: .45rem;
    }
</style>
<div class="business good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>音乐视频</p>
    </div>
    <div class="good-order-fenlei music-fenlei">
        <ul>
            <li class="active"><span>音乐</span></li>
            <li><span>视频</span></li>
        </ul>
    </div>
</div>
<!-- 音乐视频start -->
<div class="music-list">
    <ul id="neirong">

    </ul>
    <div id="more" onclick="more(1)" class="click_more">
        查看更多
    </div>
    <audio id="audio_content" style="opacity: 0;position: absolute;"></audio>
</div>
<div class="media-list" style="display:none;">
    <ul id="vneirong">

    </ul>
    <div id="vmore" onclick="more(2)" class="click_more">
        查看更多
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/video.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
        var sound_pages = 1;
        var movie_pages = 1;
        select_works(1);
        select_works(2);
        $('.music-fenlei').find('li').click(function () {
            if ($(this).hasClass('active') == false) {
                $('.music-fenlei').find('li').removeClass('active');
                $(this).addClass('active');
                var index = $(this).index();
                if (index == 0) {
                    $('.media-list').hide();
                    $('.music-list').show();
                } else {
                    $('.music-list').hide();
                    $('.media-list').show();
                }
            }
        })
        function more(type) {
            if (type == 1) {
                sound_pages++;
                select_works(1);
            } else {
                movie_pages++;
                select_works(2);
            }
        }
        function select_works(type) {
            var url = "SelectWorks";
            var pages = 0;
            if (type == 1) {
                pages = sound_pages;
            } else {
                pages = movie_pages;
            }
            $.ajax({
                type: "post",
                url: url,
                data: {
                    type: type,
                    pagesize: 10,
                    pages: pages
                },
                dataType: "json",
                success: function (data, textStatus) {
                    if (type == 1) {
                        if (data.length < 10) {
                            $('#more').hide();
                        }
                        for (var i = 0; i < data.length; i++) {
                            $('#neirong').append('<li>' +
                                    '<i class="iconfont icon-yinlemusic214"></i>' +
                                    '<div class="music-info">' +
                                    '<p class="name">' + data[i].name + '</p>' +
                                    '<p class="date">' + data[i].add_time.split(' ')[0] + '</p>' +
                                    '</div>' +
                                    '<span>' +
                                    '<i class="iconfont icon-bofang3" onclick="PlayAudio(this)" lurl="' + data[i].url + '"></i>' +
                                    '<a onclick="downloads(this.id)" id="' + data[i].url + '"><i class="iconfont icon-xiazai"></i></a>' +
                                    '</span>' +
                                    '</li>');
                        }
                    } else {
                        if (data.length < 10) {
                            $('#vmore').hide();
                        }
                        for (var i = 0; i < data.length; i++) {
                            $('#vneirong').append('<li>' +
                                    '<div class="video-info">' +
                                    '<video id="my-video" class="video-js video-about" controls preload="auto"  data-setup="{}" style="object-fit:fill;">' +
                                    '<source src="<?php echo base_url(); ?>' + data[i].url + '" type="video/mp4">' +
                                    '</video>' +
                                    '<div class="video-txt">' +
                                    '<div class="video-txt-info">' +
                                    '<p class="name">' + data[i].name + '</p>' +
                                    '<p class="date">' + data[i].add_time + '</p>' +
                                    '</div>' +
                                    '<div class="video-down">' +
                                    '<a onclick="downloads(this.id)" id="' + data[i].url + '"><i class="iconfont icon-xiazai"></i></a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</li>')
                        }
                    }
                }
            });
        }
        function PlayAudio(th) {
            var src = "<?php echo base_url() ?>" + $(th).attr('lurl');
            if ($(th).hasClass("icon-bofang3")) {
                $(".icon-bofang2").removeClass("icon-bofang2").addClass("icon-bofang3");
                $(th).removeClass("icon-bofang3").addClass("icon-bofang2");
                if (src != $("#audio_content").attr('src')) {
                    $("#audio_content").attr('src', src);
                    $("#audio_content")[0].load();

                }
                $("#audio_content")[0].play();
            } else {
                $(th).removeClass("icon-bofang2").addClass("icon-bofang3");
                $("#audio_content")[0].pause();
            }

        }
        function downloads(th) {
            var ua = navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == "micromessenger") {
                layer.msg('请通过外部浏览器下载!', {time: 1500}, function () {
                });
            } else {
                var url = "<?php echo base_url(); ?>" + th;
                window.open(url);
            }
        }
</script>