var xue_p = 0, xue_t = 0;
window.addEventListener('scroll', _.throttle(ScrollTo, 500), false);

//判断滚动方向,上滚不触发
function ScrollTo() {
    xue_p = $(window).scrollTop();    //下拉高度  
    if (xue_p >= xue_t) {
        AddMore();
    }
}
function AddMore() {
    var range = 50;
    var totalheight = 0;
    var srollPos = $(window).scrollTop();    //下拉高度  
    xue_t = srollPos;
    totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
    if (($(document).height() - range) <= totalheight) {
        more();
    }
}