<?php
$roles = isset($roles) ? $roles : [];
?>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 广告管理
    <span class="c-gray en">&gt;</span> 广告列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <div class="text-c">
        <form action="/Mars/advert/list" method="get">
            开始日：<input type="text" name="start_date" class="laydate-icon" id="start" value="<?php if(fn_get_val('start_date')){ echo fn_get_val('start_date');}else{ echo date('Y-m-01', strtotime(date("Y-m-d")));} ?>" />
            结束日：<input type="text" name="end_date" class="laydate-icon" id="end" value="<?php if(fn_get_val('end_date')){ echo fn_get_val('end_date');}else{ echo date('Y-m-d',time());} ?>" />
            <select name="put_status"  class="select" style="width: 100px">
                <option value="">请选择</option>
                <option value="0" <?php if(fn_get_val("put_status")=='0'){ echo 'selected';}?>>未投放</option>
                <option value="1" <?php if(fn_get_val("put_status")==1){ echo 'selected';}?>>投放中</option>
                <option value="2" <?php if(fn_get_val("put_status")==2){ echo 'selected';}?>>用户流量不足</option>
                <option value="3" <?php if(fn_get_val("put_status")==3){ echo 'selected';}?>>日限额已到</option>
                <option value="4" <?php if(fn_get_val("put_status")==4){ echo 'selected';}?>>不在投放周期</option>
                <option value="5" <?php if(fn_get_val("put_status")==5){ echo 'selected';}?>>不在投放时段</option>
                <option value="6" <?php if(fn_get_val("put_status")==6){ echo 'selected';}?>>未审核通过</option>
                <option value="7" <?php if(fn_get_val("put_status")==7){ echo 'selected';}?>>投放开关关</option>
                <option value="8" <?php if(fn_get_val("put_status")==8){ echo 'selected';}?>>待审核</option>
            </select>
            <select name="review_status"  class="select" style="width: 100px">
                <option value="">请选择</option>
                <option value="1" <?php if(fn_get_val("review_status")==1){ echo 'selected';}?>>审核通过</option>
                <option value="2" <?php if(fn_get_val("review_status")==2){ echo 'selected';}?>>未通过</option>
            </select>
            <select name="status_type"  class="select" style="width: 100px">
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
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜搜看
            </button>
        </form>
    </div>
    <div class="mt-5">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th width="30">广告id</th>
                <th width="30">广告名称</th>
                <th width="30">广告素材</th>
                <th width="80">推广楼盘名称</th>
                <th width="80">用户名</th>
                <th width="80">联系人</th>
                <th width="120">邮箱</th>
                <th width="120">手机号</th>
                <th width="120">广告提交时间</th>
                <th width="80">投放状态</th>
                <th width="50">投放权重</th>
                <th width="80">审核状态</th>
                <th width="50">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($list)): foreach ($list as $value):
                $status = array('未投放','投放中','用户流量不足','日限额已到','不在投放周期','在投放时段','未审核通过','投放开关关闭','待审核');
                ?>
                <tr class="text-c">
                    <td class="text-c"><?php echo $value['id']; ?></td>
                    <td class="text-c"><?php echo $value['title']; ?></td>
                    <td class="text-c">
                        <?php if($value['pic']){ ?>
                            <a href="<?php echo $value['click_url'] //商品链接 ?>" target="_blank" sr="<?php echo $value['pic'] //图片 ?>"  class="thumbnail" style="width:60px;height:auto;position: relative;">
                                <?php if (fn_get_fileExt($value['pic']) == 'swf'): ?>

                                    <object type="application/x-shockwave-flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0"  class="popGoodPic click_fals imgClick" WIDTH="50">
                                        <div  style="position: absolute;width: 50px; height: 50px" ></div>
                                        <param name="movie" value='<?php echo $value['pic'] //图片 ?>'/>
                                        <param name="AutoStart" value="1" />
                                        <EMBED src="<?php echo $value['pic'] //图片 ?>" quality=high bgcolor=#FFFFFF width="40" height="40"
                                               NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash"
                                               PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">

                                    </object>
                                    <object class="popGoodPic click_fals showObj"
                                            type="application/x-shockwave-flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0"
                                            WIDTH="300" height="250" style="display: none;position: absolute;top: 0px;left: 60px;">
                                        <param name="movie" value='<?php echo $value['pic'] //图片 ?>'/>
                                        <param name="AutoStart" value="1" />
                                        <EMBED src="<?php echo $value['pic'] //图片 ?>" quality=high bgcolor=#FFFFFF width="300" height="250"
                                               NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash"
                                               PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">

                                    </object>
                                <?php else: ?>
                                    <img class="popGoodPic imgClick" src="<?php echo $value['pic'] //图片 ?>" title="<?php echo $value['pic'] ?>" style="width:50px;height:auto;" />
                                    <img src="<?php echo $value['pic'] ?>" class="showObj" alt="" style="display: none;position: absolute;top: 0px;left: 60px;width: 300px;height: 250px">
                                <?php endif; ?>
                            </a>
                        <?php }else{ echo '-';}?>
                    </td>

                    <td class="text-c"><?php echo $value['house_name']; ?></td>
                    <td class="text-c"><?php echo $value['user_name']; ?></td>
                    <td class="text-c"><?php echo $value['contact']; ?></td>
                    <td class="text-c"><?php echo $value['email']; ?></td>
                    <td class="text-c"><?php echo $value['phone']; ?></td>
                    <td class="text-c"><?php echo date("Y-m-d H:i:s",$value['create_time']); ?></td>
                    <td class="text-c"><?php echo $status[$value['put_status']]; ?></td>
                    <td class="text-c">
                        <select name="weight"  class="select weight" rel="<?php echo $value['id']; ?>" style="width: 100px">
                            <option value="1" <?php if($value['weight']==1){ echo 'selected';}?>>1</option>
                            <option value="2" <?php if($value['weight']==2){ echo 'selected';}?>>2</option>
                            <option value="3" <?php if($value['weight']==3){ echo 'selected';}?>>3</option>
                            <option value="4" <?php if($value['weight']==4){ echo 'selected';}?>>4</option>
                        </select>


                    </td>
                    <td class="text-c"><?php
                        if($value['review_status']==1){
                            echo "审核通过";
                        }elseif ($value['review_status']==2){
                            echo "不通过--".$value['reason'];
                        }else{
                            echo "未审核";
                        }
                        ?></td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 check"
                           href="javascript:;"
                           title="编辑" re="<?php echo $value['id'] ?>">
                            <i class="Hui-iconfont">&#xe6df;</i></a>
                    </td>
                </tr>
            <?php endforeach;endif; ?>
            </tbody>
        </table>
        <div class="text-r mt-5" id="page"></div>
    </div>

