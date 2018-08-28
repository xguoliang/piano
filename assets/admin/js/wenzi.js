
/*尺寸自适应 移动端jq */
var window_width = 750;
var window_size = 100;
(function () {
    $.fn.autoSize = function (options) {
        options = $.extend({}, $.fn.autoSize.defaults, options || {});
        autoSet();
        $(window).resize(function () {
            autoSet();
        });

        function autoSet() {
            var width = $(this).width();
            var newsize = $.fn.autoSize.method.getFS(options.designWith, options.designFS, width);
            $.fn.autoSize.method.setFS(options.target, newsize);
        }
    };
    $.fn.autoSize.method = {
        getFS: function (designWith, designFs, winWith) { //获取fontsize
            return winWith / designWith * 100;
        },
        setFS: function (target, FS) {
            target.style.fontSize = FS + "px";
        }
    };
    $.fn.autoSize.defaults = {
        designWith: 750,
        designFS: 100,
        target: document.documentElement
    };
})(jQuery);
$(window).autoSize({
    designWidth: window_width,
    designFS: window_size
});
$(function () {
    $("footer ul li").click(function () {
        $("footer ul li").removeClass("footer-active");
        $(this).addClass("footer-active");
    });
    $(".chose-home div").click(function () {
        $(".chose-home div").removeClass("chose-active");
        $(this).addClass("chose-active")
    })
})
