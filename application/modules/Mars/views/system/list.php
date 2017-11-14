<?php
$roles = isset($roles) ? $roles : [];
?>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 系统管理
    <span class="c-gray en">&gt;</span> 账号列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <div class="text-c">
        <form action="/system/list" method="get">
            开始日：<input type="text" name="start_date" class="laydate-icon" id="start" value="<?php echo fn_get_val('start_date') ?>" />
            结束日：<input type="text" name="end_date" class="laydate-icon" id="end" value="<?php echo fn_get_val('end_date') ?>" />
            <select name="status_type"  class="select" style="width: 100px">
                <option value="1" <?php if(fn_get_val("status_type")==1){ echo 'selected';}?>>用户名</option>
                <option value="2" <?php if(fn_get_val("status_type")==2){ echo 'selected';}?>>姓名</option>
            </select>
            <input type="text" value="<?php echo fn_get_val("name_type"); ?>" name="name_type" id="" placeholder="用户名称/姓名"
                   style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜搜看
            </button>
        </form>
    </div>
    <div class="mt-5">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="15%">用户名</th>
                <th width="15%">姓名</th>
                <th width="15%">所属权限</th>
                <th width="15%">创建时间</th>
                <th width="15%">账号状态</th>
                <th width="15%">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($list)): foreach ($list as $value):
                 $status = array('1'=>'正常','2'=>'冻结');
                ?>
                <tr class="text-c">
                    <td class="text-c"><?php echo $value['name']; ?></td>
                    <td class="text-c"><?php echo $value['username']; ?></td>
                    <td class="text-c"><?php echo $value['group_id']; ?></td>
                    <td class="text-c"><?php echo date('Y-m-d H:i:s',$value['create_time']); ?></td>
                    <td class="text-c"><?php echo $status[$value['status']]; ?></td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5"
                           onClick="group_open('用户编辑','/system/edit/?id=<?php echo $value['id'] ?>')"
                           href="javascript:;"
                           title="编辑">
                            <i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 delBtn" oid="<?php echo $value['id']; ?>"
                           href="javascript:;" title="删除">
                            <i class="Hui-iconfont">&#xe6e2;</i>
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
</script>
<script>
    function group_open(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }


</script>
<script type="text/javascript">
    $(function () {
        $('.delBtn').click(function () {
            var oid = $(this).attr('oid');
            layer.msg('是否确定删除？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    window.location.href = "/system/del/id/" + oid;
                }
            });
        });
    })

    $(function () {
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
    })
</script>
