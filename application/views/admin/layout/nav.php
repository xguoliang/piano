<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url()?>assets/admin/img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">管理员</strong>
                             </span> <span class="text-muted text-xs block">超级管理员</span> </span>
                    </a>
                </div>
                <div class="logo-element">
                    ZhiXiu
                </div>
            </li>
            <li <?php if($layout['index_pmod'] == 1){echo "class='active'";}?>>
                <a><span class="nav-label">琴行管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Piano/PianoList.html">琴行管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 2){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Lesson/LessonList.html">课程管理</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 2){echo "class='active'";}?>>
                <a><span class="nav-label">商品管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Product/ProductList.html">商品管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 2){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Instrument/InstrumentList.html">乐器管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 3){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Brand/BrandList.html">品牌管理</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 3){echo "class='active'";}?>>
                <a><span class="nav-label">头条管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Headline/HeadlineList.html">头条管理</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 4){echo "class='active'";}?>>
                <a><span class="nav-label">乐手管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Bandsman/BandsmanList.html">乐手管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 2){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Band/BandList.html">乐队管理</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 5){echo "class='active'";}?>>
                <a><span class="nav-label">租赁管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Lease/LeaseList.html">乐器租赁</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 2){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/SiteLease/SiteLeaseList.html">场地租赁</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 6){echo "class='active'";}?>>
                <a><span class="nav-label">影视制作</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Record/RecordList0.html">录音制作</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 2){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Record/RecordList1.html">录影制作</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 3){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Sound/SoundList.html">录音列表</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 4){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Movie/MovieListd.html">录影列表</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 7){echo "class='active'";}?>>
                <a><span class="nav-label">陪伴练习</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Companionship/CompanionshipList.html">陪伴练习</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 8){echo "class='active'";}?>>
                <a><span class="nav-label">演出练习</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Perform/PerformList.html">演出练习</a>
                    </li>
                </ul>
            </li>
            <li <?php if($layout['index_pmod'] == 9){echo "class='active'";}?>>
                <a><span class="nav-label">内容管理</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php if($layout['index_mod'] == 1){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Banner/BannerList.html">轮播管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 2){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Push/PushList.html">推送管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 3){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Vip/VipList.html">会员权益</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 4){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Channel/ChannelList.html">频道管理</a>
                    </li>
                    <li <?php if($layout['index_mod'] == 5){echo "class='active'";}?>>
                        <a href="<?php echo base_url()?>Admin/Recommend/RecommendList.html">推荐管理</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
