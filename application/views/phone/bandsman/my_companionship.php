<style>
    .partner-list ul li button{
        width: 1.2rem;
        height: .44rem;
        border: 1px solid #fba41f;
        color: #fba41f;
        float: right;
        font-size: .24rem;
        background: #fff;
        border-radius: .04rem;
        margin-left: .1rem;
    }
</style>
<div class="bandbuild good">
    <div class="inside-title">
        <i class="back"></i>
        <a class="band-build" href="PAddCampanionship.html"><i class="build-icon"></i><span>发起</span></a>
        <p>陪伴练习</p>
    </div>
    <div class="good-order-fenlei bandbuild-fenlei">
        <ul>
            <li class="active"><span>我发布的</span></li>
            <li><span>我申请的</span></li>
        </ul>
    </div>
</div>
<div class="partner-list" style="margin-top:0.2rem;">
    <ul>
        <?php foreach ($companionship as $data_item): ?>
            <li id="ali_<?php echo $data_item['id']; ?>">
                <p><a class="partner-name"><?php echo $data_item['name']; ?></a></p>
                <p><i class="time"></i><span>陪练时间:<?php echo $data_item['companionship_time']; ?></span></p>
                <p class="partner-add"><span><i class="add"></i><span><?php
                            $area = explode(' ', $data_item['area']);
                            if (isset($area[2])) {
                                echo $area[2];
                            } else {
                                echo $area[0];
                            }
                            ?></span><button onclick="deletes(<?php echo $data_item['id']; ?>)">删除</button><button onclick="chakan(<?php echo $data_item['id']; ?>)">查看</button><button onclick="changes(<?php echo $data_item['id']; ?>)">编辑</button></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="partner-list" style="display:none;margin-top:0.2rem;">
    <ul>
        <?php foreach ($apply as $data_item): ?>
            <li id="bli_<?php echo $data_item['id']; ?>">
                <p><a class="partner-name"><?php echo $data_item['name']; ?></a><a href="tel:<?php echo $data_item['phone']; ?>"><i class="tel"></i></a></p>
                <p><i class="time"></i><span>陪练时间:<?php echo $data_item['companionship_time']; ?></span></p>
                <p class="partner-add"><span><i class="add"></i><span><?php
                            $area = explode(' ', $data_item['area']);
                            if (isset($area[2])) {
                                echo $area[2];
                            } else {
                                echo $area[0];
                            }
                            ?></span><button><?php if ($data_item['status'] == 0) { ?>待处理<?php
                                } else if ($data_item['status'] == 1) {
                                    echo '已同意';
                                } else {
                                    echo '已拒绝';
                                }
                                ?></button><button onclick="cancel_apply(<?php echo $data_item['id']; ?>)">删除</button></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
                                    $('.bandbuild-fenlei').find('li').click(function () {
                                        if ($(this).hasClass('active') == false) {
                                            $('.bandbuild-fenlei').find('li').removeClass('active');
                                            $(this).addClass('active');
                                            $('.partner-list').hide();
                                            $('.partner-list').eq($(this).index()).show();
                                        }
                                    })
                                    function changes(id) {
                                        window.location.href = "PChangeCampanionship.html?id=" + id;
                                    }
                                    function chakan(id) {
                                        window.location.href = "PApplyMe.html?id=" + id;
                                    }
                                    function deletes(id) {
                                        if (confirm("确认删除吗")) {
                                            var url = "DeleteCampanionship";
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
                                    function cancel_apply(id) {
                                        if (confirm("确认删除吗")) {
                                            var url = "CancelCamponionshipApply";
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
</script>