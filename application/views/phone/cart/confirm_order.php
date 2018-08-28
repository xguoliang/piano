<div class="order good">
    <div class="inside-title">
        <i class="back"></i>
        <p>确认订单</p>
    </div>
</div>
<div class="order-confirminfo">
    <p class="order-confirm-costmer"><span>收货人：<input id="user_name" type="text" value="123"/></span><span><input id="phone" type="text" value="456"/></span></p>
</div>
<?php $count = 0;$amount = 0;?>
<?php foreach($orders as $k=>$v){?>
    <?php $price = 0;?>
    <div class="order-confirminfo">
        <div class="order-confirmhd">
            <a href="<?php echo base_url()?>User/Company/CompanyDetail.html?id=<?php echo $v['com_id']?>"><i class="iconfont icon-fuhao-shangdian"></i><span><?php echo $v['com_name']?></span></a>
        </div>
        <ul class="order-confirmlist">
            <?php foreach($v['details'] as $x=>$y){?>
                <?php $count += 1;$price += $y['price'] * $y['num'];?>
                <li>
                    <a href="<?php echo base_url()?>User/Product/ProductDetail?id=<?php echo $y['id']?>">
                        <div class="order-img">
                            <img src="<?php echo base_url().explode(',',$y['coverimg'])[0]?>" alt="">
                        </div>
                        <div class="order-txt">
                            <p><?php echo $y['name']?></p>
                        </div>
                        <div class="order-price">
                            <span>¥<?php echo $y['price']?></span>
                            <span>×<?php echo $y['num']?></span>
                        </div>
                    </a>
                </li>
            <?php }?>
            <?php $amount+=$price;?>
        </ul>
        <div class="order-allprice">
            <label>共<span><?php echo $count;?></span>件商品</label><label>小计：<span class="price">¥<?php echo $price?></span></label>
        </div>
    </div>
<?php }?>
<div class="order-sub">
    <button onclick="SubmitOrders()">提交订单</button><label>合计：<span>¥<?php echo $amount;?></span></label>
</div>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script>
    var orders = '<?php echo json_encode($orders)?>';
    orders =  eval('(' + orders + ')');
    function SubmitOrders(){
        var url = "MakeOrder"
        var data = {
            orders: orders,
            user_name: $("#user_name").val(),
            phone: $("#phone").val()
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
</script>
