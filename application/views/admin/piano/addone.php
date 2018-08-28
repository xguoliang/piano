<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>琴行管理</h2>
        <ol class="breadcrumb">
            <li>
                <a>主页</a>
            </li>
            <li>
                <a>琴行管理</a>
            </li>
            <li>
                <strong>查看琴行</strong>
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
                    <label>查看琴行</label>
                </div>
                <div class="ibox-tools">
                    <a><span class="btn btn-primary" onclick="SaveOne()">保存信息</span></a>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="ibox-content">
                <div class="edit_info">
                    <div class="form-group">
                        <span class="left">名称：</span>
                        <input readonly id="name" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['name'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">头像：</span>
                        <div class="left">
                            <div class="pic_box">
                                <span id="user_headimg" class="no_pic" style="text-align: center;">
                                <?php if(isset($one)!=''){ ?>
                                    <img src="<?php echo base_url().$one['headimg']?>">
                                <?php }else{ ?>
                                    暂无图片
                                <?php }?>
                                </span>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">图片：</span>
                        <div class="left">
                            <?php $img = explode(',',$one['img'])?>
                            <?php foreach($img as $k=>$v){?>
                                <div class="pic_box" style="display: inline-block;margin: 0 16px 16px 0;">
                                <span class="" style="text-align: center;">
                                    <img src="<?php echo base_url().$v?>">
                                </span>
                                </div>
                            <?php }?>

                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">电话：</span>
                        <input readonly id="phone" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['phone'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">区域：</span>
                        <input readonly id="area" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['area'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">地址：</span>
                        <input readonly id="address" class="form-control left cwidth" type="text" value="<?php if(isset($one)){echo $one['address'];}?>">
                        <div class="clear"></div>
                    </div>
                    <div class="form-group">
                        <span class="left">简介：</span>
                        <textarea readonly id="desc" style="width:400px;height:100px;resize: none;border:1px solid #e5e6e7;"><?php echo $one['desc']?></textarea>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url(); ?>assets/ueditor/ueditor.all.min.js"></script>
