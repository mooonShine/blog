<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/admin/lib/html5.js"></script>
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <script type="text/javascript" src="/admin/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link href="/admin/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="http:///lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台登录 - 房产云</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value=""/>
<div class="header">
    <span style="font-size: 35px;color: white;padding-left: 20px;display: inline-block;">房产热力图后台管理系统</span>
</div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal">
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="username" name="" type="text" placeholder="账户" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="password" name="" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input class="input-text size-L" type="text" id="code" placeholder="验证码：" style="width:150px;">
                    <img src="/member/code" width="100" height="40" id="pcode"> <a id="kanbuq"
                                                                                     href="javascript:reload();">看不清，换一张</a>
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <label for="online">
                        <input type="checkbox" name="online" id="online" value="1">
                        使我保持登录状态</label>
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="" id="subBtn" type="button" class="btn btn-success radius size-L"
                           value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                    <input name="" type="reset" class="btn btn-default radius size-L"
                           value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="footer">Copyright 浙江启冠网络股份有限公司</div>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/admin/lib/layer/3.0/layer.js"></script>
<script>
    if (top.location.href != location.href) {
        top.location.href = location.href;
    }
    function reload() {
        $('#pcode').attr("src", "/member/code?" + (new Date()));
    }
    $(function () {
        function login() {
            var uname = $("#username").val();
            var pwd = $("#password").val();
            var code = $("#code").val();
            var isc = $("#online").is(':checked') ? 1 : 0;


            if (uname == "") {
                layer.msg("用户名不能为空");
                return;
            }
            if (pwd == "") {
                layer.msg("密码不能为空");
                return;
            }
            if (code == "") {
                layer.msg("验证码不能为空");
                return;
            }

            $.ajax({
                'url': "/member/login",
                "type": "post",
                "data": {
                    'username': uname, 'pwd': pwd, "code": code, 'isc': isc,
                },
                "dataType": "json",
                "success": function (res) {
                    if (res.ret == 0) {
                        window.location.href = "/";
                    } else {
                        layer.msg(res.msg);
                    }
                }
            });

            return false;
        };
        document.onkeydown=function(event){
            e = event ? event :(window.event ? window.event : null);
            if(e.keyCode==13){
                //回车提交事件
                login();
            }
        }
        $("#subBtn").click(function(){
            //点击登陆
            login();
        })
    })
    ;


</script>
</body>
</html>