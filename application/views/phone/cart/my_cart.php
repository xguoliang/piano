<div class="my-order good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p>购物车</p>
    </div>
    <div class="good-order-fenlei course-order-fenlei">
        <ul id="entity_type">
            <li class="active"><span>商品</span></li>
            <li><span>课程</span></li>
            <li><span>活动</span></li>
        </ul>
    </div>
</div>
<div class="my-shopdt" id="orders_list"></div>
<div class="my-shopclear">
    <button onclick="MakeOrder()">结算</button>
    <span class="money">合计：<em id="amount">￥0</em></span>
</div>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/js/underscore.js"></script>
<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>
<script>
    var nowpage = 1, p = 0, t = 0, page_limit = 5, entity_type = 1;
    var user_id = "<?php echo $_SESSION['lerenuser']['id']?>";
    $(function () {
        GetMyCartProduct();
        window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);
        $("#entity_type").find("li").click(function () {
            $("#orders_list").empty();
            nowpage = 1;
            t = 0;
            $(this).siblings("li").removeClass("active");
            $(this).addClass("active");
            entity_type = $(this).index() + 1;
            GetMyCartProduct();
        })
    });

    //判断滚动方向,上滚不触发
    function ScrollTo() {
        p = $(window).scrollTop();    //下拉高度  
        if (p >= t) {
            AddMore();
        }
    }

    function AddMore() {
        var range = 50;
        var totalheight = 0;
        var srollPos = $(window).scrollTop();    //下拉高度  
        t = srollPos;
        totalheight = parseFloat($(window).height()) + parseFloat(srollPos);

        if (($(document).height() - range) <= totalheight) {
            nowpage += 1;
            GetMyCartProduct();
        }
    }

    function GetMyCartProduct() {
        var url = 'FetchMyCartProduct';
        var data = {
            entity_type: entity_type
            , limit: page_limit
            , page: nowpage
        };
        $.post(url, data, function (res) {
            var htmlStr = '';
            for (var i = 0; i < res.length; i++) {
                htmlStr += '' +
                    '    <div class="shopdt com_content" com_id="'+res[i].com_id+'">\n' +
                    '        <div class="shopdt-hd">\n' +
                    '            <a href="store-page.html"><i class="iconfont icon-fuhao-shangdian"></i><span\n' +
                    '                        class="name">'+res[i].com_name+'</span></a><span class="operate" onclick="DeleteCart(this)">删除</span>\n' +
                    '        </div>\n' ;
                for(var j = 0;j<res[i].details.length;j++){
                    htmlStr += '' +
                        '        <div class="shopdt-bd cart_content" id="cart_'+res[i].details[i].cid+'">\n' +
                        '            <i cart_id="'+res[i].details[j].cid+'" class="iconfont icon-checkboxround0 check" onclick="CheckPro(this)" entity_id="'+res[i].details[j].entity_id+'"></i>\n' +
                        '            <div class="img">\n' +
                        '                <img src="<?php echo base_url()?>'+res[i].details[j].coverimg.split(',')[0]+'" alt="">\n' +
                        '            </div>\n' +
                        '            <div class="txt">\n' +
                        '                <p class="name">'+res[i].details[i].name+'</p>\n' +
                        '                <span class="num"><i class="iconfont icon-jian" onclick="NumChange(0,'+i+','+j+','+res[i].details[j].cid+')"></i><em id="pro_'+i+''+j+'">'+res[i].details[j].num+'</em><i onclick="NumChange(1,'+i+','+j+','+res[i].details[j].cid+')" class="iconfont icon-jia"></i></span>\n' +
                        '                <p class="price"><span>'+res[i].details[j].price+'元</span></p>\n' +
                        '            </div>\n' +
                        '        </div>\n' ;
                }

                htmlStr += '' +
                    '    </div>';
            }
            $("#orders_list").append(htmlStr);
        }, 'json')
    }


    function CheckPro(th){
        if($(th).hasClass('check')){
            $(th).removeClass("check").removeClass("icon-checkboxround0");
            $(th).addClass("checked").addClass("icon-checkboxround1");
        }else{
            $(th).removeClass("checked").removeClass("icon-checkboxround1");
            $(th).addClass("check").addClass("icon-checkboxround0");
        }
        CalCulateAmount();
    }

    function NumChange(a,b,c,id){
        var url = "SaveCart";
        var data = {
            id: id,
            sum: a
        };
        if(!a){
            if($("#pro_" + b + c).text() != '1'){
                $("#pro_" + b + c).text(parseInt($("#pro_" + b + c).text()) - 1)
                $.post(url,data,function(res){
                    if(res.status == 2){
                        layer.msg('登录失效，请重新登录后操作!',{time:1500});
                        return;
                    }

                    CalCulateAmount();
                },'json');
            }
        }else{
            $("#pro_" + b + c).text(parseInt($("#pro_" + b + c).text()) + 1)
            $.post(url,data,function(res){
                if(res.status == 2){
                    layer.msg('登录失效，请重新登录后操作!',{time:1500});
                    return;
                }

                CalCulateAmount();
            },'json');
        }

    }

    function DeleteCart(th){
        var url = "DeleteCart";
        var cart_ids = [];
        $(th).parents(".shopdt-hd").siblings(".cart_content").each(function(){
            if($(this).find(".checked").length>0){
                cart_ids.push($(this).attr('id').replace("cart_",""))
            }
        })

        if(cart_ids.length == 0){
            layer.msg('请先选中后删除!',{time:1500})
            return;
        }
        var data = {
            ids: cart_ids
        }
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg('删除成功',{time:1500},function(){
                    window.location.reload();
                });
            }else{
                layer.msg('登录失效，请重新登录后操作!',{time:1500},function(){
                    window.location.reload();
                })
            }
        },'json')
    }

    function CalCulateAmount(){
        var price = 0;
        $(".checked").each(function(){
            price += parseInt($(this).siblings(".txt").find("em").text()) * parseFloat($(this).siblings(".txt").find(".price").find("span").text().replace("元",""))
        })
        $("#amount").text("¥"+price);
    }

    function MakeOrder(){
        var url = "MakeOrder";
        var cart_id = '';
        $(".com_content").each(function(){
            $(this).find(".checked").each(function(){
                cart_id += $(this).attr('cart_id') + ',';
            })
        });
        if(cart_id == ''){
            layer.msg('请勾选后进行结算!',{time:1500});
            return;
        }
        cart_id = cart_id.slice(0,-1);
        window.location.href = "ConfirmOrder?cart_id="+ cart_id + '&entity_type='+entity_type;
    }
</script>
