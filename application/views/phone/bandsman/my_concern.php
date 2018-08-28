<div class="business good">
    <div class="inside-title">
        <i class="back"></i>
        <p>我的关注</p>
    </div>
    <div class="filterbar-container">
        <div class="filter-bar band">
            <ul>
                <li class="active">
                    <span>乐手</span>
                </li>
                <li>
                    <span>乐队</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 陪伴练习start -->
<div class="business-list my-attelist">
    <ul>
        <?php foreach ($bandsman as $data_item): ?>
            <li>
                <div class="business-img" style="border-radius:100%;overflow:visible;">
                    <a href=""><img src="<?php echo base_url() . $data_item['headimg']; ?>" alt="" style="height:100%;border-radius:100%;"></a>
                    <span class="business-span">乐手</span>
                </div>
                <div class="business-txt">
                    <p><a href="" class="business-name"></a><span class="bandsman"><?php echo $data_item['name']; ?></span></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="business-list my-attelist" style="display:none;">
    <ul>
        <?php foreach ($band as $data_item): ?>
            <li>
                <div class="business-img" style="border-radius:100%;overflow:visible;">
                    <a href=""><img src="<?php echo base_url() . $data_item['headimg']; ?>" alt="" style="height:100%;border-radius:100%;"></a>
                    <span class="business-span">乐队</span>
                </div>
                <div class="business-txt">
                    <p><a href="" class="business-name"><?php echo $data_item['name']; ?></a></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
    $('.band').find('li').click(function () {
        $('.my-attelist').hide();
        $('.my-attelist').eq($(this).index()).show();
    })
</script>