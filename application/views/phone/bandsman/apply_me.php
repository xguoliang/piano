<div class="bandbuild good">
    <div class="inside-title">
        <i class="back"></i>
        <p>陪伴邀请</p>
    </div>
</div>
<div class="partner-member">
    <h5>未处理陪伴邀请：</h5>
    <ul class="partner-memberlist1">
        <?php
        foreach ($apply as $data_item):
            if ($data_item['status'] == 0) {
                ?>
                <li id="li_<?php echo $data_item['id']; ?>">
                    <div class="partner-memberimg">
                        <a><img src="<?php echo base_url() . $data_item['bandsman']['headimg']; ?>" alt=""></a>
                    </div>
                    <div class="partner-membertxt">
                        <p><a class="partner-membername"><?php echo $data_item['bandsman']['name']; ?></a><span><?php echo $data_item['bandsman']['instrument_name']; ?>陪练</span></p>
                        <p><span><?php echo $data_item['bandsman']['instrument_name']; ?></span><span class="band-memberbtn"><button class="yes" onclick="agrees(<?php echo $data_item['id']; ?>)">接受</button><button class="no" onclick="deny(<?php echo $data_item['id']; ?>)">拒绝</button></span></p>
                    </div>
                </li>
                <?php
            }
        endforeach;
        ?>
    </ul>
    <h5>已接受陪伴邀请：</h5>
    <ul class="partner-memberlist1">
        <?php
        foreach ($apply as $data_item):
            if ($data_item['status'] == 1) {
                ?>
                <li>
                    <div class="partner-memberimg">
                        <a><img src="<?php echo base_url() . $data_item['bandsman']['headimg']; ?>" alt=""></a>
                    </div>
                    <div class="partner-membertxt">
                        <p><a class="partner-membername"><?php echo $data_item['bandsman']['name']; ?></a><span><?php echo $data_item['bandsman']['instrument_name']; ?>陪练</span></p>
                        <p><span><?php echo $data_item['bandsman']['instrument_name']; ?></span><span class="band-memberbtn"><button class="yes">已接受</button></span></p>
                    </div>
                </li>
                <?php
            }
        endforeach;
        ?>
    </ul>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
                    function agrees(id) {
                        if (confirm("确认接受吗")) {
                            var url = "AgreeCampanionshipApply";
                            $.ajax({
                                type: "post",
                                url: url,
                                data: {
                                    id: id
                                },
                                dataType: "json",
                                success: function (data, textStatus) {
                                    window.location.reload();
                                }
                            });
                        }
                    }
                    function deny(id) {
                        if (confirm("确认拒绝吗")) {
                            var url = "DenyCampanionshipApply";
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