<div class="vip good">
    <div class="inside-title">
        <i class="back"></i>
        <p>会员专享</p>
    </div>
</div>
<!-- 会员专享start -->
<div class="vip-list">
    <ul id="vip_list"></ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>

<script>
    var nowpage = 1;
    var page_limit = 6;
    var p = 0, t = 0;
    $(function(){
        getVip();
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
    });

    //
    function getVip(){
        var url = 'getVip';
        var data = {
            page: nowpage,
            limit: page_limit
        }
        $.post(url,data,function(res){
            var htmlStr = '';
            for(var i = 0;i<res.length;i++){
                if(res[i].is_link == 1){
                    htmlStr += '' +
                        '  <li>\n' +
                        '            <a href="'+res[i].link+'"><img src="<?php echo base_url()?>'+res[i].img+'" alt=""></a>\n' +
                        '        </li>';
                }else{
                    htmlStr += '' +
                        '  <li>\n' +
                        '            <a><img src="<?php echo base_url()?>'+res[i].img+'" alt=""></a>\n' +
                        '        </li>';
                }
            }
            $("#vip_list").append(htmlStr);
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
            getVip();
        }
    }
</script>
