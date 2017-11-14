<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 用户管理
    <span class="c-gray en">&gt;</span> 添加用户
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

<div class="page-container">
    <form action="/customer/add" method="post" class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户信息：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="radio" id="radio2"  value="2" name="user_type" checked>
                <label for="radio-1">公司账号</label>
                <input type="radio" value="1" id="radio1" name="user_type">
                <label for="radio-1">个人账号</label>
            </div>
        </div>
        <input type="hidden" name="applyId" id="applyId" value="<?php echo isset($applyId)?$applyId:''; ?>" />
        <?php if(isset($applyId) && $applyId) {?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-4 "><span class="c-red">正在为申请客户<?php echo isset($phone)?$phone:''; ?>开通账号</span></label>
        </div>
        <?php }?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>用户名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="user_name" name="user_name" value="<?php echo fn_get_val("user_name") ?>" placeholder="请输入用户名" id="username" name="username">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="请输入密码" id="password" name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="请重新输入密码" id="repassword" name="repassword"  equalTo:"#password">
            </div>
        </div>
        <div class="row cl" id="company">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="请输入公司名称" id="real_name" name="real_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系人：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="请输入联系人" id="contact" name="contact">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>手机号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="请输入手机号" id="phone" name="phone">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>邮箱：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="请输入邮箱" id="email" name="email">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>金额转换流量比率：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="每pv对应价格" id="frate" name="frate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>代理：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="pid" id="pid" class="select" style="width: 100px">
                    <option value="0">无</option>
                    <?php if($agent){
                        foreach ($agent as $key=>$value){
                        ?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button id="btnSub" class="btn btn-primary radius" type="button"><i
                            class="Hui-iconfont">&#xe632;</i> 添加
                </button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">
                    &nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>

    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.min.js"></script>
</div>
<script>


    jQuery.validator.addMethod("isMobile", function(value, element) {  
        var length = value.length;  
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;  
        return this.optional(element) || (length == 11 && mobile.test(value));  
    }, "请正确填写您的手机号码");
    jQuery.validator.addMethod("isPassword", function(value, element) {
        var length = value.length;
        var pass = /^([0-9]+)([a-zA-Z]+)([0-9a-zA-Z]*){6,20}$|^([a-zA-Z]+)([0-9]+)([0-9a-zA-Z]*){6,20}$/;
        return this.optional(element) || (length >= 6 && pass.test(value));
    }, "密码必须为6到20位的字母数字组合");

    jQuery.validator.addMethod("isUsername", function(value, element) {
        var returnVal;

        $.ajax({
            url: '/Mars/Customer/verification',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {user_name: value},
            success: function(d) {
                //1存在 0正常
                if(d.ret == 0) {
                    returnVal = true;
                } else {
                    returnVal = false;
                }
            }
        });
        return returnVal
    }, "用户名重复");

    jQuery.validator.addMethod("isPhoneNum", function(value, element) {
        var returnVal;

        $.ajax({
            url: '/Mars/Customer/verification',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {phone: value},
            success: function(d) {
                //1存在 0正常
                if(d.ret == 0) {
                    returnVal = true;
                } else {
                    returnVal = false;
                }
            }
        });
        return returnVal
    }, "手机号重复");
    jQuery.validator.addMethod("isEmailSame", function(value, element) {
        var returnVal;

        $.ajax({
            url: '/Mars/Customer/verification',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {email: value},
            success: function(d) {
                //1存在 0正常
                if(d.ret == 0) {
                    returnVal = true;
                } else {
                    returnVal = false;
                }
            }
        });
        return returnVal
    }, "邮箱重复");

    var rules = {
        user_name: {
            isUsername: true,
            required: true,
        },
        password: {
            required: true,
            minlength: 6,
            isPassword: true
        },
        repassword : {
            required: true,
            minlength: 6,
            equalTo: "#password"
        },
        contact: "required",
        phone: {
            required: true,
            isMobile: true,
            isPhoneNum: true
        },
        email: {
            required: true,
            email: true,
            isEmailSame: true
        },
        real_name: {
            required: true,
        },
    }


    $("#radio1").click(function(){
         $("#company").hide();
        $("#company_name").rules("remove")
    });
    $("#radio2").click(function(){
        $("#company").show();
        $("#company_name").rules("add",{required: true})
    });
    var a = $("#form-article-add").validate({
        rules: rules
    })
    $("#real_name").rules()

    $("#btnSub").on("click", function() {
        var data = {
            user_type: $("input[name='user_type']:checked").val().trim(),
            user_name: $("#user_name").val().trim(),
            password: $("#password").val().trim(),
            repassword: $("#repassword").val().trim(),
            real_name: $("#real_name").val().trim(),
            contact: $("#contact").val().trim(),
            phone: $("#phone").val().trim(),
            email: $("#email").val().trim(),
            frate: $("#frate").val().trim(),
            applyId: $("#applyId").val().trim(),
            pid: $("#pid").val().trim()
        }
        var succ_url='/Mars/customer/index';
        if(data.user_name == ""||data.user_name ==null||data.user_name ==undefined) {
            $("#user_name").addClass('error');
            return false
        }
        if(data.password == ""||data.password ==null||data.password ==undefined) {
            $("#password").addClass('error');
            return false
        }
        if(data.contact == ""||data.contact ==null||data.contact ==undefined) {
            $("#contact").addClass('error');
            return false
        }
        if(data.phone == ""||data.phone ==null||data.phone ==undefined) {
            $("#phone").addClass('error');
            return false
        }
        if(data.email == ""||data.email ==null||data.email ==undefined) {
            $("#email").addClass('error');
            return false
        }
        if(data.frate == ""||data.frate ==null||data.frate ==undefined) {
            $("#frate").addClass('error');
            return false
        }

        var exc =  /^1[34578]{1}\d{9}$/;

        if(data.phone == "" || !exc.test(data.phone)) {
            $("#phone").addClass('error');
            return false
        }
        $.ajax({
            url: '/Mars/customer/add',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(d) {
                if(d.ret == 0) {// 成功
                    layer.open({
                        content: '添加成功！',
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
    })


    
</script>
