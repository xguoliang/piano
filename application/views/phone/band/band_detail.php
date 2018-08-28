<div class="bandbuild good">
    <div class="inside-title">
        <i class="back"></i>
        <i class="search"></i>
        <p></p>
    </div>
</div>
<div class="bandbuild-dt-hd">
    <div class="bandbuild-dt-img">
        <img src="<?php echo base_url() . $detail['headimg']; ?>" alt="">
    </div>
    <div class="bandbuild-dt-t">
        <h5><?php echo $detail['name']; ?></h5>
        <p>乐队成员：<?php echo count($member) + 1; ?></p>
    </div>
    <?php
    date_default_timezone_set('Asia/Shanghai');
    $now = (string) date("Y-m-d H:i:s");
    if ($now < $detail['end_time']) {
        ?>
        <div class="bandbuild-state">正在组建中...</div>
    <?php } else {
        ?>
        <div class="bandbuild-state">组建结束</div>
    <?php }
    ?>
</div>

</div>
<div class="bandbuild-dt-info">
    <div class="bandbuild-member">
        <span>乐队成员</span>
        <span>截止时间&nbsp;&nbsp;<?php echo $detail['end_time']; ?></span>
    </div>
    <ul class="member-list">
        <li>
            <a href="">
                <div class="member-img">
                    <img src="<?php echo base_url() . $chuangshi['headimg']; ?>" alt="">
                </div>
                <div class="member-txt">
                    <span class="name"><?php echo $chuangshi['name']; ?></span>
                    <span class="member-man"><?php echo $chuangshi['instrument_name']; ?></span>
                </div>
                <div class="bandbuild-ceo">创建人</div>
            </a>
        </li>
        <?php foreach ($member as $data_item): ?>
            <li>
                <a href="BandsmanDetail.html?id=<?php echo $data_item['bandsman_id']; ?>">
                    <div class="member-img">
                        <img src="<?php echo base_url() . $data_item['headimg']; ?>" alt="">
                    </div>
                    <div class="member-txt">
                        <span class="name"><?php echo $data_item['name']; ?></span>
                        <span class="member-man"><?php echo $data_item['instrument_name']; ?></span>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php if ($now < $detail['end_time']) { ?>
    <button class="join-band">立即加入</button>
<?php } ?>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>