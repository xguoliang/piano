<div class="my-order good">
    <div class="inside-title">
        <i class="back"></i>
        <p>商品订单详情</p>
    </div>
</div>
<div class="order-buy-info">
    <div class="good-orderdt-hd">
        <span>买家信息</span>
    </div>
    <div class="good-order-info">
        <p>买家昵称：<?php echo $order['user_name']?></p>
        <p>联系电话：<?php echo $order['phone']?></p>
    </div>
</div>
<div class="good-order-dt">
    <div class="good-orderdt-hd">
        <span>订单详情</span>
        <span class="order-state">
            <?php if($order['status'] == 1){?>
                待付款
            <?php }else if($order['status'] == 2){?>
                待提货
            <?php }else if($order['status'] == 3 && $order['is_evaluate'] == 0){?>
                待评价
            <?php }else if($order['status'] == 3 && $order['is_evaluate'] == 1){?>
                已完成
            <?php }?>
        </span>
    </div>
    <div class="good-order-info">
        <p>订单编号：<?php echo $order['order_no']?></p>
        <?php if($order['is_pay'] == 1){?>
        <p>交易单号：<?php echo $order['pay_no']?></p>
        <?php }?>
        <p>创建时间：<?php echo $order['add_time']?></p>
        <?php if($order['is_pay'] == 1){?>
        <p>付款时间：<?php echo $order['pay_time']?></p>
        <?php }?>
    </div>
    <ul class="order-dt-list">
        <?php $a=0;?>
        <?php foreach($details as $k=>$v){?>
            <?php $a += $v['num'];?>
            <li>
                <a href="<?php echo base_url()?>User/Product/ProductDetail?id=<?php echo $v['pro_id']?>">
                    <div class="order-img">
                        <img src="<?php echo base_url().explode(',',$v['coverimg'])[0]?>" alt="">
                    </div>
                    <div class="order-txt">
                        <p class="order-good"><?php echo $v['name']?></p>
                        <p class="order-goodnum"><span>¥<?php echo $v['price']?>/件</span><span>×<?php echo $v['num']?></span></p>
                    </div>
                </a>
            </li>
        <?php }?>
    </ul>
    <div class="order-good-operate sell-operate">
        <span class="order-all">共<?php echo $a;?>件商品</span><span class="order-total">合计：¥<em><?php echo $order['price'];?></em></span><span class="order-btn"></span>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>