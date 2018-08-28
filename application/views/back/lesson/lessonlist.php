<div class="right-down">
    <h1>商品列表</h1>
    <div class="khgl-search display1">
        <select id="instrument_id" onchange="FetchCount()">
            <option value="0">全部乐器</option>
            <?php foreach($instrument as $k=>$v){?>
                <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
            <?php }?>
        </select>
        <div class="display1">
            <input type="text" placeholder="请输入关键词">
        </div>
        <button onclick="FetchCount()">搜索</button>
        <p onclick="window.location.href='AddOne'">
            <i><img src="<?php echo base_url() ?>assets/back/img/shang.png"></i>
            <span>添加课程</span>
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
                    <th width="350">名称</th>
                    <th width="304">课程时间</th>
                    <th>类别</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="lesson_list"></tbody>
            </table>
        </div>

    </div>
</div>
<script>
    var com_id = "<?php if (isset($_SESSION['back_user'])) {
        echo $_SESSION['back_user']['com_id'];
    } else {
        echo '';
    }?>";
    var lesson_table = '';
    $(function () {
        FetchCount();
        $("#name").focus(function(){
            $(document).keypress(function(e){
                if(e.which == 13){
                    FetchCount();
                }
            })
        });
    })

    function FetchCount() {
        if (lesson_table != '') {
            lesson_table.destroy();
        }
        var url = 'FetchCount';
        if($("#instrument_id").val() == 0){
            var data = {
                equal: {
                    is_delete: 0,
                    company_id: com_id
                },
                like: {
                    name: $("#name").val()
                }
            };
        }else{
            var data = {
                equal: {
                    is_delete: 0,
                    company_id: com_id,
                    instrument_id: $("#instrument_id").val()
                },
                like: {
                    name: $("#name").val()
                }
            };
        }
        $.post(url, data, function (res) {
            var htmlStr = '';
            for (var i = 0; i < res.length; i++) {
                htmlStr += '' +
                    '<tr id="tr_' + res[i].id + '">\n' +
                    '                        <td>' + (i + 1) + '</td>\n' +
                    '                        <td class="picture"><i><img src="<?php echo base_url()?>' + (res[i].coverimg.split(',')[0]) + '"></i></td>\n' +
                    '                        <td>' + res[i].name + '</td>\n' +
                    '                        <td>' + res[i].start_time + '至' + res[i].end_time + '</td>\n' +
                    '                        <td>' + res[i].ins_name + '</td>\n' +
                    '                        <td>' + res[i].add_time + '</td>\n' +
                    '                        <td class="cz display1">\n' +
                    '                            <i onclick="AddOne(' + res[i].id + ')" class="iconfont icon-shanchu1"><span>编辑</span></i>\n' +
                    '                            <i onclick="DeleteOne(' + res[i].id + ')" class="iconfont icon-shenqingshenpi"><span>删除</span></i>\n' +
                    '                        </td>\n' +
                    '                    </tr>';
            }
            $("#lesson_list").html(htmlStr);
            lesson_table = $('#table_id_example').DataTable({
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

    function AddOne(id) {
        window.location.href = "AddOne?id=" + id;
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



