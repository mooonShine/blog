<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 系统管理
    <span class="c-gray en">&gt;</span> 编辑账号
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
    <form action="/system/edit" method="post" class="form form-horizontal" id="form-article-add">
        <input type="hidden" id="id" name="id" value="<?php echo isset($info['id'])?$info['id']:-1; ?>"/>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo isset($info['name'])?$info['name']:''; ?>"
                       placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo isset($info['username'])?$info['username']:''; ?>"
                       placeholder="" id="username" name="username">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="" id="pwd" name="pwd">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="" id="password" name="password">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账号状态：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
                    <select name="status" id="status" class="select">
                        <option value="">请选择</option>
                        <option value="1" <?php if (isset($info['status']) && $info['status'] === "1") {
                            echo 'selected="selected"';
                        } ?>>正常
                        </option>
                        <option value="2" <?php if (isset($info['status']) && $info['status'] === "2") {
                            echo 'selected="selected"';
                        } ?>>冻结
                        </option>
                    </select>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>代理状态：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
                    <select name="group_id" id="group_id" class="select">
                        <option value="0" <?php if (isset($info['group_id']) && $info['group_id'] === "0") {
                            echo 'selected="selected"';
                        } ?>>无
                        </option>
                        <option value="1" <?php if (isset($info['group_id']) && $info['group_id'] === "1") {
                            echo 'selected="selected"';
                        } ?>>代理
                        </option>
                    </select>
				</span>
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