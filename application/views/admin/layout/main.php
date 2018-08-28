<!DOCTYPE html>
<html>
<?php $this->load->view('admin/layout/head')?>
<body>
<div id="wrapper">
    <?php $this->load->view("admin/layout/nav")?>
    <div id="page-wrapper" class="gray-bg dashbard-1">
    <?php $this->load->view("admin/layout/rightnav")?>
    <?php echo $content?>
    <?php $this->load->view("admin/layout/foot")?>
    </div>
</div>
</body>
</html>