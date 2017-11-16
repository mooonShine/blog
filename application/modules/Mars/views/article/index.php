<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 文章管理
    <span class="c-gray en">&gt;</span> 文章列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <div class="text-c">
        <form action="/Mars/article/index" method="get">
            开始日：<input type="text" name="start_date" class="laydate-icon" id="start" value="<?php if(fn_get_val('start_date')){ echo fn_get_val('start_date');}else{ echo date('Y-m-01', strtotime(date("Y-m-d")));} ?>" />
            结束日：<input type="text" name="end_date" class="laydate-icon" id="end" value="<?php if(fn_get_val('end_date')){ echo fn_get_val('end_date');}else{ echo date('Y-m-d',time());} ?>" />

            <select name="is_del" id="is_del" class="select" style="width: 100px">
                <option  value="">文章状态</option>
                <option value="1" <?php if(fn_get_val("is_del")==1){ echo 'selected';}?>>正常</option>
                <option value="2" <?php if(fn_get_val("is_del")==2){ echo 'selected';}?>>已删除</option>
            </select>

            <input type="text" value="<?php echo fn_get_val("name"); ?>" name="name" id="" placeholder="文章名/署名"
                   style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜文章
            </button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-10">
        <span class="l">
<!--            <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">-->
<!--                <i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>-->
            <a class="btn btn-primary radius" data-title="添加文章" onclick="group_open('添加文章','/Mars/article/add')" href="javascript:;">
                <i class="Hui-iconfont">&#xe600;</i> 添加文章</a>
        </span>
        <span class="r"></span>
    </div>
    <div class="mt-5">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="40">ID</th>
                <th width="100">添加时间</th>
                <th width="100">标题</th>
                <th width="100">所属分类</th>
                <th width="120">图片</th>
                <th width="200">内容</th>
                <th width="80">是否删除</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($list)): foreach ($list as $value): ?>
                <tr class="text-c">
                    <td><input type="checkbox" value="<?php echo $value['id']; ?>" name=""></td>
                    <td><?php echo $value['id']; ?></td>
                    <td class="text-c"><?php echo $value['create_time']?date("Y-m-d H:i:s", $value['create_time']):'-'; ?></td>
                    <td class="text-c"><?php echo $value['title']?$value['title']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['class_id']?$value['class_id']:'-'; ?></td>
                    <td class="text-c"> <img src="<?php echo $value['pic'] ?>" class="showObj" alt="" style="display: none;position: absolute;top: 0px;left: 60px;width: 300px;height: 250px"></td>
                    <td class="text-c"><?php echo $value['content']?$value['content']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['is_del']==1?'正常':'已删除'; ?></td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 delBtn" oid="<?php echo $value['id']; ?>"
                           href="javascript:;" title="修改">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a style="text-decoration:none" class="ml-5 statusBtn" status="0" oid="<?php echo $value['id']; ?>"
                           href="javascript:;" title="删除">
                            <i class="Hui-iconfont" style="color: #00B83F">&#xe605;</i>
                        </a>
                    </td>
                </tr>
            <?php endforeach;endif; ?>
            </tbody>
        </table>
        <div class="text-r mt-5" id="page"></div>
    </div>

