<div class="right-down">
    <h1>商品列表</h1>
    <div class="khgl-search display1">
        <select>
            <option>全部商品</option>
        </select>
        <div class="display1">
            <input id="name" type="text" placeholder="请输入乐器名称搜索">
        </div>
        <button onclick="FetchCount()">搜索</button>
        <p onclick="window.location.href='AddOne'">
            <i><img src="<?php echo base_url() ?>assets/back/img/shang.png"></i>
            <span>添加商品</span>
        </p>
    </div>
    <!--客户管理-->
    <div class="khgl-list display1">
        <div class="khgl display1">
            <table id="table_id_example" class="display khgl-text" style="table-layout:fixed">
                <thead>
                    <tr>
                        <th width="95">编号</th>
                        <th width="164">头像</th>
                        <th width="275">名称</th>
                        <th width="150">品牌</th>
                        <th width="150">类别</th>
                        <th width="150">发布时间</th>
                        <th width="200">操作</th>
                    </tr>
                </thead>
                <tbody id="product_list"></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var pro_table = '';
    var com_id = "<?php if (isset($_SESSION['back_user'])) {
        echo $_SESSION['back_user']['com_id'];
    } else {
        echo '';
    }?>";
    $(function () {
        FetchCount();
        $("#name").focus(function(){
            $(document).keypress(function(e){
                if(e.which == 13){
                    FetchCount();
                }
            })
        });

    });

    function FetchCount() {
        if (pro_table != '') {
            pro_table.destroy();
        }
        var url = "FetchCount";
        var data = {
            equal: {
                is_delete: 0,
                com_id: com_id
            },
            like: {
                name: $("#name").val()
            }
        };
        $.post(url, data, function (res) {
            var htmlStr = '';
            for (var i = 0; i < res.length; i++) {
                htmlStr += '' +
                    '<tr id="tr_' + res[i].id + '">\n' +
                    '                        <td>' + (i + 1) + '</td>\n' +
                    '                        <td class="picture"><i><img src="<?php echo base_url()?>' + res[i].coverimg + '"></i></td>\n' +
                    '                        <td>' + res[i].name + '</td>\n' +
                    '                        <td>' + res[i].brand_name + '</td>\n' +
                    '                        <td>' + res[i].ins_name + '</td>\n' +
                    '                        <td>' + res[i].add_time + '</td>\n' +
                    '                        <td class="cz display1">\n' +
                    '                            <a href="AddOne?id=' + res[i].id + '"> <i class="iconfont icon-shanchu1"><span>编辑</span></i></a>\n' +
                    '                            <i onclick="DeleteOne(' + res[i].id + ')" class="iconfont icon-shenqingshenpi"><span>删除</span></i>\n' +
                    '                        </td>\n' +
                    '                    </tr>';
            }
            $("#product_list").html(htmlStr);
            pro_table = $('#table_id_example').DataTable({
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
        }, 'json')
    }

    function DeleteOne(id) {
        layer.confirm("确认删除?", {btn: ["确定", "取消"]}
            , function () {
                var url = 'SaveOne';
                var save = {
                    is_delete: 1
                };
                var data = {
                    id: id,
                    save: save
                };
                $.post(url, data, function (res) {
                    layer.msg(res.msg, {time: 1500}, function () {
                        $("#tr_" + id).remove();
                        // FetchPageData(10, nowpage);
                    })
                }, 'json')
            }
            , function () {
                layer.closeAll();
            }
        );
    }
</script>
