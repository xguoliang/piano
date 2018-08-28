<div class="bandbuild good">
    <div class="inside-title">
        <i class="back"></i>
        <p>乐队成员</p>
    </div>
</div>
<div class="band-member">
    <h5>未处理成员：</h5>
    <ul class="band-memberlist1">
        <?php foreach ($apply as $data_item): ?>
            <li>
                <span class="band-memberimg">
                    <a href=""><img src="<?php echo base_url() . $data_item['headimg']; ?>" alt=""></a>
                </span>
                <a href=""><span class="band-membername"><?php echo $data_item['name']; ?></span></a>
                <span class="band-memberfenlei"><?php echo $data_item['instrument_name']; ?></span>
                <span class="band-memberbtn">
                    <button class="yes" onclick="agrees(<?php echo $data_item['band_id']; ?>,<?php echo $data_item['bandsman_id']; ?>)">接受</button>
                    <button class="no" onclick="deny(<?php echo $data_item['band_id']; ?>,<?php echo $data_item['bandsman_id']; ?>)">拒绝</button>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
    <h5>已有成员：</h5>
    <ul class="band-memberlist1">
        <li>
            <span class="band-memberimg">
                <a><img src="<?php echo base_url() . $me['headimg']; ?>" alt=""></a>
            </span>
            <a><span class="band-membername"><?php echo $me['name']; ?></span></a>
            <span class="band-memberfenlei"><?php echo $me['instrument_name']; ?></span>
        </li>
        <?php foreach ($bandsman as $data_item): ?>
            <li>
                <span class="band-memberimg">
                    <a><img src="<?php echo base_url() . $data_item['headimg']; ?>" alt=""></a>
                </span>
                <a><span class="band-membername"><?php echo $data_item['name']; ?></span></a>
                <span class="band-memberfenlei"><?php echo $data_item['instrument_name']; ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="mask">
    <div class="cover-floor "></div>
</div>
<script src="<?php echo base_url(); ?>assets/js/my.js"></script>
<script>
                    function agrees(band_id, bandsman_id) {
                        if (confirm("确认接受该乐手吗")) {
                            var url = "AgreeBandMember";
                            $.ajax({
                                type: "post",
                                url: url,
                                data: {
                                    band_id: band_id,
                                    bandsman_id: bandsman_id
                                },
                                dataType: "json",
                                success: function (data, textStatus) {
                                    window.location.reload();
                                }
                            });
                        }
                    }
                    function deny(band_id, bandsman_id) {
                        if (confirm("确认拒绝该乐手吗")) {
                            var url = "DenyBandMember";
                            $.ajax({
                                type: "post",
                                url: url,
                                data: {
                                    band_id: band_id,
                                    bandsman_id: bandsman_id
                                },
                                dataType: "json",
                                success: function (data, textStatus) {
                                    window.location.reload();
                                }
                            });
                        }
                    }
</script>