</div>
<script>
    $("#frate").mouseenter(function(){
        layer.tips('双击值可修改(每pv对应价格)', '#frate', {
            tips: [2, '#78BA32']
        });
    });
    $("#frate").mouseleave(function(){
    });
    function group_open(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    function datadel() {
        var ids = [];
        $(".table tbody :checkbox:checked").each(function (index, dom) {
            ids.push($(dom).val());
        })
        layer.confirm('是否确定删除？', {
            btn: ['取消', '确定'] //按钮
        }, function (index, layero) {
            layer.close(index);
        }, function () {
            window.location.href = "/Mars/article/del/id/" + ids.join(",");
        });
    }
</script>
<script type="text/javascript">
    function onlyNum() {
        if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
        if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)||event.keyCode==110||event.keyCode==190))
        event.returnValue=false;
    }
    $(function () {
        $('.delBtn').click(function () {
            var succ_url='/Mars/article/index';
            var oid = $(this).attr('oid');
            layer.msg('是否确定重置密码？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.ajax({
                        url: '/Mars/article/reset',
                        type: 'POST',
                        dataType: 'json',
                        data: {'id':oid},
                        success: function(d) {
                            if(d.ret == 0) {// 成功
                                layer.open({
                                    content: '重置成功！',
                                    yes: function(){ location.href=succ_url;}
                                });
                            } else if(d.ret == 1){ //失败一定要 return false
                                layer.open({
                                    content: d.msg
                                });
                                return false;
                            } else {
                                layer.open({
                                    content: d.msg
                                });
                                return false;
                            }
                        }
                    })
                }
            });
        })
        //冻结和解冻
        $('.statusBtn').click(function () {
            var succ_url='/Mars/article/index';
            var oid = $(this).attr('oid');
            var status = $(this).attr('status');
            var info=status==1?'冻结':'解冻';
            layer.msg('确定'+info+'？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.ajax({
                        url: '/Mars/article/status',
                        type: 'POST',
                        dataType: 'json',
                        data: {'id':oid,'status':status},
                        success: function(d) {
                            if(d.ret == 0) {// 成功
                                layer.open({
                                    content: d.msg,
                                    yes: function(){ location.href=succ_url;}
                                });
                            } else if(d.ret == 1){ //失败一定要 return false
                                layer.open({
                                    content: d.msg
                                });
                                return false;
                            } else {
                                layer.open({
                                    content: d.msg
                                });
                                return false;
                            }
                        }
                    })
                }
            });
        })

        laypage({
            cont: 'page',
            pages: <?php echo isset($count) ? $count : 0;?>,
            skin: 'molv',
            curr: function () {
                var page = location.search.match(/p=(\d+)/);
                return page ? page[1] : 1;
            }(),
            jump: function (e, first) { //触发分页后的回调
                if (!first) { //一定要加此判断，否则初始时会无限刷新
                    var param = parseQueryString(location.href);
                    param.p = e.curr;
                    var ary = [];
                    for (var i in param) {
                        ary.push(i + "=" + param[i]);
                    }
                    location.href = "?" + ary.join("&");
                }
            }
        });


             layui.use('laydate', function(){
        var laydate = layui.laydate;

        var start = {
            min: '2012-01-01 23:59:59'
            ,max: $("#end").val()
            ,istoday: false
            ,choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };

        var end = {
            min: $("#start").val()
            ,max: laydate.now()
            ,istoday: false
            ,choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };

        document.getElementById('start').onclick = function(){
            start.elem = this;
            laydate(start);
        }
        document.getElementById('end').onclick = function(){
            end.elem = this
            laydate(end);
        }

        });

        $(".frate").dblclick(function(){
            var uid=$(this).attr('uid');
            var frate=$(this).text();
            var succ_url='/Mars/article/index';
            //frate必须为大于0的数字
            var inpu="<input type='text' class='input-text radius' onkeydown='onlyNum()' value="+frate+">";
            $(this).html(inpu);

            var that = this;
            $(this).find("input").focus().val(frate).on("blur", function() {
                if(frate==$(this).val()){
                    $(that).html(frate);
                }else{
                    $.ajax({
                        url: '/Mars/article/editFrate',
                        type: 'POST',
                        dataType: 'json',
                        data: {uid: uid, frate: $(this).val()},
                        success: function(d) {
                            if(d.ret == 0) {// 成功
                                layui.use('layer', function(){
                                    var layer = layui.layer;
                                    layer.msg('修改成功');
                                });
                                window.location.href=succ_url;
                            } else if(d.ret == 1){ //失败一定要 return false
                                layui.use('layer', function(){
                                    var layer = layui.layer;
                                    layer.msg('修改失败');
                                });
                                return false;
                            } else {
                                layui.use('layer', function(){
                                    var layer = layui.layer;
                                    layer.msg('修改失败');
                                });
                                return false;
                            }
                        }
                    })
                }
            })
        });

                
    })
    

</script>
