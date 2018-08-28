<div class="bandbuild good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="band-build" href="PAddBand.html"><i class="build-icon"></i><span>发起</span></a>
        <p>乐队组建</p>
    </div>
    <div class="good-order-fenlei bandbuild-fenlei">
        <ul>
            <li class="active"><span>我发布的</span></li>
            <li><span>我申请的</span></li>
        </ul>
    </div>
</div>
<!-- 乐队组建start -->
<!-- 我发布的 -->
<div class="bandbuild-list my-bandbuild">
    <ul>
        <?php foreach ($band as $data_item): ?>
            <li id="bli_<?php echo $data_item['id']; ?>">
                <p><a class="band-name" href=""><?php echo $data_item['name']; ?></a></p>
                <div class="need-member">
                    <h5>需要成员：</h5>
                    <p><span><?php echo $data_item['need']; ?></span></p>
                </div>
                <p class="bandbuild-date"><span><?php echo explode(' ', $data_item['add_time'])[0]; ?></span><button onclick="delete_band(<?php echo $data_item['id']; ?>)">解散</button><button onclick="javascript:window.location.href = 'BandMember.html?id=<?php echo $data_item['id']; ?>'">查看</button><button onclick="changes(<?php echo $data_item['id']; ?>)">编辑</button></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<!-- 我申请的 -->
<div class="bandbuild-list my-bandbuild" style="display:none;">
    <ul>
        <?php foreach ($apply as $data_item): ?>
            <li id="ali_<?php echo $data_item['id']; ?>">
                <p><a class="band-name" href=""><?php echo $data_item['name']; ?></a><span class="band-state"><?php if ($data['status'] == 0) { ?>正在组建中...<?php
                        } else if ($data['status'] == 1) {
                            echo '已加入';
                        } else {
                            echo '已拒绝';
                        }
                        ?></span></p>
                <div class="need-member">
                    <h5>需要成员：</h5>
                    <p><span><?php echo $data_item['need']; ?></span></p>
                </div>
                <p class="bandbuild-date"><span><?php echo explode(' ', $data_item['add_time'])[0]; ?></span><button onclick="delete_apply(<?php echo $data_item['id']; ?>)">删除</button><button class="bandbuild-state">待处理</button></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<!-- 乐队组建end -->
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
                $(".bandbuild-fenlei").find("li").click(function () {
                    if ($(this).hasClass('active') == false) {
                        $(".bandbuild-fenlei").find("li").removeClass('active');
                        $(this).addClass("active");
                        $('.my-bandbuild').hide();
                        $('.my-bandbuild').eq($(this).index()).show();
                    }
                })
                function changes(id) {
                    window.location.href = "PChangeBand.html?id=" + id;
                }
                function delete_band(id) {
                    if (confirm("确认解散吗")) {
                        var url = "DeleteBand";
                        $.ajax({
                            type: "post",
                            url: url,
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function (data, textStatus) {
                                $('#bli_' + id).remove();
                            }
                        });
                    }
                }
                function delete_apply(id) {
                    if (confirm("确认删除吗")) {
                        var url = "DeleteApply";
                        $.ajax({
                            type: "post",
                            url: url,
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function (data, textStatus) {
                                $('#ali_' + id).remove();
                            }
                        });
                    }
                }
</script>