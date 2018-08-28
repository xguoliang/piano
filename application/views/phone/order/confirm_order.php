<div class="order good">
    <div class="inside-title">
        <i class="back"></i>
        <p>确认订单</p>
    </div>
</div>
<div class="order-confirminfo">
    <p class="order-confirm-costmer"><span>收货人：<input id="user_name" type="text" value="123"/></span><span><input id="phone" type="text" value="456"/></span></p>
</div>
    <div class="order-confirminfo">
        <div class="order-confirmhd">
            <a href="<?php echo base_url()?>User/Company/CompanyDetail.html?id=<?php echo $company['id']?>"><i class="iconfont icon-fuhao-shangdian"></i><span><?php echo $company['name']?></span></a>
        </div>
        <ul class="order-confirmlist">
                <li>
                    <?php if($one['entity_type'] == 1){?>
                    <a href="<?php echo base_url()?>User/Product/ProductDetail?id=<?php echo $one['id']?>">
                    <?php }else if($one['entity_type'] == 2){?>
                    <a href="<?php echo base_url()?>User/Lesson/LessonDetail?id=<?php echo $one['id']?>">
                    <?php }else{?>
                    <a href="<?php echo base_url()?>User/Activity/ActivityDetail?id=<?php echo $one['id']?>">
                    <?php }?>
                        <div class="order-img">
                            <img src="<?php echo base_url().explode(',',$one['coverimg'])[0]?>" alt="">
                        </div>
                        <div class="order-txt">
                            <p><?php echo $one['name']?></p>
                        </div>
                        <div class="order-price">
                            <span>¥<?php echo $one['price']?></span>
                            <span>×<?php echo $one['num']?></span>
                        </div>
                    </a>
                </li>
        </ul>
        <div class="order-allprice">
            <label>共<span><?php echo $one['num'];?></span>件商品</label><label>小计：<span class="price">¥<?php echo $one['price']*$one['num']?></span></label>
        </div>
    </div>
<div class="order-sub">
    <button onclick="SubmitOrders()">提交订单</button><label>合计：<span>¥<?php echo $one['price']*$one['num'];?></span></label>
</div>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script>
    var pro_id = "<?php echo $one['id']?>",
        com_id = "<?php echo $company['id']?>",
        num = "<?php echo $one['num']?>",
        entity_type = "<?php echo $one['entity_type']?>",
        price = "<?php echo $one['price']?>"

    function SubmitOrders(){
        var url = "MakeOrder"
        var data = {
            order:{
                company_id: com_id,
                entity_type: entity_type,
                price: num*price,
                user_name: $("#user_name").val(),
                phone: $("#phone").val(),
            },
            order_detail:{
                entity_id: pro_id,
                price: price,
                num: num
            }
        }
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg('订单生成成功',{time:1500},function(){
                    ChoosePay1(res.order_sign_no);
                })
            }else{
                layer.msg('登录失效,请重新登录后操作!',{time:1500})
            }
        },'json')
    }

    function in_wechat(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }
</script>