</div>

<style>
    .input-text_check {
        box-sizing: border-box;
        border: solid 1px #ddd;
        height: 27px;
        width: 65%;
        -webkit-transition: all .2s linear 0s;
        -moz-transition: all .2s linear 0s;
        -o-transition: all .2s linear 0s;
        transition: all .2s linear 0s;
    }
    .form_check{
        margin:15px 0;
    }
    .form_div_check{
        margin-top:15px;
        margin-bottom:15px;
        height: 27px;
    }
    .form_title{
        margin-left:20px;
        float: left;
        height: 20px;
        width: 180px;
        position: relative;
    }
 	.form_title span{
 		display: inline-block;
 		height: 20px;
 		width: 110px;
 		overflow: hidden;
 		white-space: nowrap;
 		text-overflow: ellipsis;
 		position: relative;
 		bottom: -5px;
 	}
 	.form_title em{
 		display: inline-block;
 		width: 200px;
 		border: 1px solid #ccc;
 		position: absolute;
 		top: 26px;
 		right: -100px;
 		background: #FFF5D4;
 		padding: 5px;
 		z-index: 100;
 		display: none;
 		font-style: normal;
 	}
 	.layui-layer{
			width: 850px !important;
	}
	.peoplePage {
		    width: 820px;
		    height: 210px;
		    margin: 0 auto;
		    margin-top: 20px;
		}
		.peoContent {
		    width: 367px;
		    height: 187px;
		    float: left;
		    border: 1px solid #dddddd;
		    font-size: 12px;
		}
		.centerPeo {
		    float: left;
		    width: 80px;
		    height: 187px;
		}
		.centerPeo .addPeo,
		.centerPeo .delPeo {
		    width: 50px;
		    height: 29px;
		    border: 1px solid #DDD;
		    line-height: 29px;
		    text-align: center;
		    margin: 10px auto;
		    cursor: pointer;
		}
		.centerPeo .addPeo {
		    margin-top: 58px;
		}
		.peoTitle {
		    height: 29px;
		    line-height: 29px;
		    text-align: center;
		    font-weight: 700;
		}
		.peoTitle {
		    border-bottom: 1px solid #dddddd;
		}
		.peoDetail {
		    height: 157px;
		    overflow: scroll;
		    overflow-x: hidden;
		}
		.detailTitle {
		    height: 30px;
		    font-weight: 700;
		    padding: 0 5px;
		}
		.detailcontentL {
		    float: left;
		    width: 104px;
		    text-align: center;
		    height: 30px;
		    line-height: 30px;
		    border-right: 1px solid #dddddd;
		    border-bottom: 1px solid #dddddd;
		}
		.detailcontentR {
		    width: 225px;
		    float: right;
		    text-align: center;
		    height: 30px;
		    line-height: 30px;
		    border-bottom: 1px solid #dddddd;
		}
		.peoContent li div {
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		    padding: 0 5px;
		}
		.peoContent li {
		    cursor: pointer;
		}
		.peoContent .clickCurrent {
		    background-color: #5bbfa6;
		}
		.percent {
		    margin-left: 23px;
		}
		.percentI {
		    width: 15px;
		    height: 15px;
		    display: inline-block;
		    background: url(../img/xiugai.png);
		    background-repeat: no-repeat;
		    vertical-align: middle;
		}
