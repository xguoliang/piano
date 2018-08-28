function Toast(msg,duration){
    duration=isNaN(duration)?3000:duration;
    var m = document.createElement('div');
    m.innerHTML = msg;
    m.style.cssText="height: 50px;color:#fff;line-height: 50px;text-align: center;padding:0 30px;border-radius: 2px;position: fixed;top:240px;left: 50%;transform:translateX(-50%);z-index: 999999;background: rgba(0, 0, 0,0.5);font-size: 18px;";
    document.body.appendChild(m);
    setTimeout(function() {
        var d = 0.5;
        m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
        m.style.opacity = '0';
        setTimeout(function() { document.body.removeChild(m) }, d * 1000);
    }, duration);
}