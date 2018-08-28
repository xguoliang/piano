<?php

$config = array(
    //最大查询重试次数
    'MaxQueryRetry' => "10",
    //查询间隔
    'QueryDuration' => "3",
    //应用ID,您的APPID。
    'app_id' => "2018010201523940",
    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEAu9HbIRD0ddCzqoZTMQeIOE2bZ/tkEhSzef2i3u3FjkYCGhF2Dce3T30mGBSvGTZdP5vfPsZxz/LW/TOh2+Bb7utPLsZdMMM9N6DqNW64HpN7SgSV5LzMwxVAQVIaIOYmKq4gd1jhRmYRoc7cdP8ycIs52c6E3FgZHMBgFYtJWfk6a97BKgHgbYW/3N9VSnflR2MhhOTacf70b7qLkyzue5wYNxfqO0QoGSyBRMMZGjMVS3FmIqshNw5LTvCdANdJVlfplE1DNrj8QRYn5KAjHpulnDALgOnQk7gmcJeCFAIjOOqF7VmLJnQ4rQAsgT836apFhcIp7TMtRl9rK03AvwIDAQABAoIBAC9r3frsT/zLNAHTJoATmcY1eg53/509Es+zRYMp3557eJ5iWD9EdLkiLRMZbdhczJB555Tu/990PenyNmTQsgWR7g0uUms0cGlyPJA/I0e9DvzySXJWZRDAddfIRgaWdX6DNnlLvJ1MuhjzpN/5ax/VV0byCMOljrmerOPjpiKMBtmqjZoEg0VEKeU7xVfoweiC31WN5pbabu/Dfgaxs5b8m2aBtWWsmxXvNkJ8wWxtpIlVXE/2Z7qHIMzipyPNPkVcqJPj4Lzb6gqN6aSon4Woui7135TbhsfpLfnAFkIRdQZUk3X999yMDt+tumQmoOqfO59Ep/RC9yXfMoXtygECgYEA566m2mwa3htUEDqw2l/2ZGJ/p00J737u0slGdKTIqc097Szpj7oxmG0U3TdmmpX4pDJ+cAequnefIsr6db4IjZla5eyor/C4A54W+rtdtfbkBKQUlbY2CGosbQU4w2+YrCa0KfH/YKMhzR3yuL5PioraYLK4G1Hl904MH8xRib8CgYEAz4icRgjrfcC2eMxAqksfCGqnqyl+jZ3BTz2NivIru4joyHTOW2FPcZKXZeTfjRZh8KQ0tBXapCdPLKlZHxnFtmwbSshLl2SQh2l90dOXi6TvtsHdYbrfqdkBAyfac4sPLKiU+9H9yl4hdpAUbbbSc4kbkxkuTWew+j0avdL7iQECgYEAqR/cm3vpDRQEBKjjazY8JkGlEBrz0snlSyg073dPKG0z9Iwhn5L7G1sdrPMBSn2J+UsG838VSXODTqG/ve3QTpWRPmDJL05Y9gMUoUnfebLV9vFUOYm+3durvJXgPwKa/6htQmVu2DudtB9VjTkX1XnROl+ceA0MA8EMprW/G/8CgYAlfxhFKx1pRiVx4+2XFyWPPr32lfOwoJ0ptQRa43B1XMI6XahfKFDTQ1opZdXiRvYBJZoEI6KyYAvVFO/uR5jKYfP4agIGY3wdizjZbXKHH5DUI2jdXIdGx9d/+3Zjw+9E8Vyhtwo0wxcmtdeLDyotB8u8oyMThzWZsOqg+3rJAQKBgHTj3lDhkwCQLH/fa2QHV0DijhMj6869YUNwopSf0ycVNT85i5sU+0p5DAL9nBRuQz05ZKJuYR5hctHcbNAv+J8tpIKaWWLOl9tEdYule2i9r/GkXxChLC35M39mNgAu6m7jcGgwgu6VYEpX5P99kP3nStvz0B5NRo7tLXiLbkEv",
    //异步通知地址
    'notify_url' => "http://www.zhiweihome.com/zhixiu/intern/job/ali_notify.php",
    //同步跳转
    'return_url' => "http://www.zhiweihome.com/zhixiu/intern/job/index.php/User/Info/MyOrder",
    //编码格式
    'charset' => "UTF-8",
    //签名方式
    'sign_type' => "RSA2",
    //支付宝网关
    'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2SmaSD0I+OJmOS8eoQgSOA2jT641uDx5PmGbbKPwbyYqMj2VB1mVaWQE5X9EqvpJb9HnbWObiGkZCbYLAkWJ2JKImoL+yprCfYUesTi96F/R/1abES8RCyw/oEvb7nAzIb5gIiIEojXSeR04YvHMsy22J1VX5SJvLyXr7NYKOPAtgQUd72vyhuCdoH1jJzdgQtOnfzvj1hRdCg4l7BjK62ngh95FtVHVS/PzP5t9LPqtPaC4DiJE8yf/DTxY8WjytubSev1JvfuKbRVXQEAaHdqyHQ5QSldISA15Y/nane1aDlYSyRCsZgRMdSWMZw/bEXy+H+AuG76UG6a717AJswIDAQAB",
);
