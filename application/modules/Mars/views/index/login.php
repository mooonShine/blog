<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>程序小屋</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="/admin/css/style.css" tppabs="/css/style.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="/admin/js/jquery.js"></script>
<!--<script src="/js/verificationNumbers.js" tppabs="/js/verificationNumbers.js"></script>-->
<script src="/admin/js/Particleground.js" tppabs="/admin/js/Particleground.js"></script>
<script type="text/javascript" src="/admin/lib/layer/3.0/layer.js"></script>
<script>
if (top.location.href != location.href) {
        top.location.href = location.href;
    }
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
  //验证码
 // createCode();
  //测试提交，对接程序删除即可
});
function reload() {
        $('#pcode').attr("src", "/Mars/member/code?" + (new Date()));
    }
    $(function () {
        function login() {
            var uname = $("#username").val();
            var pwd = $("#password").val();
            var code = $("input[name='code']").val();
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
                'url': "/Mars/member/login",
                "type": "post",
                "data": {
                    'username': uname, 'pwd': pwd, "code": code, 'isc': isc,
                },
                "dataType": "json",
                "success": function (res) {
                    if (res.ret == 0) {
                        window.location.href = "/mars/index/index";
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
    });
</script>
</head>
<body>
<dl class="admin_login">
 <dt>
  <strong>程序小屋</strong>
  <em>Management System</em>
 </dt>
 <dd class="user_icon">
  <input type="text" id="username"  placeholder="账号" class="login_txtbx"/>
 </dd>
 <dd class="pwd_icon">
  <input type="password" id="password" placeholder="密码" class="login_txtbx"/>
 </dd>
 <dd class="val_icon">
  <div class="checkcode">
    <input type="text" id="J_codetext" name="code" placeholder="验证码" maxlength="4" class="login_txtbx" style="width: 100%;">
  </div>
     <a id="kanbuq" href="javascript:reload();">
         <img src="/Mars/member/code" style="width:56px;height:42px;float:right"  class="J_codeimg" id="pcode">
     </a>
 </dd>
 <dd>
  <input type="button" value="立即登陆" id="subBtn" class="submit_btn"/>
 </dd>
 <dd>
  <p>© 2017  清风自来</p>
  <p>一个无聊的人</p>
 </dd>
</dl>
</body>
</html>
