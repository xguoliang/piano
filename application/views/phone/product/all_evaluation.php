<div class="expert good">
    <div class="inside-title">
        <i class="back"></i>
        <p>全部评价 </p>
    </div>
</div>
<div class="assess-all">
    <ul class="gooddt-assess" id="eva_list"></ul>
</div>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script>
    var id = "<?php echo $id?>";
    var nowpage = 1,
        page_limit = 5,
        p = 0,
        t = 0;
    $(function () {
        GetEvaluate();
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
    });

    //判断滚动方向,上滚不触发
    function ScrollTo(){
        p =  $(window).scrollTop();    //下拉高度  
        if(p >= t){
            AddMore();
        }
    }

    function AddMore(){
        var range = 50;
        var totalheight = 0;
        var srollPos = $(window).scrollTop();    //下拉高度  
        t = srollPos;
        totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
        if(($(document).height()-range) <= totalheight ) {
            nowpage += 1;
            GetEvaluate();
        }
    }

    function GetEvaluate() {
        var url = 'GetEvaluate';
        var data = {
            id: id,
            page: nowpage,
            limit: page_limit
        };
        $.post(url, data, function (res) {
            var htmlStr = '';
            for (var i = 0; i < res.length; i++) {
                htmlStr += '' +
                    '      <li>\n' +
                    '            <div class="gooddt-assessimg">\n' +
                    '                <img src="<?php echo base_url()?>'+res[i].headimg+'" alt="">\n' +
                    '            </div>\n' +
                    '            <div class="gooddt-assesstxt">\n' +
                    '                <p class="name">'+res[i].user_name+'</p>\n' +
                    '                <p class="gooddt-assessdt"><span>评分</span><span>' ;
                    for(var a=0;a<5;a++){
                        if(a<res[i].star){
                            htmlStr += '<img src="<?php echo base_url()?>assets/img/phone/asse1.png" alt="">';
                        }else{
                            htmlStr += '<img src="<?php echo base_url()?>assets/img/phone/asse.png" alt="">';
                        }
                    }
                    htmlStr += '' +
                    '</span></p>\n' +
                    '                <p class="gooddt-content">'+res[i].desc+'</p>\n' +
                    '                <span class="date">'+res[i].add_time+'</span>\n' +
                    '                <div class="assess-dt-img">\n' +
                    '                    <ul>\n' ;
                    for(var j = 0;j<res[i].img.split(',').length;j++){
                        htmlStr += '' +
                            '                        <li>\n' +
                            '                            <div class="assessimg">\n' +
                            '                                <span><img src="<?php echo base_url()?>'+res[i].img.split(',')[j]+'" alt=""></span>\n' +
                            '                            </div>\n' +
                            '                        </li>\n' ;
                    }

                    htmlStr += '' +
                    '                    </ul>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '        </li>'
            }
            $("#eva_list").append(htmlStr);
        }, 'json')
    }
</script>
