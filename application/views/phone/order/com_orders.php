<div class="my-order good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p><?php
            if ($entity_type == 1) {
                echo '商品订单';
            } else if ($entity_type == 2) {
                echo '课程订单';
            } else if ($entity_type == 3) {
                echo '活动订单';
            } else {
                
            }
            ?></p>
    </div>
    <div class="good-order-fenlei <?php if($entity_type != 1){echo "course-order-fenlei";}?>">
        <ul id="status_list">
            <li class="active" status="0"><span>全部</span></li>
            <li status="1"><span >待付款</span></li>
            <li status="2"><span>待提货</span></li>
            <?php if($entity_type == 1){?>
            <li status="3"><span>待评价</span></li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="good-order-list" id="order_list"></div>
<div class="mask">
    <div class="cover-floor "></div>
</div>
<div class="saled">
    <i class="iconfont icon-guanbi" onclick="CloseMask()"></i>
    <h5>请描述您遇到的问题：</h5>
    <textarea id="desc"></textarea>
    <button onclick="SaveService()">提交</button>
</div>
</body>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script>
    var user_id = "<?php echo $_SESSION['lerenuser']['id']?>";
    var nowpage = 1,
        page_limit = 5,
        p = 0,
        t = 0,
        status = 0,
        entity_type = "<?php echo $entity_type?>";

    $(function(){
        GetOrders();
        $("#status_list").find("li").click(function(){
            if($(this).attr('status') != $(".active").attr('status')){
                $("#status_list").find("li").removeClass("active");
                $(this).addClass("active");
                status = $(this).attr('status');
                nowpage = 1;
                t = 0;
                $("#order_list").empty();
                GetOrders();
            }
        });
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
            GetOrders();
        }
    }

    function GetOrders(){
        var url = "GetComOrders";
        var data = {
            page: nowpage,
            limit: page_limit,
            entity_type: entity_type,
            status: status
        };
        $.post(url,data,function(res){
            var htmlStr = '';
            for(var i = 0;i<res.length;i++){
                var a = 0;
                htmlStr += '' +
                    ' <div id="order_'+res[i].id+'" class="good-order-item">\n' +
                    '        <div class="good-order-hd">\n' +
                    '            <a href="<?php echo base_url()?>User/User/UserDetail?id='+res[i].user_id+'"><i class="iconfont icon-fuhao-shangdian"></i><span>'+res[i].user_name+'</span><i class="iconfont icon-right"></i></a>\n' +
                    '        </div>\n' +
                    '        <ul class="order-dt-list">\n' ;
                if(entity_type == 1){
                    for(var j = 0;j<res[i].details.length;j++){
                        a++;
                        htmlStr += '' +
                            '            <li>\n' +
                            '                <a href="<?php echo base_url()?>User/Orders/OrderDetail?id='+res[i].details[j].id+'">\n' +
                            '                    <div class="order-img">\n' +
                            '                        <img src="<?php echo base_url()?>'+res[i].details[j].coverimg.split(',')[0]+'" alt="">\n' +
                            '                    </div>\n' +
                            '                    <div class="order-txt">\n' +
                            '                        <p class="order-good">'+res[i].details[j].name+'</p>\n' +
                            '                        <p class="order-goodnum"><span>¥'+res[i].details[j].price+'/件</span><span>×'+res[i].details[j].num+'</span></p>\n' +
                            '                    </div>\n' +
                            '                </a>\n' +
                            '            </li>\n' ;
                    }
                }else if(entity_type == 2){
                    for(var j = 0;j<res[i].details.length;j++) {
                        htmlStr += '' +
                            '                <li>\n' +
                            '                <a href="<?php echo base_url()?>User/Orders/OrderDetail?id='+res[i].details[j].id+'">\n' +

                            '                        <div class="order-img">\n' +
                            '                            <img src="<?php echo base_url()?>'+res[i].details[j].coverimg.split(',')[0]+'" alt="">\n' +
                            '                        </div>\n' +
                            '                        <div class="order-txt">\n' +
                            '                            <p class="order-good">'+res[i].details[j].name+'</p>\n' +
                            '                            <p class="order-goodnum"><span>价格：¥'+res[i].details[j].price+'/课</span><span>×'+res[i].details[j].num+'</span></p>\n' +
                            '                            <p class="order-date"><span>时间：'+res[i].details[j].start_time+'-'+res[i].details[j].end_time+'</span></p>\n' +
                            '                            <p class="order-address"><span>地址：'+res[i].details[j].address+'</span></p>\n' +
                            '                        </div>\n' +
                            '                    </a>\n' +
                            '                </li>\n';
                    }
                }else{
                    for(var j = 0;j<res[i].details.length;j++) {
                        htmlStr += '' +
                            '<li>\n' +
                            '                <a href="<?php echo base_url()?>User/Orders/OrderDetail?id='+res[i].details[j].id+'">\n' +

                            '                                    <div class="order-img">\n' +
                            '                                        <img src="<?php echo base_url()?>'+res[i].details[j].coverimg.split(',')[0]+'" alt="">\n' +
                            '                                    </div>\n' +
                            '                                    <div class="order-txt">\n' +
                            '                                        <p class="order-good">'+res[i].details[j].name+'</p>\n' +
                            '                                        <p class="order-goodnum"><span>价格：¥'+res[i].details[j].price+'</span><span>×'+res[i].details[j].num+'</span></p>\n' +
                            '                                        <p class="order-date"><span>时间：'+res[i].details[j].start_time+'-'+res[i].details[j].end_time+'</span></p>\n' +
                            '                                        <p class="order-address"><span>地址：'+res[i].details[j].address+'</span></p>\n' +
                            '                                    </div>\n' +
                            '                                </a>\n' +
                            '                            </li>';
                    }
                }
                htmlStr += '' +
                    '        </ul>\n' +
                    '        <div class="order-good-operate">\n' +
                    '            <span class="order-all">共'+a+'件商品</span><span class="order-total">合计：¥<em>'+res[i].amount+'</em></span>' +
                    '            <span class="order-btn">' ;

                htmlStr += '' +
                    // '               <button class="del" onclick="DeleteOrder('+res[i].id+')">删除</button>' +
                    '            </span>\n' +
                    '        </div>\n' +
                    '    </div>';
            }
            $("#order_list").append(htmlStr);
        },'json')
    }


    function DeleteOrder(id){
        if(confirm("确定删除订单？")){
            var url = "DeleteOrder";
            var data = {
                id:id
            };
            $.post(url,data,function(res){
                if(res.status == 1){
                    layer.msg("订单删除成功!",{time:1500},function(){
                        $("#order_"+id).remove();
                    })
                }else{
                    layer.msg("登录失效,请重新登录后操作!",{time:1500},function(){
                        window.location.reload();
                    })
                }
            },'json')
        }
    }
</script>
