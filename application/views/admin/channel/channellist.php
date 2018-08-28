<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>频道管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>频道管理</a>
            </li>
            <li>
                <strong>频道管理</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="padding: 14px 20px 10px;">
                    <div class="ibox-tools">
                        <a><span class="btn btn-primary" onclick="AddOne()">添加频道</span></a>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="ibox-content" style="padding: 15px 40px 20px 40px;">
                    <table class="table table-striped table-bordered table-hover dataTables-example nowarp"
                           style="text-align: center;">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>名称</th>
                            <th>图片</th>
                            <th>排序</th>
                            <th>简介</th>
                            <th>链接</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="channel_list"></tbody>
                    </table>
                    <div style="text-align: center;">
                        <div id="channel_list_page"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var nowpage = 1;
    $(function () {
        FetchCount();
    });
    //搜索
    $("#search").click(function () {
        FetchCount();
    });

    function FetchCount() {
        var data = {};
        var url = 'FetchCount';
        $.post(url, data, function (res) {
            layui.use(['laypage'], function () {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'channel_list_page',
                    count: res,
                    layout: ['count', 'prev', 'page', 'next'],
                    jump: function (obj) {
                        FetchPageData(obj.limit, obj.curr);
                    }
                });
            });
        }, "json");
    }

    function FetchPageData(limit, page) {
        nowpage = page;
        var url = 'FetchPageData';
        var data = {
            limit: limit,
            page: page
        };
        $.post(url, data, function (res) {
            var HtmlStr = '';
            for (var i = 0; i < res.length; i++) {
                HtmlStr += '' +
                    '<tr id="tr_' + res[i].id + '">' +
                    '    <td>' + (i + 1) + '</td>' +
                    '    <td>' + res[i].name + '</td>' +

                    '    <td><img style="width:60px;" src="<?php echo base_url()?>' + res[i].img + '"></td>' +
                    '    <td><input onblur="SaveSort(' + res[i].id + ',this)" type="number" value="' + res[i].sort + '"></td>' +
                    '    <td>' + res[i].desc + '</td>' +
                    '    <td>' + res[i].link + '</td>' +
                    '    <td class="operate">' +
                    '       <span class="btn btn-primary"  onclick="AddOne(' + res[i].id + ')">编辑</span>' +
                    '       <span class="btn btn-danger"  onclick="DeleteOne(' + res[i].id + ')">删除</span>' +
                    '    </td>' +
                    '</tr>';
            }
            $("#channel_list").html(HtmlStr);
        }, "json");
    }

    function AddOne(id = '') {
        window.location.href = "<?php echo base_url() ?>index.php/Admin/Channel/AddOne?id=" + id;
    }

    function ChangeLink(id, th) {
        if ($(th).text() == '是') {
            var is_link = 0;
            var str = '否';
        } else {
            var is_link = 1;
            var str = '是';
        }
        var url = "SaveOne";
        var data = {
            id: id,
            save: {
                is_link: is_link
            }
        }
        $.post(url, data, function (res) {
            if (res.status == 1) {
                layer.msg('保存成功', {time: 1500}, function () {
                    $(th).text(str);
                });
            } else {
                layer.msg('登录失效，请重新登录后操作!', {time: 1500}, function () {
                    window.location.href = "<?php echo base_url()?>Admin/Login/Login";
                })
            }
        }, 'json')
    }

    function SaveSort(id, th) {
        var url = "SaveOne";
        var data = {
            id: id,
            save: {
                sort: $(th).val()
            }
        };
        $.post(url, data, function (res) {
            if (res.status == 1) {
                layer.msg('保存成功', {time: 1500});
            } else {
                layer.msg('登录失效，请重新登录后操作!', {time: 1500}, function () {
                    window.location.href = "<?php echo base_url()?>Admin/Login/Login";
                })
            }
        }, 'json')
    }

    function DeleteOne(id) {
        layer.confirm("确定删除?", {btn: ['确定', '取消']}
            , function () {
                var url = "DeleteOne";
                var data = {
                    equal: {
                        id: id
                    }
                };
                $.post(url, data, function (res) {
                    if (res.status == 1) {
                        layer.msg("删除成功!", {time: 1500}, function () {
                            $("#tr_" + id).remove();
                        })
                    } else {
                        layer.msg('登录失效，请重新登录后操作!', {time: 1500}, function () {
                            window.location.href = "<?php echo base_url()?>Admin/Login/Login";
                        })
                    }
                }, 'json')
            }, function () {
                layer.closeAll();
            }
        )
    }
</script>