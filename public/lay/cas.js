var page = require('webpage').create();
var sys = require('system');
page.viewportSize = {width: 1366, height: 600};
var url = 'http://cas.nbut.edu.cn/cas/login?service=http://app.nbut.edu.cn/wap/index/cas_result';
//var url = 'http://app.nbut.edu.cn/wap/index/cas?service=http://app.nbut.edu.cn/wap/index/cas_result';
if (sys.args.length < 3) {
    phantom.exit();
}

page.open(url, function () {
    var ret = page.evaluate(function (name, pwd) {
        $("#username")[0].value = name;
        $("#password")[0].value = pwd;
        $(".login_box_landing_btn").click();
    }, sys.args[1], sys.args[2]);
    setTimeout('print_cookies()', 1000)
});

function print_cookies() {
    if (page.title == "ok") {
        console.log("ok");
    } else {
        console.log("no");
    }
    phantom.exit()
}