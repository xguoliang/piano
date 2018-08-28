<div class="news good">
    <div class="inside-title">
        <i class="back"></i>
        <p>消息</p>
    </div>
</div>
<!-- 头条start -->
<div class="newsdt">
    <h5 class="title"><?php echo $detail['title']; ?></h5>
    <div class="news-item-info">
        <span class="date"><?php echo explode(" ", $detail['add_time'])[0]; ?></span>
    </div>
    <div class="news-content">
        <p><?php echo $detail['desc']; ?></p>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>