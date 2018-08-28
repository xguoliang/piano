<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/phone/video-js.css">
<style>
    .video-js{
        width: 100%!important;
    }
</style>
<div class="business good">
    <div class="inside-title">
        <i class="back"></i>
        <p>我的作品</p>
    </div>
    <div class="good-order-fenlei music-fenlei">
        <ul>
            <li class="active"><span>音乐</span></li>
            <li><span>视频</span></li>
        </ul>
    </div>
</div>
<!-- 音乐视频start -->
<div class="music-list works_list">
    <ul>
        <?php
        foreach ($works as $data_item):
            if ($data_item['type'] == 1) {
                ?>
                <li>
                    <i class="iconfont icon-yinlemusic214"></i>
                    <div class="music-info">
                        <p class="name"><?php echo $data_item['name']; ?></p>
                        <p class="date"><?php echo explode(' ', $data_item['add_time'])[0]; ?></p>
                    </div>
                    <span>
                        <i class="iconfont icon-bofang3" onclick="changes(<?php echo $data_item['id']; ?>)"></i>
                        <i class="iconfont icon-xiazai" onclick="deletes(<?php echo $data_item['id']; ?>)"></i>
                    </span>
                </li>
                <?php
            }
        endforeach;
        ?>
    </ul>
    <a href="PAddWorks.html" style="display: block;width: 4rem;height:0.8rem;background:#FBA41F;margin:1rem auto;text-align: center;line-height: 0.8rem;font-size:0.3rem;color:#fff;">添加作品</a>
</div>
<div class="media-list works_list" style="display:none;">
    <ul>
        <?php
        foreach ($works as $data_item):
            if ($data_item['type'] == 2) {
                ?>
                <li id="li_<?php echo $data_item['id']; ?>">
                    <div class="video-info">
                        <video id="my-video" class="video-js video-about" controls preload="auto"  data-setup="{}">
                            <source src="<?php echo base_url() . $data_item['url']; ?>" type='video/mp4'>
                        </video>
                        <div class="video-txt">
                            <div class="video-txt-info">
                                <p class="name"><?php echo $data_item['name']; ?></p>
                                <p class="date"><?php echo $data_item['add_time']; ?></p>
                            </div>
                            <div class="video-down">
                                <i class="iconfont icon-bofang3" onclick="changes(<?php echo $data_item['id']; ?>)"></i>
                                <i class="iconfont icon-xiazai" onclick="deletes(<?php echo $data_item['id']; ?>)"></i>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        endforeach;
        ?>
    </ul>
    <a href="PAddWorks.html" style="display: block;width: 4rem;height:0.8rem;background:#FBA41F;margin:1rem auto;text-align: center;line-height: 0.8rem;font-size:0.3rem;color:#fff;">添加作品</a>
</div>
<script src="<?php echo base_url(); ?>assets/js/video.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
                            $('.music-fenlei').find('li').click(function () {
                                if ($(this).hasClass('active') == false) {
                                    $('.music-fenlei').find('li').removeClass('active');
                                    $(this).addClass('active');
                                    $('.works_list').hide();
                                    $('.works_list').eq($(this).index()).show();
                                }
                            })
                            function changes(id) {
                                window.location.href = "PChangeWorks.html?id=" + id;
                            }
                            function deletes(id) {
                                if (confirm("确认删除吗")) {
                                    var url = "DeleteWorks";
                                    $.ajax({
                                        type: "post",
                                        url: url,
                                        data: {
                                            id: id
                                        },
                                        dataType: "json",
                                        success: function (data, textStatus) {
                                            $('#li_' + id).remove();
                                        }
                                    });
                                }
                            }
</script>