<style>
    .gengduo {
        position: fixed;
        width: 2rem;
        background: #fff;
        display: none;
        top: 1.2rem;
        right:0.1rem;
        z-index: 99;
    }
    .gengduo :after{
        content: "";
        width: 0;
        height: 0;
        border: 6px solid #fff;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid transparent;
        border-bottom: 6px solid #fff;
        position: absolute;
        top: -12px;
        right: 0.15rem;
    }
    .gengduo ul li{
        display: flex;
        width: 1.7rem;
        height: 0.8rem;
        margin: 0 auto;
        border-bottom: 1px solid #e5e6e7;
    }
    .gengduo ul li i {
        width: 0.4rem;
        height: 0.4rem;
        margin: 0.2rem 0.1rem;
    }
    .gengduo ul li span {
        font-size:0.2rem;
        line-height:0.8rem;
    }
</style>
<!-- 头部搜索 -->
<div class="header">
    <div class="header-city" style="position:relative;">
        <a>
            <span data="1" id="search_type">琴行</span>
            <i class="down"></i>
        </a>
        <ul class="top-ul" style="position:absolute;background-color:#fba420;box-sizing: border-box;z-index:2;left:-0.2rem;width:1.4rem;display:none;">
            <li style="padding:0.1rem;border:1px solid #fff;color:#fff;text-align: center;" data="1">琴行</li>
            <li style="padding:0.1rem;border:1px solid #fff;color:#fff;text-align: center;" data="2">乐队</li>
            <li style="padding:0.1rem;border:1px solid #fff;color:#fff;text-align: center;" data="3">乐手</li>
            <li style="padding:0.1rem;border:1px solid #fff;color:#fff;text-align: center;" data="4">场地</li>
            <li style="padding:0.1rem;border:1px solid #fff;color:#fff;text-align: center;" data="5">乐器</li>
        </ul>
    </div>
    <div class="header-search">
        <div class="header-searchinfo">
            <i class="icon-search" onclick="ToSearch()"></i>
            <input id="search_name" type="text" placeholder="琴行、乐手、乐队、场地、乐器">
        </div>
    </div>
    <div class="header-add">
        <i class="icon-add"></i>
    </div>
</div>
<div class="mask">
    <div class="cover-floor"></div>
</div>
<div class="gengduo">
    <ul>
        <li onclick="javascript:window.location.href = '<?php echo base_url(); ?>User/Message/MessageList.html'"><i></i><span>消息</span></li>
        <li><i></i><span>点评</span></li>
        <li><i></i><span>扫一扫</span></li>
    </ul>
