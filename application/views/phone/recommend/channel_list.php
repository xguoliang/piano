<div class="vip good">
    <div class="inside-title">
        <i class="back"></i>
        <p>精彩活动</p>
    </div>
</div>
<div class="live">
    <div class="title-head">
        <img src="<?php echo base_url(); ?>assets/img/phone/11.png">
        <span>精彩活动</span>
    </div>
    <ul class="live-item" id="recommend_list"></ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>

<script>
    var nowpage = 1;
    var page_limit = 10;
    var p = 0, t = 0;
    $(function(){
        getRecommend();
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
    });

    //
    function getRecommend(){
        var url = 'getRecommend';
        var data = {
            page: nowpage,
            limit: page_limit
        }
        $.post(url,data,function(res){
            var htmlStr = '';
            for(var i = 0;i<res.length;i++){
                htmlStr += '' +
                    '<li >\n' +
                    '                <div class="live-img">\n' +
                    '                    <img src="<?php echo base_url()?>'+res[i].img+'" alt="">\n' ;
                    if(res[i].desc == ''){
                        htmlStr += '' +
                            '                        <span class="live-span live-span1">'+res[i].desc+'</span>\n' ;
                    }
                    htmlStr += '' +
                    '                </div>\n' +
                    '                <p>'+res[i].name+'</p>\n' +
                    '            </li>';
            }
            $("#recommend_list").append(htmlStr);
        },'json')
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
            getRecommend();
        }
    }
</script>