</style>
<div id="box" style="display: none;">
    <div class="form_check ">
        <form action="/Mars/advert/edit" method="post" id="form1">
            <input type="hidden" name="id" id="id" value=""/>
            <div class="form_div_check">
                <label class="form-label form_title ">楼盘特色：<span id="conditi"></span><em></em></label>
                <label class="form-label form_title">楼盘：<span id="muTitile"></span></label>
            </div>
            <div class="form_div_check">
                <label class="form-label col-xs-2 "><span class="c-red">&nbsp;</span>类型：</label>
                <div class="col-xs-5 " style="margin-left: -69px;">
                    <input type="text" class="input-text_check" value="pc" placeholder="" id="put_type" name="put_type" disabled="disabled" >
                </div>
            </div>
            <div class="peoplePage">
		        <div class="leftPeo peoContent" id="leftPeo">
		            <div class="peoTitle">人群包列表</div>
		                <div class="peoDetail">

		                </div>
		            </div>
		        <div class="centerPeo">
		            <div class="addPeo">添加</div>
		            <div class="delPeo">移除</div>
		        </div>
		        <div class="rightPeo peoContent" id="rightPeo">
		            <div class="peoTitle">人群包列表</div>
		            <div class="peoDetail">

		            </div>
		        </div>
		    </div>
            <div class="form_div_check">
                <label class="form-label col-xs-2"><span class="c-red">*</span>投放日期：</label>
                <div class="col-xs-4">
                    <input type="text" name="begin_time" class="input-text_check" id="starts" value="<?php echo fn_get_val('begin_time') ?>" />-

                </div>
                <div class="col-xs-4 ">
                    <input type="text" name="end_time" class="input-text_check" id="ends" value="<?php echo fn_get_val('end_time') ?>" />
                </div>
            </div>

            <div class="form_div_check">
                <label class="form-label col-xs-2 "><span class="c-red">&nbsp;</span>日限量：</label>
                <div class="col-xs-10 ">
                    <input type="text" class="input-text_check" value="" placeholder="" id="day_limit" name="day_limit">
                </div>
            </div>

            <div class="form_div_check">
                <label class="form-label col-xs-2 "><span class="c-red">*</span>上传图片：</label>
                <div class="col-xs-10 pic">
                    <img src="" alt="" style="width: 70px;"> &nbsp;<a href="#">更换图片</a>
                </div>
            </div>

            <div class="form_div_check">
                <label class="form-label col-xs-2 "><span class="c-red">*</span>创意名称：</label>
                <div class="col-xs-10 ">
                    <input type="text" class="input-text_check" value="" placeholder="" id="title" name="title">
                </div>
            </div>
            <div class="form_div_check">
                <label class="form-label col-xs-2 "><span class="c-red">&nbsp;</span>推广楼盘：</label>
                <div class="col-xs-10 ">
                    <input type="text" class="input-text_check" value="" placeholder="" id="house_name" name="house_name">
                </div>
            </div>
            <div class="form_div_check">
                <label class="form-label col-xs-2 "><span class="c-red">*</span>点击地址：</label>
                <div class="col-xs-10 ">
                    <input type="text" class="input-text_check" value="" placeholder="" id="click_url" name="click_url">
                </div>
            </div>
        </form>
    </div>
