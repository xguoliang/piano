<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>设备租赁</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>设备租赁</a>
            </li>
            <li>
                <strong>设备租赁</strong>
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
                    <div class="input-group" style="float: left;width: 40%;">
                        <span class="input-group-btn">
                            <button id="search" type="button" class="btn btn-sm btn-primary"
                                    style="height: 32px">搜索</button> </span>
                        <input id="name" type="text" placeholder="请输入乐队名称" class="input-sm form-control"
                               style="width: 200px;height: 32px">
                    </div>
<!--                    <div class="ibox-tools">-->
<!--                        <a><span class="btn btn-primary" onclick="AddOne()">添加乐队</span></a>-->
<!--                    </div>-->
                    <div style="clear: both;"></div>
                </div>
                <div class="ibox-content" style="padding: 15px 40px 20px 40px;">
                    <table class="table table-striped table-bordered table-hover dataTables-example nowarp"
                           style="text-align: center;">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>名称</th>
                            <th>封面图</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>价格</th>
                            <th>电话</th>
                        </tr>
                        </thead>
                        <tbody id="lease_list"></tbody>
                    </table>
                    <div style="text-align: center;">
                        <div id="lease_list_page"></div>
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
        $("#name").focus(function () {
            $(document).keypress(function (e) {
                // 回车键事件
                if (e.which == 13) {
                    FetchCount();
                }
            });
        });
    });
    //搜索
    $("#search").click(function () {
        FetchCount();
    });

    function FetchCount() {
        var like = {
            name: $("#name").val()
        };
        var data = {
            like: like,
        };
        var url = 'FetchCount';
        $.post(url, data, function (res) {
            layui.use(['laypage'], function () {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'lease_list_page',
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
        var like = {
            name: $("#name").val()
        };
        var data = {
            like: like,
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
                    '    <td>' + res[i].coverimg + '</td>' +
                    '    <td>' + res[i].start_time + '</td>' +
                    '    <td>' + res[i].end_time + '</td>' +
                    '    <td>' + res[i].money + '</td>' +
                    '    <td>' + res[i].phone + '</td>' +
                    '</tr>';
            }
            $("#lease_list").html(HtmlStr);
        }, "json");
    }

    function AddOne(id = '') {
        //window.location.href = "<?php //echo base_url() ?>//index.php/Admin/leasesman/AddOne?id=" + id;
    }
</script>