<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>品牌管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>品牌管理</a>
            </li>
            <li>
                <strong>品牌管理</strong>
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
                        <input id="name" type="text" placeholder="请输入品牌名称" class="input-sm form-control"
                               style="width: 200px;height: 32px">
                    </div>
                    <div class="ibox-tools">
                        <a><span class="btn btn-primary" onclick="AddOne()">添加品牌</span></a>
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
                            <th>操作</th>
                        </tr>
                        
                        </thead>
                        <tbody id="brand_list"></tbody>
                    </table>
                    <div style="text-align: center;">
                        <div id="brand_list_page"></div>
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
        var equal = {
            is_delete: 0
        };
        var data = {
            like: like,
            equal: equal
        };
        var url = 'FetchCount';
        $.post(url, data, function (res) {
            layui.use(['laypage'], function () {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'brand_list_page',
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
        var equal = {
            is_delete: 0
        };
        var data = {
            equal: equal,
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
                    '    <td class="operate">' +
                    '       <span class="btn btn-primary"  onclick="AddOne(' + res[i].id + ')">编辑</span>' +
                    '       <span class="btn btn-danger"  onclick="DeleteOne(' + res[i].id + ')">删除</span>' +
                    '    </td>' +
                    '</tr>';
            }
            $("#brand_list").html(HtmlStr);
        }, "json");
    }

    function AddOne(id = '') {
        window.location.href = "<?php echo base_url() ?>Admin/Brand/AddOne?id=" + id;
    }

    function DeleteOne(id = '') {
        layer.confirm("确认删除?",{btn:["确定","取消"]}
            ,function(){
                var url = 'SaveOne';
                var save = {
                    is_delete: 1
                };
                var data = {
                    id: id,
                    save: save
                };
                $.post(url, data, function (res) {
                    layer.msg(res.msg, {time: 1500}, function () {1
                        $("#tr_"+id).remove();
                        // FetchPageData(10, nowpage);
                    })
                }, 'json')
            }
            ,function(){
                layer.closeAll();
            }
        );
    }
</script>