</div>

<form enctype="multipart/form-data" id="formF" name="fileinfo" style="display: none">
    <input type="text"  name="imgPic" id="imgPic">
    <input type="file" id="btnUpload" name="file"/>
</form>

<script type="textml" id="peoList">
        <div>
            <div class="detailTitle detailcontentL">人群包名称</div>
            <div class="detailTitle detailcontentR">所选条件</div>
        </div>
        <ul>
        {{# for(var i = 0, len = d.length; i < len; i++){ }}
            <li data-id="{{d[i].id}}">
                <div class="detailcontentL">{{d[i].name}}</div>
                <div class="detailcontentR">

                    {{# if(d[i].conditions.region) { }}
                        <span>区域：{{d[i].conditions.region}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.district) { }}
                        <span>板块：{{d[i].conditions.district}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.traffic) { }}
                        <span>地铁：{{d[i].conditions.traffic}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.estate) { }}
                        <span>物业类型：{{d[i].conditions.estate}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.state) { }}
                        <span>销售状态：{{d[i].conditions.state}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.plot_name) { }}
                        <span>楼盘：{{d[i].conditions.plot_name}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.region) { }}
                        <span>区域：{{d[i].conditions.region}}</span>
                    {{# } }}
                    {{# if(d[i].conditions.endPrice && d[i].conditions.startPrice) { }}
                        <span>价格：{{d[i].conditions.startPrice}} - {{d[i].conditions.endPrice}}</span>
                    {{# } else if(d[i].conditions.endPrice) { }}
                        <span>价格：{{d[i].conditions.endPrice}}以下</span>
                    {{# } else if(d[i].conditions.startPrice) { }}
                        <span>价格：{{d[i].conditions.startPrice}}以上</span>
                    {{# } }}
                    {{# if(!!d[i].conditions.qxname) { }}
                        <span>{{d[i].conditions.qxname}}</span>
                    {{# } }}
                </div>
            </li>
        {{# } }}
        </ul>
    </script>
<script>
    //放大镜
    $('.imgClick').on('mouseover', function() {
        $(this).siblings('.showObj').show()
    }).on('mouseout', function() {
        $(this).siblings('.showObj').hide()
    })

    $(".weight").on('click',function(){
        var id = $(this).attr('rel');
        var weight = $(this).val();
        $.ajax({
            url: '/Mars/advert/weight',
            type: 'get',
            dataType: 'json',
            data: {id:id,weight:weight},
            success: function(d) {
                layer.open({
                    content: '修改权重成功！',
                });
            }
        })
    })

    layui.use('laydate', function(){
        var laydate = layui.laydate;

        var start = {
            min: '2012-01-01 23:59:59'
            ,max: laydate.now()
            ,istoday: false
            ,choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };

        var end = {
            min: $("#start").val()
            ,max: $("#end").val()
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

        var starts = {
            min: laydate.now()
            ,max: $("#ends").val()
            ,istoday: false
            ,choose: function(datas){
                ends.min = datas; //开始日选好后，重置结束日的最小日期
                ends.start = datas //将结束日的初始值设定为开始日
            }
        };

        var ends = {
            min: laydate.now()
            ,max: $("#ends").val()
            ,istoday: false
            ,choose: function(datas){
                ends.min = datas; //开始日选好后，重置结束日的最小日期
                starts.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        document.getElementById('starts').onclick = function(){
            starts.elem = this;
            laydate(starts);
        }
        document.getElementById('ends').onclick = function(){
            ends.elem = this
            laydate(ends);

        }

    });
</script>
<script>

    var layer;
    var laytpl;
    layui.use('layer', function(layer){
        layer = layui.layer
    })
    layui.use('laytpl', function(){
        laytpl = layui.laytpl
    })


    var a = $("#box")
    $(".check").on("click", function() {
        var id = $(this).attr('re');
        $.ajax({
            url: '/Mars/advert/getInfo',
            type: 'get',
            dataType: 'json',
            data: {id:id},
            success: function(d) {
                if(d.ret == 0) {// 成功
                    var data = d.data;
                    Initialization();
                    voluation(data);

                        if(d.data){
                            allpeo = d.data.Crowdpack
                            oldpeo = d.data.AdvertPack
                            if(oldpeo.length > 0) {
                                $.each(allpeo, function(index, val) {
                                    $.each(oldpeo, function(i, v) {
                                        if(val) {
                                            if(val.id == v.id) {
                                                allpeo.splice(index, 1)
                                            }
                                        }
                                    });
                                });
                            }
                            peoList(allpeo, oldpeo)

                        }

                        var layer = layui.layer;
                        layer.open({
                            type: 1,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['420px', '450px'], //宽高
                            content: a,
                            btn: ['提交', '取消'],
                            yes: function(index, layero) {
                                var info = $('#form1').serialize();
                                var pic = $('.pic img').attr('src');
                                if(pic=='undefined' || !pic){
                                    pic = $('.pic embed').attr('src');
                                    if(pic=='undefined' || !pic){
                                        alert("开始时间不能为空");
                                        return false;
                                    }
                                }
                                info += '&pic='+pic;
                                var starts = $("#starts").val();
                                var ends = $("#ends").val();
                                if(!starts){
                                    alert("开始时间不能为空");
                                    return false;
                                }
                                if(!ends){
                                    alert("结束时间不能为空");
                                    return false;
                                }
                                //人群包
                                var id = []
                                $.each(oldpeo, function(index, val) {
                                    id.push(val.id)
                                });
                                if(id){
                                    info += '&pack_id='+id;
                                }

                                bmitInfo(info);
                                layer.close(index)
                            },
                            cancel : function(index, layero) {
                                layer.close(index)
                            },
                        });
                }
            }
        });

    });

    //添加删除事件，重新渲染模板引擎
    $('.addPeo').on('click', function() {
        if ($('.leftPeo .clickCurrent').length > 0) {
            var index = $('.leftPeo .detailcontentR.clickCurrent').parent().index()
            oldpeo.push(allpeo.splice(index, 1)[0])

            peoList(allpeo, oldpeo)
        }
    })

    $('.delPeo').on('click', function() {
        if ($('.rightPeo .clickCurrent').length > 0) {
            var index = $('.rightPeo .detailcontentR.clickCurrent').parent().index()
            allpeo.push(oldpeo.splice(index, 1)[0])

            peoList(allpeo, oldpeo)
        }
    });

    function peoList(leftPeo, rightPeo) {
        var table_obj = $("#leftPeo .peoDetail"); //左侧列表
        var rightTable_obj = $("#rightPeo .peoDetail"); //右侧列表
        var tpl = $('#peoList').html();
        laytpl(tpl).render(leftPeo, function (string) {
            table_obj.html(string);
        });
        laytpl(tpl).render(rightPeo, function (string) {
            rightTable_obj.html(string);
        });
        $('.leftPeo li, .rightPeo li').on('click', function() {
            $('.leftPeo li, .rightPeo li').children().removeClass('clickCurrent')
            $(this).children().addClass('clickCurrent')
        })
    }

    function checkPhoto(url) {
        if(url!='undefined' || !url){
            console.log(url.match(/([^\.]+)$/))
            type = url.match(/([^\.]+)$/)[0] || 0;
            type = type.toUpperCase().trim();
            if (type == "SWF" || type == "PNG" || type == "JPG" || type == "GIF") {
                if (type == "SWF") {
                    return 2;
                }
                return 1;
            } else {
                return 0;
            }
        }else{
            return 0
        }

    }

    function checkPic(url) {
        type = url.match(/^(.*)(\.)(.{1,8})$/)[3] || 0;
        type = type.toUpperCase();
        if (type != "SWF" && type != "PNG" && type != "JPG" && type != "GIF") {
            return 1;
        }
        return 0
    }

    /**
     * 赋值返回的信息
     * */
    function voluation(data){

        layui.use('laydate', function(){
            var laydate = layui.laydate;
            $("#starts").val(laydate.now(data.begin_time*1000));
            $("#ends").val(laydate.now(data.end_time*1000));
        });
        $('#muTitile').text(data.house_name);
        if(data.conditi){
            $("#conditi").text(data.conditi);
        }else{
            $("#conditi").text('无');
        }
        $("#day_limit").val(data.day_limit);
        var pic =checkPhoto(data.pic);
        picAdd(data.pic,pic);
        $("#title").val(data.title);
        $("#house_name").val(data.house_name);
        $("#click_url").val(data.click_url);
        $("#id").val(data.id);
    }

    /**
    * 初始化
    * */
    function Initialization(){
        $("#begin_time").val('');
        $("#end_time").val('');
        $('#muTitile').text('');
        $("#conditi").text('');
        $("#day_limit").val('');
        $(".pic img").attr("src",'');
        $("#title").val('');
        $("#house_name").val('');
        $("#click_url").val('');
        $("#id").val('');
    }


    /**
     * 编辑提交
     * */
    function  bmitInfo(data)
    {
        $.ajax({
            url: '/Mars/advert/edit',
            type: 'get',
            dataType: 'json',
            data: data,
            success: function (d) {
                layer.open({
                    content: '修改成功！',
                    yes: function(){ location.href='';}
                });
            }
        });
    }

    /**
    * 图片处理
    * */
    function picAdd(url,type)
    {
        if(type==1){
            $(".pic").children().remove();
            $(".pic").html('<img src="'+url+'" width="40" height="40" alt="" /><a href="#">更换图片</a>');
        }
        if(type==2){
            var html = "";
            html +="<object class='popGoodPic click_fals' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0' WIDTH='50'>";
            html +="<EMBED src='"+url+"' quality=high bgcolor=#FFFFFF width='40' height='40' NAME='myMovieName' ALIGN='' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'> </EMBED> </object><a href='#'>更换图片</a>";
            $(".pic").children().remove();
            $(".pic").html(html);
        }
    }

</script>

<script type="text/javascript">
	 var conditi1=document.getElementById("conditi");
     var ems=conditi1.nextElementSibling||conditi1.nextSibling;
     conditi1.onmouseover=function(){
     	var txt=conditi1.innerText;
     	ems.style.display="block";
     	ems.innerText=txt;
     	if(txt==""){
     		ems.style.display="none";
     	}
     }
     conditi1.onmouseout=function(){
     	ems.style.display="none";
     }
</script>

<script>
    /**
    * 图片替换
    * */
    $(".pic").on("click",'a', function() {
        $("#btnUpload").click();
        $("#btnUpload").change(function() {
            var isPhoto = checkPic($("#btnUpload").val());
            if (isPhoto == 1) {
                layer.open({
                    content: '文件类型不对！',
                });
            } else {
                var formData = new FormData($("#formF")[0]);
                $("#imgPic").val($("#btnUpload").val());
                $.ajax({
                    url: "/Mars/member/upload",
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false, // 告诉jQuery不要去处理发送的数据
                    contentType: false, // 告诉jQuery不要去设置Content-Type请求头
                    dataType: 'json',
                    success: function(data) {
                        if(data.data){
                            $("#pic").attr('src',data.data);
                            var pic =checkPhoto(data.data);
                            picAdd(data.data,pic);
                        }
                    }
                });
                $('#btnUpload').replaceWith(' <input name = "file" type="file" id="btnUpload"/>');
            }
        })

    });


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

