<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 资讯管理
    <span class="c-gray en">&gt;</span> 资讯列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="" name="">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">简略标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="" name="">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="" class="select">
					<option value="0">一级分类</option>
					<option value="1">一级分类</option>
					<option value="11">├二级分类</option>
					<option value="12">├二级分类</option>
					<option value="13">├二级分类</option>
				</select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="0" placeholder="" id="" name="">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">允许评论：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="check-box">
                    <input type="checkbox" id="checkbox-1">
                    <label for="checkbox-1">&nbsp;</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品规格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="输入长度" value="" class="input-text" style=" width:25%">
                MM
                <input type="text" name="" id="" placeholder="输入宽度" value="" class="input-text" style=" width:25%">
                MM
                <input type="text" name="" id="" placeholder="输入高度" value="" class="input-text" style=" width:25%">
                MM </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产地：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">材质：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">所属供应商：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">价格计算单位：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select">
					<option>请选择</option>
					<option value="1">件</option>
					<option value="2">斤</option>
					<option value="3">KG</option>
					<option value="4">吨</option>
					<option value="5">套</option>
				</select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品重量：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                kg</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品展示价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">市场价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">成本价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">最低销售价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">销售开始时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:180px;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">销售结束时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'datemin\')}'})" id="datemax" class="input-text Wdate" style="width:180px;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品关键字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="多个关键字用英文逗号隔开，限10个关键字" value="" class="input-text">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                    <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</button>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图片上传：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-list-container">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker-2"></div>
                            <p>或将照片拖到这里，单次最多可选300张</p>
                        </div>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
                        <div class="info"></div>
                        <div class="btns">
                            <div id="filePicker2"></div>
                            <div class="uploadBtn">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
                <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>

<!--请在下方写此页面业务相关的脚本-->
