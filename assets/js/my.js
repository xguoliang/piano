$(function () {
    $(".filter-bar li").click(function () {
        if ($(this).find('i').css('transform') == "none") {
            $(".mask").show();
            $(".filter-info").hide();
            $(".filter-info").eq($(this).index()).show();
            $(this).parents(".good").addClass("search-container");
            $(this).addClass("active").siblings().removeClass("active");
            $(".filter-bar li").find('i').css('transform', '');
            $(this).find('i').css('transform', 'rotate(180deg)');
        } else {
            $('.mask').hide();
            $(".filter-info").hide();
            $(this).parents("body").find(".good").removeClass("search-container");
            $(this).removeClass('active');
            $(this).find('i').css('transform', '');
        }
    });
    $('.cover-floor').click(function (e) {
        $(".filter-dt").css("left", "");
        $(".filter-bar li").removeClass("active");
        $(".filter-info").hide();
        $(".mask").hide();
        $(this).parents("body").find(".good").removeClass("search-container");
        $(".gooddt-parameter").hide();
        $(".saled").hide();
        $(".search-container").css("z-index", "");
        $(".filter-bar li").find('i').css('transform', '');
    });
    $(".inside-title").find(".back").click(function () {
        window.history.back(-1);
    });
    function fixed() {
        var hh = $(".inside-title").parent(".good").height();
        $("body").css("padding-top", hh);
    }
    fixed();
});
function filter() {
    $(".good").removeClass("search-container");
    $(".mask").show();
    $(".filter-dt").css("left", "18%");
    $(".search-container").css("z-index", "98");
}