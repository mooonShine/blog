<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span>　分类中心
    <span class="c-gray en">&gt;</span> 添加分类
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div class="page-container">
    <form action="/Mars/class/add" method="post" class="form form-horizontal" id="demoform-1">
        <legend>添加分类</legend>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">分类名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" autocomplete="off" placeholder="分类名" id="name" style="width: 200px;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">父分类：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box"  style="width: 200px;">
							<select class="select" size="1" name="pid">
                                <option value="0">暂无</option>
							</select>
							</span> </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="button" value="提交" id="btnSub">
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        var start = {
            min: laydate.now()
            ,istoday: false
        };
    });

    $("#btnSub").on("click", function() {
        var data = {
            name: $("#name").val().trim(),
            pid: $(".select").val(),
        }

        if(data.name == "") {
            $("#name").addClass('error');
            return false
        }

        $.ajax({
            url: '/Mars/class/add',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(d) {
                if(d.ret == 0) {// 成功
                    layer.open({
                        content: '添加成功！',
                        yes: function(){ location.reload(false);}
                    });
                } else if(d.ret == 1){ //失败一定要 return false
                    layer.open({
                        content: d.msg
                    });
                    $("#name").addClass('error');
                    return false;
                } else {
                    layer.open({
                        content: d.msg
                    });
                    return false;
                }
            }
        })
    })
    $("input").on("blur", function() {
        $(this).removeClass('error')
    })
</script>