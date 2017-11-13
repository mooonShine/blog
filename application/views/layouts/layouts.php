<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>财务后台统计</title>
    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <link rel="stylesheet" href="/css/css.css"/>
    <script type="text/javascript" src="/js/jquery1.9.0.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="/js/layer/layer.js"></script>
</head>
<style>
    .pagination {
        margin-left: 20px !important;
    }

    .pagination li {
        width: 50px;
        float: left;
        list-style-type: none;
        text-align: center;
    }

    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        background-color: #428bca;
        border-color: #428bca;
        color: #fff;
        cursor: default;
        z-index: 2;
    }

    .pagination > li > a, .pagination > li > span {
        background-color: #fff;
        border: 1px solid #ddd;
        color: #428bca;
        float: left;
        line-height: 1.42857;
        margin-left: -1px;
        padding: 6px 12px;
        position: relative;
        text-decoration: none;
    }
</style>
<body>
<div class="header">
    <div class="logo"><img src="/img/tit.png"/></div>
    <div class="header-right">
        <?php if (isset($_SESSION['USERNAME'])) { ?>
            <a role="button" data-toggle="modal" style="text-decoration:none;">
                欢迎你, <?php echo '游客'; ?></a>
        <?php } ?>
        <i class="icon-off icon-white"></i>
        <div id="modal-container-973558" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true" style="width:300px; margin-left:-150px; top:30%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">
                    注销系统
                </h3>
            </div>
            <div class="modal-body">
                <p>
                    您确定要注销退出系统吗？
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                <a class="btn btn-primary" style="line-height:20px;" href="/member/logout">确定退出</a>
            </div>
        </div>
    </div>
</div>
<!-- 顶部 -->
<div id="middle">
    <div class="left">
    </div>
    <div class="Switch"></div>
    <?php echo $_content_; ?>
</div>
</body>
</html>