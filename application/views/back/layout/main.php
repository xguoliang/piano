<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="referrer" content="never">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/back/css/iconfont.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/back/css/bootstrap.css"/>


    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/back/css/end.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/back/css/jquery.dataTables.css">
    <script src="<?php echo base_url()?>assets/back/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/admin/js/jquery.ui.widget.js"></script>
    <script src="<?php echo base_url()?>assets/admin/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo base_url()?>assets/admin/js/jquery.fileupload.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/layer/layer.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="<?php echo base_url()?>assets/back/js/jquery.dataTables.js"></script>
</head>
<body style="min-width:1500px">
<div class="all display1">
    <section class="left-nav">
        <p>管理员</p>
        <ul class="nav-list">
            <li <?php if($layout['index_mod'] == 1){echo 'class="nav-list-active"';}?>><a href="<?php echo base_url()?>Back/Product/ProductList.html">商品列表</a></li>
            <li <?php if($layout['index_mod'] == 2){echo 'class="nav-list-active"';}?> style="margin-top: 10px"><a href="<?php echo base_url()?>Back/Lesson/LessonList.html">课程列表</a></li>
            <li <?php if($layout['index_mod'] == 3){echo 'class="nav-list-active"';}?> style="margin-top: 16px"><a href="<?php echo base_url()?>Back/Teacher/TeacherList.html">老师列表</a></li>
            <li <?php if($layout['index_mod'] == 4){echo 'class="nav-list-active"';}?> style="margin-top:25px"><a href="<?php echo base_url()?>Back/Headline/HeadlineList.html">头条列表</a></li>
        </ul>
    </section>
    <section class="right-text">
        <div class="right-top display1">
            <p><?php echo $_SESSION['back_user']['com_name']?></p>
            <p><?php echo $_SESSION['back_user']['phone']?></p>
            <i class="iconfont icon-tuichu" onclick="LogOut()"></i>
        </div>
    <?php echo $content?>
    </section>
</div>

</body>

<script>
    function LogOut(){
        var url = "<?php echo base_url()?>index.php/Back/Login/LogOut";
        var data = {};
        $.post(url,data,function(res){
            if(res.status == 1){
                layer.msg('退出成功！',{time: 1500},function(){
                    window.location.href = '<?php echo base_url()?>Back/Login/Login.html';
                })
            }
        },'json')
    }
    $(document).ready(function () {
        // $('#table_id_example').DataTable({
        //         "searching": false,     //搜索框去掉
        //         bLengthChange: false,   //去掉每页显示多少条数据方法
        //         "info": false,//底部文字去掉
        //         "language": {
        //             "paginate": {
        //                 "next": "下一页",
        //                 "previous": "上一页",
        //             },
        //
        //         }
        //     }
        // );

        $('#table_id_example1').DataTable({
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
        $('#table_id_example2').DataTable({
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
        $('#table_id_example3').DataTable({
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
    });
</script>
</html>