<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 数据中心
    <span class="c-gray en">&gt;</span> 今日实时
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <div class="text-c">
        <form action="/Mars/report/pcToday" method="get">
            <select name="status_type" id="status_type" class="select" style="width: 100px">
                <option value="">请选择</option>
                <option value="1" <?php if(fn_get_val("status_type")==1){ echo 'selected';}?>>广告名称</option>
                <option value="2" <?php if(fn_get_val("status_type")==2){ echo 'selected';}?>>广告ID</option>
                <option value="3" <?php if(fn_get_val("status_type")==3){ echo 'selected';}?>>推广楼盘</option>
                <option value="4" <?php if(fn_get_val("status_type")==4){ echo 'selected';}?>>用户名</option>
                <option value="5" <?php if(fn_get_val("status_type")==5){ echo 'selected';}?>>联系人</option>
                <option value="6" <?php if(fn_get_val("status_type")==6){ echo 'selected';}?>>手机号</option>
                <option value="7" <?php if(fn_get_val("status_type")==7){ echo 'selected';}?>>邮箱</option>
            </select>
            <input type="text" value="<?php echo fn_get_val("username"); ?>" name="username" id="" placeholder=""
                   style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索
            </button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-10">
        <span style="text-align: center">
            当前条件下,今日总展现量:<button class="btn btn-secondary radius"><?php echo isset($total_pv)?$total_pv:0;?></button>,
            今日总点击量:<button class="btn btn-secondary radius"><?php echo isset($total_click)?$total_click:0;?></button>,
            点击率:<button class="btn btn-secondary radius"><?php echo isset($total_click) ? sprintf("%0.2f", ($total_click / ($total_pv)) * 100) . '%' : '0.00%'; ?></button>
        </span>
    </div>
    <div class="mt-5">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="90">日期</th>
                <th width="150">广告名称</th>
                <th width="80">广告素材</th>
                <th width="80">推广楼盘名称</th>
                <th width="120">用户名</th>
                <th width="60">联系人</th>
                <th width="120">手机号</th>
                <th width="150">邮箱</th>
                <th width="80">今日展现量</th>
                <th width="80">今日点击量</th>
                <th width="80">点击率</th>
                <th width="100">账号剩余流量</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($list)): foreach ($list as $value): ?>
                <tr class="text-c">
                    <td><input type="checkbox" value="<?php echo $value['id']; ?>" name=""></td>
                    <td class="text-c"><?php echo $value['date']?$value['date']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['title']; ?></td>
                    <td class="text-c">
                        <?php if($value['pic']){ ?>
                            <a href="<?php echo $value['click_url'] //商品链接 ?>" target="_blank" class="thumbnail" style="width:60px;height:60px;">
                                <?php if (fn_get_fileExt($value['pic']) == 'swf'): ?>
                                    <object class="popGoodPic"
                                            classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
                                            WIDTH="50">
                                        <div style="position: absolute;width: 50px;height: 50px;"></div>
                                        <EMBED src="<?php echo $value['pic'] //图片 ?>" quality=high bgcolor=#FFFFFF width="40" height="40"
                                               NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash"
                                               PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
                                        </EMBED>
                                    </object>
                                <?php else: ?>
                                    <img class="popGoodPic" src="<?php echo $value['pic'] //图片 ?>" title="<?php echo $value['pic'] ?>" style="width:50px;height:auto;" />
                                <?php endif; ?>
                            </a>
                        <?php }else{ echo '-';}?>
                    </td>
                    <td class="text-c"><?php echo $value['house_name']?$value['house_name']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['user_name']?$value['user_name']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['contact']?$value['contact']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['phone']?$value['phone']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['email']?$value['email']:'-'; ?></td>
                    <td class="text-c"><?php echo $value['pv']?$value['pv']:0; ?></td>
                    <td class="text-c"><?php echo $value['click']?$value['click']:0; ?></td>
                    <td class="text-c"><?php echo $value['click'] ? sprintf("%0.2f", ($value['click'] / ($value['pv'])) * 100) . '%' : '0.00%'; ?></td>
                    <td class="text-c"><?php echo $value['flow']; ?></td>
                </tr>
            <?php endforeach;endif; ?>
            </tbody>
        </table>
        <div class="text-r mt-5" id="page"></div>
    </div>

</div>
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
    })

</script>
