<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>商品管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>商品管理</a>
            </li>
            <li>
                <strong>编辑商品</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="row rowtop" style="margin-top: 180px;">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="input-group" style="float: left;width: 40%;margin-top: 8px;">
                    <label>编辑商品</label>
                </div>
                <div class="ibox-tools">
                    <a><span class="btn btn-primary" onclick="SaveOne()">保存信息</span></a>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="ibox-content">
                <div class="edit_info">
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>名称：</span>
                        <input  id="name" class="form-control left cwidth" type="text" placeholder="请填写品牌名称" value="<?php
                        if (isset($one)) {
                            echo $one['name'];
                        }
                        ?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left"><span class="required">*</span>排序：</span>
                        <input  id="sort" class="form-control left cwidth" type="number" value="<?php
                        if (isset($one)) {
                            echo $one['sort'];
                        }
                        ?>">
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //修改资讯的id
    var id = "<?php
                                if (isset($one)) {
                                    echo $one['id'];
                                } else {
                                    echo '';
                                }
                        ?>";
    var ue = UE.getEditor('detail', {
        initialFrameHeight: 300
    });
    $(function () {
        $("body").click(function (e) {
            var idValue = $(e.target).attr("id");  //获取当前点击区域对象的id值
        })
    });
    function SaveOne() {
        var url = "SaveOne";
        var save = {};
        save.name = $('#name').val();
        save.sort = $('#sort').val();
        if (save.name == "") {
            layer.msg("请填写名称", {time: 1500});
            return;
        }
        if (save.sort == "") {
            save.sort = 99;
        }
        var data = {
            id: id,
            save: save
        };
        $.post(url, data, function (res) {
            if (res.status == 1) {
                layer.msg('保存成功！', {time: 1500}, function () {
                    window.location.href = "BrandList.html";
                });
            }
        }, "json");
    }
</script>