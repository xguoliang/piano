<?php

$url = urlencode($urls);
echo '<script>window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $url . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";</script>';
?>