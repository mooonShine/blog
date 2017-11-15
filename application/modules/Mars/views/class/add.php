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
        <legend>添加充值</legend>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">用户名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" autocomplete="off" placeholder="用户名" id="username">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">手机号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" autocomplete="off" placeholder="手机号" id="phone">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">充值金额：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" autocomplete="off" placeholder="充值金额" id="count">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">充值类型：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
							<select class="select" size="1" name="demo1">
                                <option value="3">赠送</option>
								<option value="4">线下打款</option>
							</select>
							</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text lay" autocomplete="off" placeholder="" id="timeDate">
            </div>
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

        document.getElementById('timeDate').onclick = function(){
            start.elem = this;
            laydate(start);
        }
    });

    $("#btnSub").on("click", function() {
        var data = {
            username: $("#username").val().trim(),
            phone: $("#phone").val().trim(),
            count: $("#count").val().trim(),
            type: $(".select").val(),
            time: new Date($("#timeDate").val() + " 0:0:0").getTime() / 1000
        }

        if(data.username == "") {
            $("#username").addClass('error');
            return false
        }
        var exc =  /^1[34578]{1}\d{9}$/;

        if(data.phone == "" || !exc.test(data.phone)) {
            $("#phone").addClass('error');
            return false
        }

        if(data.count <= 0 || data.count == "") {
            $("#count").addClass('error');
            return false
        }

        if(data.time == "") {
            $("#timeDate").addClass('error');
            return false
        }

        $.ajax({
            url: '/Mars/finance/addRecharge',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(d) {
                if(d.ret == 0) {// 成功
                    layer.open({
                        content: '充值成功！',
                        yes: function(){ location.reload(false);}
                    });
                } else if(d.ret == 1){ //失败一定要 return false
                    layer.open({
                        content: d.msg
                    });
                    $("#username").addClass('error');
                    $("#phone").addClass('error');
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