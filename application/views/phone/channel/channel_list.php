<div class="vip good">
    <div class="inside-title">
        <i class="back"></i>
        <p>特色频道</p>
    </div>
</div>
<div class="live">
    <div class="title-head">
        <img src="<?php echo base_url(); ?>assets/img/phone/11.png">
        <span>特色频道</span>
    </div>
    <ul class="live-item" id="channel_list"></ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>

<script>
    var nowpage = 1;
    var page_limit = 10;
    var p = 0, t = 0;
    $(function () {
        getChannel();
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
    });

    //
    function getChannel() {
        var url = 'getChannel';
        var data = {
            page: nowpage,
            limit: page_limit
        }
        $.post(url, data, function (res) {
            var htmlStr = '';
            for (var i = 0; i < res.length; i++) {
                htmlStr += '' +
                        '<li >\n' +
                        '                <div class="live-img">\n' +
                        '                    <img src="<?php echo base_url() ?>' + res[i].img + '" alt="">\n';
                if (res[i].desc != '') {
                    if (i % 5 == 0) {
                        htmlStr += '' +
                                '                        <span class="live-span live-span1">' + res[i].desc + '</span>\n';
                    } else if (i % 5 == 1) {
                        htmlStr += '' +
                                '                        <span class="live-span live-span2">' + res[i].desc + '</span>\n';
                    } else if (i % 5 == 2) {
                        htmlStr += '' +
                                '                        <span class="live-span live-span3">' + res[i].desc + '</span>\n';
                    } else if (i % 5 == 3) {
                        htmlStr += '' +
                                '                        <span class="live-span live-span4">' + res[i].desc + '</span>\n';
                    } else if (i % 5 == 4) {
                        htmlStr += '' +
                                '                        <span class="live-span live-span5">' + res[i].desc + '</span>\n';
                    }
                }
                htmlStr += '' +
                        '                </div>\n' +
                        '                <p>' + res[i].name + '</p>\n' +
                        '            </li>';
            }
            $("#channel_list").append(htmlStr);
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
            nowpage += 1;
            getChannel();
        }
    }
</script>
