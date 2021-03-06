<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <LINK rel="Bookmark" href="/favicon.ico">
    <LINK rel="Shortcut Icon" href="/favicon.ico"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/admin/lib/html5.js"></script>
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <script type="text/javascript" src="/admin/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.7/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/lib/icheck/icheck.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/blue/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="http:///admin/lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>清风自来</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs" href="/aboutHui.shtml">清风自来</a>
            <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml">H-ui</a> <span
                    class="logo navbar-slogan f-l mr-10 hidden-xs">后台</span> <a aria-hidden="false"
                                                                                  class="nav-toggle Hui-iconfont visible-xs"
                                                                                  href="javascript:;">&#xe667;</a>
            <nav class="nav navbar-nav">
                <ul class="cl">

                </ul>
            </nav>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>欢迎您回来，</li>
                    <li class="dropDown dropDown_hover"><a href="#" class="dropDown_A"><?php echo isset($_SESSION['userinfo']['name']) ? $_SESSION['userinfo']['name'] : ''; ?><i class="Hui-iconfont">
                                &#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="/Mars/system/info">个人信息</a></li>
                            <li><a href="/Mars/member/logout">退出</a></li>
                        </ul>
                    </li>
<!--                    <li id="Hui-msg"><a href="#" title="消息"><span class="badge badge-danger">1</span><i-->
<!--                                    class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a></li>-->
                    <li id="Hui-skin" class="dropDown right dropDown_hover"><a href="javascript:;" class="dropDown_A"
                                                                               title="换肤"><i class="Hui-iconfont"
                                                                                             style="font-size:18px">
                                &#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value=""/>
    <div class="menu_dropdown bk_2">
        <dl id="menu-system">
            <dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="/Mars/system/add" data-title="新建系统账号" href="javascript:;">新建系统账号</a></li>
                    <li><a data-href="/Mars/system/list" data-title="系统账号列表" href="javascript:;">系统账号列表</a></li>
                </ul>
            </dd>
        </dl>
<!--        <dl id="menu-admin">-->
<!--            <dt><i class="Hui-iconfont ">&#xe62d;</i> 客户中心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--            <dd>-->
<!--                <ul>-->
<!--                    <li><a data-href="/Mars/customer/add" data-title="客户添加" href="javascript:void(0)">客户添加</a></li>-->
<!--                    <li><a data-href="/Mars/customer/index" data-title="客户列表" href="javascript:void(0)">客户列表</a></li>-->
<!--                    <li><a data-href="/Mars/customer/apply" data-title="客户申请" href="javascript:void(0)">客户申请</a></li>-->
<!--                </ul>-->
<!--            </dd>-->
<!--        </dl>-->
<!--        <dl id="menu-admin">-->
<!--            <dt><i class="Hui-iconfont ">&#xe62d;</i> 广告管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--            <dd>-->
<!--                <ul>-->
<!--                    <li><a data-href="/Mars/advert/check" data-title="广告审核" href="javascript:void(0)">广告审核</a></li>-->
<!--                    <li><a data-href="/Mars/advert/list" data-title="广告列表" href="javascript:void(0)">广告列表</a></li>-->
<!--                </ul>-->
<!--            </dd>-->
<!--        </dl>-->
<!--        <dl id="menu-admin">-->
<!--            <dt><i class="Hui-iconfont ">&#xe62d;</i> 财务中心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--            <dd>-->
<!--                <ul>-->
<!--                    <li><a data-href="/Mars/finance/addRecharge" data-title="添加充值" href="javascript:void(0)">添加充值</a></li>-->
<!--                    <li><a data-href="/Mars/finance/rechargeRecord" data-title="充值记录" href="javascript:void(0)">充值记录</a></li>-->
<!--                    <li><a data-href="/Mars/finance/costRecord" data-title="消费记录" href="javascript:void(0)">消费记录</a></li>-->
<!--                </ul>-->
<!--            </dd>-->
<!--        </dl>-->
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont ">&#xe62d;</i> 分类中心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="/Mars/class/add" data-title="添加分类" href="javascript:void(0)">添加分类</a></li>
                    <li><a data-href="/Mars/class/index" data-title="分类列表" href="javascript:void(0)">分类列表</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont ">&#xe62d;</i> 文章管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="/Mars/article/add" data-title="文章添加" href="javascript:void(0)">文章添加</a></li>
                    <li><a data-href="/Mars/article/index" data-title="文章列表" href="javascript:void(0)">文章列表</a></li>
                </ul>
            </dd>
        </dl>
<!--        <dl id="menu-admin">-->
<!--            <dt><i class="Hui-iconfont ">&#xe62d;</i> 数据中心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>-->
<!--            <dd>-->
<!--                <ul>-->
<!--                    <li><a data-href="/Mars/report/index" data-title="pc广告" href="javascript:void(0)">pc广告</a></li>-->
<!--                    <li><a data-href="/Mars/report/pcToday" data-title="今日实时" href="javascript:void(0)">今日实时</a></li>-->
<!--                </ul>-->
<!--            </dd>-->
<!--        </dl>-->

    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
</div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span title="我的桌面" data-href="/index/main">我的桌面</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S"
                                                  href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a
                    id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i
                        class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="/Mars/index/main"></iframe>
        </div>
    </div>
</section>

<div class="contextMenu" id="myMenu1">
    <ul>
        <li id="closeall">关闭全部</li>
    </ul>
</div>


<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.min.js"></script>
<script type="text/javascript">
    $(function () {
        $(".Hui-tabNav-wp").contextMenu('myMenu1', {
            bindings: {
                'closeall': function (t) {
                    $('#min_title_list li').not(":eq(0)").remove();
                    tabNavallwidth();
                },
            }
        });
    });
    /*资讯-添加*/
    function article_add(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-添加*/
    function picture_add(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*产品-添加*/
    function product_add(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*用户-添加*/
    function member_add(title, url, w, h) {
        layer_show(title, url, w, h);
    }
</script>
</body>
</html>