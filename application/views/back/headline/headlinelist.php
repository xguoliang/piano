<div class="right-down">
    <h1>头条列表</h1>
    <div class="khgl-search display1">
        <div class="display1" style="padding-left:2px;">
            <input type="text" placeholder="请输入关键词" id="title">
        </div>
        <button onclick="FetchCount()">搜索</button>
        <p onclick="AddOne()">
            <i><img src="<?php echo base_url() ?>assets/back/img/shang.png"></i>
            <span>添加头条</span>
        </p>
    </div>

    <!--客户管理-->
    <div class="khgl-list display1">
        <div class="khgl display1">
            <table id="table_id_example" class="display khgl-text" style="table-layout:fixed">
                <thead>
                <tr>
                    <th width="95">编号</th>
                    <th width="164">缩略图</th>
                    <th>标题</th>
                    <th width="205px">标签</th>
                    <th width="206px">发布时间</th>
                    <th width="232px">操作</th>
                </tr>
                </thead>
                <tbody id="headline_list"></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var com_id = "<?php if (isset($_SESSION['back_user'])) {
        echo $_SESSION['back_user']['com_id'];
    } else {
        echo '';
    } ?>";
    var hea_table = '';
    $(function () {
        FetchCount();
        $("#title").focus(function () {
            $(document).keypress(function (e) {
                if (e.which == 13) {
                    FetchCount();
                }
            })
        })
    });

    function FetchCount() {
        var url = "FetchCount";
        var data = {
            like: {
                title: $("#title").val()
            },
            equal: {
                company_id: com_id
            }
        };
        $.post(url, data, function (res) {
            if (hea_table != '') {
                hea_table.destroy();
            }
            var htmlStr = '';
            for (var i = 0; i < res.length; i++) {
                htmlStr += '' +
                    '<tr id="tr_' + res[i].id + '">\n' +
                    '                    <td>' + (i + 1) + '</td>\n' +
                    '                    <td class="picture">' +
                    '                       <i><img src="<?php echo base_url()?>' + (res[i].coverimg.split(',')[0]) + '"></i>' +
                    '                    </td>\n' +
                    '                    <td>' + res[i].title + '</td>\n' +
                    '                    <td>' + res[i].tag + '</td>\n' +
                    '\n' +
                    '                    <td>' + res[i].add_time + '</td>\n' +
                    '                    <td class="cz display1">\n' +
                    '                        <i onclick="AddOne(' + res[i].id + ')" class="iconfont icon-shanchu1"><span>编辑</span></i>\n' +
                    '                        <i onclick="DeleteOne(' + res[i].id + ')" class="iconfont icon-shenqingshenpi"><span>删除</span></i>\n' +
                    '                    </td>\n' +
                    '                </tr>';
            }
            $("#headline_list").html(htmlStr);
            hea_table = $('#table_id_example').DataTable({
                    "searching": false,     //搜索框去掉
                    bLengthChange: false,   //去掉每页显示多少条数据方法
                    "info": false,//底部文字去掉
                    "language": {
                        "paginate": {
                            "next": "下一页",
                            "previous": "上一页",
                        },

                    }
                }
            );
        }, 'json');
    }

    function AddOne(id) {
        window.location.href = "AddOne?id=" + id;
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
                    layer.msg(res.msg, {time: 1500}, function () {
                        if (res.status == 1) {
                            $("#tr_" + id).remove();
                        } else {
                            window.location.reload();
                        }
                    })
                }, 'json')
            },
            function () {
                layer.closeAll();
            }
        );
    }
</script>
