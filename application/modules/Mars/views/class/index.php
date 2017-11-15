<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span>　分类中心
    <span class="c-gray en">&gt;</span> 分类列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<div class="page-container">
    <div class="text-c">
        <form action="/Mars/class/index" method="get">
            开始日：<input type="text" name="start_date" class="laydate-icon" id="start"
                       value="<?php if(fn_get_val('start_date')){ echo fn_get_val('start_date');}else{ echo date('Y-m-01', strtotime(date("Y-m-d")));} ?>"/>
            结束日：<input type="text" name="end_date" class="laydate-icon" id="end"
                       value="<?php if(fn_get_val('end_date')){ echo fn_get_val('end_date');}else{ echo date('Y-m-d', strtotime( date('Y-m-01', strtotime(date("Y-m-d")))."+1 month -1 day"));} ?>"/>
            用户名/联系人/手机号/邮箱：
            <input type="text" value="<?php echo fn_get_val("userinfo"); ?>" name="userinfo" id=""
                   placeholder="用户名/联系人/手机号/邮箱" style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont"></i> 查询
            </button>
        </form>
    </div>
    <div class="mt-5">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr>
                <th>时间</th>
                <th>用户名</th>
                <th>联系人</th>
                <th>手机号</th>
                <th>邮箱</th>
                <th>充值金额</th>
                <th>类型</th>
                <th>剩余流量</th>
                <th>操作人</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($list)) {
                foreach ($list as $k => $v) {
                    ?>
                    <tr>
                        <td><?php echo date("Y-m-d", $v['date']) ?></td>
                        <td><?php echo $v['user_name'] ?></td>
                        <td><?php echo $v['real_name'] ?></td>
                        <td><?php echo $v['phone'] ?></td>
                        <td><?php echo $v['email'] ?></td>
                        <td><?php echo sprintf("%.2f(%d)", $v['money'], $v['money_flow']) ?></td>
                        <td><?php echo $v['type'] == 2 ? '充值' :($v['type'] ==3?'赠送':'线下打款') ?></td>
                        <td><?php echo intval($v['remain_money']) ?></td>
                        <td><?php echo $v['username'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        <div class="text-r mt-5" id="page"></div>
    </div>
</div>


<script>
    layui.use('laydate', function () {
        var laydate = layui.laydate;

        var start = {
            min: '2012-01-01 23:59:59'
            , max: $("#end").val()
            , istoday: false
            , choose: function (datas) {
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };

        var end = {
            min: $("#start").val()
            , max: laydate.now(+200000)
            , istoday: false
            , choose: function (datas) {
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };

        document.getElementById('start').onclick = function () {
            start.elem = this;
            laydate(start);
        }
        document.getElementById('end').onclick = function () {
            end.elem = this
            laydate(end);
        }

    });
</script>
<script type="text/javascript">
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