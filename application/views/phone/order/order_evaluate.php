<?php foreach ($detail as $k => $v) { ?>
    <div class="eva_content" style="border:1px solid #e9e9e9;margin-bottom: 0.3rem;">
        <div class="assess-dt">
            <div class="assess-dt-hd" style="height:0.88rem;">
                <span><?php echo $v['name'] ?></span>
                <span style="display:none" class="pro_id"><?php echo $v['pro_id'] ?></span>
            </div>
        </div>
        <div class="my good">
            <div class="inside-title">
                <i class="back"></i>
                <a class="save" onclick="SaveEvaluate()">提交</a>
                <p>发表评价</p>
            </div>
        </div>
        <div class="assess-dt">
            <div class="assess-dt-hd star">
                <span>宝贝评分：</span>
                <a><img class="star_img" src="<?php echo base_url() ?>assets/img/phone/asse.png"/></a>
                <a><img class="star_img" src="<?php echo base_url() ?>assets/img/phone/asse.png"/></a>
                <a><img class="star_img" src="<?php echo base_url() ?>assets/img/phone/asse.png"/></a>
                <a><img class="star_img" src="<?php echo base_url() ?>assets/img/phone/asse.png"/></a>
                <a><img class="star_img" src="<?php echo base_url() ?>assets/img/phone/asse.png"/></a>
            </div>
            <div class="assess-dt-txt">
                <textarea name="" class="desc" placeholder="宝贝满足你的期待吗？说说它的优点和美中不足的地方吧！"></textarea>
            </div>
            <div class="assess-dt-img">
                <ul>
                    <li class="img" id="img<?php echo $k ?>">
                        <div class="assessimg assess-upload">
                    <span>
                        <i class="iconfont icon-camera1"></i>
                        <label id="img_num<?php echo $k ?>">0/9</label>
                        <input multiple type="file" name="files"
                               data-url="<?php echo base_url(); ?>index.php/Example/UploadImage?id=img<?php echo $k ?>&maker=evaluate">
                    </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>
<script src="<?php echo base_url() ?>assets/js/my.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.ui.widget.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.fileupload.js"></script>
<script type="text/javascript">
    var check = 0;//该变量是记录当前选择的评分
    var time = 0;//该变量是统计用户评价的次数，这个是我的业务要求统计的（改变评分不超过三次），可以忽略
    var order_id = "<?php echo $order_id?>";

    $(function () {
        UploadImg();
        $(".star_img").click(function () {
            var a = $(this).parents(".star").find(".star_img").index(this);
            var that = this;
            if ($(this).attr('src') == "<?php echo base_url()?>assets/img/phone/asse1.png") {
                $(this).parents(".star").find(".star_img").each(function (i) {
                    if (a <= i) {
                        $(this).attr('src', "<?php echo base_url()?>assets/img/phone/asse.png")
                    } else {
                        $(this).attr('src', "<?php echo base_url()?>assets/img/phone/asse1.png")

                    }
                })
            }
            if ($(this).attr('src') == "<?php echo base_url()?>assets/img/phone/asse.png") {
                $(this).parents(".star").find(".star_img").each(function (i) {
                    if (a >= i) {
                        $(this).attr('src', "<?php echo base_url()?>assets/img/phone/asse1.png")
                    } else {
                        $(this).attr('src', "<?php echo base_url()?>assets/img/phone/asse.png")

                    }
                })
            }

        });
    });

    function UploadImg() {
        $("input[type=file]").fileupload({
            done: function (e, result) {
                var resultJson = $.parseJSON(result.result);
                if (resultJson == 1) {
                    alert('上传失败');
                } else if (resultJson == 2) {
                    alert('文件类型错误');
                } else if (resultJson == 3) {
                    alert('文件太大');
                } else {
                    var img_num = $("#" + resultJson[0]).siblings("li").length + 1;
                    var a = resultJson[1].split('.');
                    var src = '<?php echo base_url(); ?>' + a[1] + '.' + a[2];
                    var htmlStr = '' +
                        ' <li>\n' +
                        '                <div class="assessimg">\n' +
                        '                    <i class="iconfont icon-htmal5icon19" onclick="RemoveImg(this)"></i>\n' +
                        '                    <span><img src="' + src + '" alt=""></span>\n' +
                        '                </div>\n' +
                        '            </li>'
                    $("#" + resultJson[0]).before(htmlStr);
                    $("#img_num" + resultJson[0].slice(3)).text(img_num + '/9')
                }
            },
            progress: function (e, data) {

            },
        });
    }

    function RemoveImg(th) {
        var img_num = $(th).parents("li").siblings("li:last").find("label").text().slice(0, 1);
        $(th).parents("li").siblings("li:last").find("label").text((parseInt(img_num) - 1) + '/9')
        $(th).parents("li").remove();
    }

    function SaveEvaluate() {
        var url = "SaveEvaluate";
        var save = {};
        var returnfalse = 0;
        $(".eva_content").each(function (i) {
            var a = 0;
            $(this).find(".star").find("img").each(function () {
                if ($(this).attr('src') == "<?php echo base_url()?>assets/img/phone/asse1.png") {
                    a++;
                }
            });
            var img = '';
            $(this).find(".img").siblings("li").each(function (i) {
                if (i != 0) {
                    img += ',';
                }
                img += $(this).find("img").attr('src').replace("<?php echo base_url()?>", "")

            });
            if (a == 0) {
                layer.msg("请选择星级", {time: 1500});
                return false;
                returnfalse = 1;

            }
            if ($(this).find(".desc").val() == '') {
                layer.msg("评价内容不能为空!", {time: 1500})
                return false;
                returnfalse = 1;
            }
            save[i] = {
                product_id: $(this).find(".pro_id").text(),
                order_id: order_id,
                star: a,
                desc: $(".desc").val(),
                img: img
            }
        });
        if(returnfalse){
            return;
        }
        var data = {
            id: order_id,
            save: save
        }

        $.post(url, data, function (res) {
            if (res.status == 1) {
                layer.msg("评价成功!", {time: 1500}, function () {
                    window.location.href = "OrderDetail?id=" + order_id;
                })
            } else {
                layer.msg("登录失败，请重新登录后操作!", {time: 1500}, function () {
                    window.location.href = "<?php echo base_url()?>User/Login/PLogin";
                })
            }
        }, 'json')
    }
</script>