</div>
<!-- 头部搜索结束 -->
<!-- 轮播图start -->
<div class="index-wrap swiper-container">
    <div class="swiper-wrapper">
        <?php foreach ($banner as $k => $v) { ?>
            <div class="swiper-slide">
                <a href="<?php echo $v['link'] ?>">
                    <img src="<?php echo base_url() . $v['img']; ?>">
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="swiper-pagination index-pagination"></div>
</div>
<!-- 轮播图end -->
<!-- 消息轮播start -->
<div class="notice">
    <i class="notice-icon"></i>
    <ul class="notice-slide">
        <?php foreach ($push as $k => $v) { ?>
            <li>
                <a href="<?php echo $v['link'] ?>"><?php echo $v['title'] ?></a>
            </li>
        <?php } ?>
    </ul>
</div>
<!-- 消息轮播end -->
<!-- 精彩活动start -->
<div class="activity">
    <ul>
        <li>
            <a href="<?php echo base_url(); ?>User/Product/PFindGood.html">
                <div class="acti-txt">
                    <p>发现好货</p>
                    <button>GO</button>
                </div>
                <div class="acti-img">
                    <img src="<?php echo base_url(); ?>assets/img/phone/06.png" alt="">
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Headline/HeadlineList.html">
                <div class="acti-txt">
                    <p>今日头条</p>
                    <button>GO</button>
                </div>
                <div class="acti-img">
                    <img src="<?php echo base_url(); ?>assets/img/phone/05.png" alt="">
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Delprice/DelpriceList">
                <div class="acti-txt">
                    <p>降价排行</p>
                    <button>GO</button>
                </div>
                <div class="acti-img">
                    <img src="<?php echo base_url(); ?>assets/img/phone/04.png" alt="">
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Talent/PTalentRank.html">
                <div class="acti-txt">
                    <p>达人精选</p>
                    <button>GO</button>
                </div>
                <div class="acti-img">
                    <img src="<?php echo base_url(); ?>assets/img/phone/03.png" alt="">
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Activity/ActivityList.html">
                <div class="acti-txt">
                    <p>精彩活动</p>
                    <button>GO</button>
                </div>
                <div class="acti-img">
                    <img src="<?php echo base_url(); ?>assets/img/phone/02.png" alt="">
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() ?>User/Vip/VipList.html">
                <div class="acti-txt">
                    <p>会员权益</p>
                    <button>GO</button>
                </div>
                <div class="acti-img">
                    <img src="<?php echo base_url(); ?>assets/img/phone/01.png" alt="">
                </div>
            </a>
        </li>
    </ul>
</div>
<!-- 精彩活动end -->
<!-- 分类start -->
<div class="list">
    <ul>
        <li>
            <a href="<?php echo base_url(); ?>User/Piano/PCompanyList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/001.png">
                <p>琴行</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Band/PBandList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/002.png">
                <p>乐队组建</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Lesson/LessonList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/003.png">
                <p>乐器培训</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Lease/LeaseList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/004.png">
                <p>设备租赁</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Works/MovieList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/005.png">
                <p>影音制作</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Lease/SiteLeaseList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/006.png">
                <p>场地租赁</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Companionship/PCompanionshipList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/007.png">
                <p>陪伴练习</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Perform/PerformList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/008.png">
                <p>各类演出</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Business/BusinessList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/009.png">
                <p>演出买卖</p>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>User/Works/WorksList.html">
                <img src="<?php echo base_url(); ?>assets/img/phone/010.png">
                <p>音乐视频</p>
            </a>
        </li>
    </ul>
</div>
<!-- 分类end -->
<!-- 特色频道start -->
<div class="live">
    <div class="title-head">
        <img src="<?php echo base_url(); ?>assets/img/phone/11.png">
        <span>特色频道</span>
        <a href="<?php echo base_url() ?>User/Channel/ChannelList.html">更多</a>
    </div>
    <ul class="live-item">
        <?php
        $i = 0;
        foreach ($channel as $k => $v) {
            ?>
            <li onclick="window.location.href = '<?php echo $v['link'] ?>'">
                <div class="live-img">
                    <img src="<?php echo base_url() . $v['img']; ?>" alt="">
                    <?php if ($v['desc'] != '') { ?>
                        <span class="live-span <?php
                        if ($i % 5 == 0) {
                            echo 'live-span1';
                        } else if ($i % 5 == 1) {
                            echo 'live-span2';
                        } else if ($i % 5 == 2) {
                            echo 'live-span3';
                        } else if ($i % 5 == 3) {
                            echo 'live-span4';
                        } else if ($i % 5 == 4) {
                            echo 'live-span5';
                        } else {
                            
                        }
                        ?>"><?php echo $v['desc'] ?></span>
                              <?php
                              $i++;
                          }
                          ?>
                </div>
                <p><?php echo $v['name']; ?></p>
            </li>
        <?php } ?>
    </ul>
</div>
<!-- 特色频道end -->
<!-- 精彩推荐start -->
<div class="recommend">
    <div class="title-head">
        <img src="<?php echo base_url(); ?>assets/img/phone/18.png">
        <span>精彩推荐</span>
        <a href="<?php echo base_url() ?>User/Recommend/RecommendList">更多</a>
    </div>
    <div class="recommend-wrap swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($recommend as $k => $v) { ?>
                <div class="swiper-slide">
                    <a href="<?php echo $v['link'] ?>">
                        <img src="<?php echo base_url() . $v['img']; ?>" alt="">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('phone/foot', array('nav' => 1)); ?>
<script src="<?php echo base_url(); ?>assets/js/swiper.min.js"></script>
<script>
            var swiper1 = new Swiper('.index-wrap', {
                pagination: '.index-pagination',
                slidesPerView: 1,
                autoplayDisableOnInteraction: false,
                paginationClickable: true,
                observer: true,
                observeParents: true,
                loop: true,
                autoplay: 2500
            });
            var swiper2 = new Swiper('.recommend-wrap', {
                autoplay: 3000,
                speed: 1000,
                autoplayDisableOnInteraction: false,
                loop: true,
                spaceBetween: 10,
                centeredSlides: true,
                slidesPerView: 2,
                // pagination : '.swiper-pagination',
                // paginationClickable:true,
                // prevButton:'.swiper-button-prev',
                // nextButton:'.swiper-button-next',
            });
            $('#search_type').click(function () {
                if ($('.top-ul').css('display') == "none") {
                    $('.top-ul').show();
                } else {
                    $('.top-ul').hide();
                }
            })
            $('.top-ul li').click(function () {
                $('.top-ul').hide();
                $('#search_type').text($(this).text());
                $('#search_type').attr('data', $(this).attr('data'));
            })
            $('.header-add').click(function () {
                $('.mask').show();
                $('.gengduo').show();
                $('body').css('overflow', 'hidden');
            })
            $('.mask').click(function () {
                $('.gengduo').hide();
                $('.mask').hide();
                $('body').css('overflow', 'auto');
            })
            function move() {
                var h = $(".notice-slide").height();
                // console.log("'-' + h + 'px'");
                T = setInterval(function () {
                    $(".notice").find("ul:first").animate({
                        marginTop: '-' + h + 'px'
                    }, 500, function () {
                        $(this).css({
                            marginTop: "0"
                        }).find("li:first").appendTo(this);
                    })
                }, 3000)
            }
            move();

            function ToSearch() {
                var type = $("#search_type").attr('data');
                if (type == 1) {
                    window.location.href = "<?php echo base_url() ?>User/Piano/PCompanyList.html?name=" + $("#search_name").val();
                } else if (type == 2) {
                    window.location.href = "<?php echo base_url() ?>User/Band/PBandList.html?name=" + $("#search_name").val();
                } else if (type == 3) {
                    window.location.href = "<?php echo base_url() ?>User/Talent/PTalentRank.html?name=" + $("#search_name").val();
                } else if (type == 4) {
                    window.location.href = "<?php echo base_url() ?>User/Lease/SiteLeaseList.html?name=" + $("#search_name").val();
                } else {
                    window.location.href = "<?php echo base_url() ?>/User/Lesson/LessonList.html?name=" + $("#search_name").val();
                }
            }
</script>