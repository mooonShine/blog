<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 系统管理
    <span class="c-gray en">&gt;</span> 添加账号
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <!-- 错误提示:begin -->
    <p>
        <?php
        $html = '';

        if (isset($errorMsg) && count($errorMsg) > 0) {
            $html = sprintf('<div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>%s</div>',
                implode("<br>", $errorMsg));
        }

        echo $html;
        ?>
    </p>
    <!-- 错误提示:end -->
    <form action="/system/add" method="post" class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="" id="pwd" name="pwd">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="" id="password" name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="username" name="username">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>代理：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="group_id"  class="select" style="width: 100px">
                    <option value="0" >无</option>
                    <option value="1" >代理</option>
                </select>
            </div>
        </div>


        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="submit"><i
                            class="Hui-iconfont">&#xe632;</i> 保存
                </button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">
                    &nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>
