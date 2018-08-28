<div class="news good">
    <div class="inside-title">
        <i class="back"></i>
        <p>今日头条</p>
    </div>
</div>
<!-- 头条start -->
<div class="newsdt">
    <h5 class="title"><?php echo $one['title']; ?></h5>
    <div class="news-item-info">
        <span class="news-fenlei"><?php echo $one['tag']; ?></span><span class="date"><?php echo $one['time']; ?></span>
    </div>
    <div class="news-content">
        <?php
        $coverimg = explode(',', $one['coverimg']);
        for ($i = 0; $i < count($coverimg); $i++) {
            ?>
            <img src="<?php echo base_url() . $coverimg[$i]; ?>">
            <?php
        }
        echo $one['desc'];
        ?>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>