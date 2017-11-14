<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 客户管理
    <span class="c-gray en">&gt;</span> 客户申请
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">

    <div class="mt-5">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="40">ID</th>
                <th width="190">申请时间</th>
                <th width="100">申请状态</th>
                <th width="190">电话号码</th>
                <th width="25%">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($list)): foreach ($list as $value):
                $status = array('未联系','不合格','保留','已开通');
                ?>
                <tr class="text-c">
                    <td class="text-c"><?php echo $value['id']; ?></td>
                    <td class="text-c"><?php echo $value['create_time']?date('Y-m-d  H:i:s',$value['create_time']):'-'; ?></td>
                    <td class="text-c"><?php echo $status[$value['status']]; ?></td>
                    <td class="text-c"><?php echo $value['phone']?$value['phone']:'-'; ?></td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 checke" oid="<?php echo $value['id']; ?>"
                           href="javascript:;" title="不合格">不合格
                        </a>
                        <?php if($value['status']!=2){ ?>
                        <a style="text-decoration:none" class="ml-5 confirm" oid="<?php echo $value['id']; ?>"
                           href="javascript:;" title="保留">保留
                        </a>
                        <?php } ?>
                        <a style="text-decoration:none" class="ml-5 addAccount" oid="<?php echo $value['id']; ?>"
                           href="/Mars/customer/add?applyId=<?php echo $value['id']; ?>&phone=<?php echo $value['phone']; ?>" title="开通账号">开通账号
                        </a>
                    </td>
                </tr>
            <?php endforeach;endif; ?>
            </tbody>
        </table>
        <div class="text-r mt-5" id="page"></div>
    </div>

</div>
<script type="text/javascript">
    $(function () {
        $('.checke').click(function () {
            var oid = $(this).attr('oid');
            layer.msg('确定信息不合格？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.ajax({
                        url: '/Mars/customer/applyCheck',
                        type: 'POST',
                        dataType: 'json',
                        data: {'id':oid},
                        success: function(d) {
                            if(d.ret == 0) {// 成功
                                layer.open({
                                    content: '设置成功！',
                                    yes: function(){ location.href='';}
                                });
                            }  else {
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
    })

    $(function () {
        $('.confirm').click(function () {
            var oid = $(this).attr('oid');
            layer.msg('确定保留？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.ajax({
                        url: '/Mars/customer/applyConfirm',
                        type: 'POST',
                        dataType: 'json',
                        data: {'id':oid},
                        success: function(d) {
                            if(d.ret == 0) {// 成功
                                layer.open({
                                    content: '保留成功！',
                                    yes: function(){ location.href='';}
                                });
                            }  else {
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
    })

    $(function () {
        $('.addAccount').click(function () {
            var oid = $(this).attr('oid');
            layer.msg('确定开通账号？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.ajax({
                        url: '/Mars/customer/addAccount',
                        type: 'POST',
                        dataType: 'json',
                        data: {'id':oid},
                        success: function(d) {
                            if(d.ret == 0) {// 成功
                                layer.open({
                                    content: '开通成功！',
                                    yes: function(){ location.href='';}
                                });
                            }  else {
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


</script>
