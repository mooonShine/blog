<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 用户管理
    <span class="c-gray en">&gt;</span> 添加文章
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<script type="text/javascript" src="/wangEdit/release/wangEditor.min.js"></script>
<div class="page-container">
    <form action="/Mars/article/add" method="post" class="form form-horizontal" id="form-article-add">
        <!--        <div class="row cl">-->
        <!--            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>账户信息：</label>-->
        <!--            <div class="formControls col-xs-8 col-sm-9">-->
        <!--                <input type="radio" id="radio2"  value="2" name="user_type" checked>-->
        <!--                <label for="radio-1">公司账号</label>-->
        <!--                <input type="radio" value="1" id="radio1" name="user_type">-->
        <!--                <label for="radio-1">个人账号</label>-->
        <!--            </div>-->
        <!--        </div>-->
        <input type="hidden" name="applyId" id="applyId" value="<?php echo isset($applyId)?$applyId:''; ?>" />
        <?php if(isset($applyId) && $applyId) {?>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4 "><span class="c-red">正在为申请客户<?php echo isset($phone)?$phone:''; ?>开通账号</span></label>
            </div>
        <?php }?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo fn_get_val("title") ?>" placeholder="请输入标题" id="title" name="title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="class_id" id="class_id" class="select" style="width: 100px">
                    <option value="0">无</option>
                    <?php if($class){
                        foreach ($class as $key=>$value){
                            ?>
                            <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                        <?php } } ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>上传文件：</label>
            <div class="formControls col-xs-8 col-sm-9" >
                <img alt="" id="imgs" class="radius" style="width: 60px;height: 60px;float: left;">
                <input type="hidden" name="pic" id="pic" value="">
                <span class="btn-upload" style="padding-top: 20px">
<!--                <a href="javascript:void();" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>-->
                <input type="file" multiple name="m_pic" class="input-file" value="" id="uploadfy">
            </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章内容：</label>
            <div class="formControls col-xs-8 col-sm-9"  id="editor">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>署名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="signature" name="signature" value="<?php echo fn_get_val("signature") ?>" placeholder="请输入署名">
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
    <script type="text/javascript" src="/js/uploadify/jquery.uploadify.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/uploadify/uploadify.css">
</div>
<script>

    //    jQuery.validator.addMethod("isMobile", function(value, element) {
    //        var length = value.length;
    //        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
    //        return this.optional(element) || (length == 11 && mobile.test(value));
    //    }, "请正确填写您的手机号码");
    //    jQuery.validator.addMethod("isPassword", function(value, element) {
    //        var length = value.length;
    //        var pass = /^([0-9]+)([a-zA-Z]+)([0-9a-zA-Z]*){6,20}$|^([a-zA-Z]+)([0-9]+)([0-9a-zA-Z]*){6,20}$/;
    //        return this.optional(element) || (length >= 6 && pass.test(value));
    //    }, "密码必须为6到20位的字母数字组合");
    //
    //    jQuery.validator.addMethod("isUsername", function(value, element) {
    //        var returnVal;
    //
    //        $.ajax({
    //            url: '/Mars/Customer/verification',
    //            type: 'POST',
    //            dataType: 'json',
    //            async: false,
    //            data: {user_name: value},
    //            success: function(d) {
    //                //1存在 0正常
    //                if(d.ret == 0) {
    //                    returnVal = true;
    //                } else {
    //                    returnVal = false;
    //                }
    //            }
    //        });
    //        return returnVal
    //    }, "用户名重复");

    //    jQuery.validator.addMethod("isPhoneNum", function(value, element) {
    //        var returnVal;
    //
    //        $.ajax({
    //            url: '/Mars/Customer/verification',
    //            type: 'POST',
    //            dataType: 'json',
    //            async: false,
    //            data: {phone: value},
    //            success: function(d) {
    //                //1存在 0正常
    //                if(d.ret == 0) {
    //                    returnVal = true;
    //                } else {
    //                    returnVal = false;
    //                }
    //            }
    //        });
    //        return returnVal
    //    }, "手机号重复");
    //    jQuery.validator.addMethod("isEmailSame", function(value, element) {
    //        var returnVal;
    //
    //        $.ajax({
    //            url: '/Mars/Customer/verification',
    //            type: 'POST',
    //            dataType: 'json',
    //            async: false,
    //            data: {email: value},
    //            success: function(d) {
    //                //1存在 0正常
    //                if(d.ret == 0) {
    //                    returnVal = true;
    //                } else {
    //                    returnVal = false;
    //                }
    //            }
    //        });
    //        return returnVal
    //    }, "邮箱重复");
    //
    //    var rules = {
    //        user_name: {
    //            isUsername: true,
    //            required: true,
    //        },
    //        password: {
    //            required: true,
    //            minlength: 6,
    //            isPassword: true
    //        },
    //        repassword : {
    //            required: true,
    //            minlength: 6,
    //            equalTo: "#password"
    //        },
    //        contact: "required",
    //        phone: {
    //            required: true,
    //            isMobile: true,
    //            isPhoneNum: true
    //        },
    //        email: {
    //            required: true,
    //            email: true,
    //            isEmailSame: true
    //        },
    //        real_name: {
    //            required: true,
    //        },
    //    }
    //
    //
    //    $("#radio1").click(function(){
    //         $("#company").hide();
    //        $("#company_name").rules("remove")
    //    });
    //    $("#radio2").click(function(){
    //        $("#company").show();
    //        $("#company_name").rules("add",{required: true})
    //    });
    //    var a = $("#form-article-add").validate({
    //        rules: rules
    //    })
    //    $("#real_name").rules()
    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('#editor') )
    editor.create();

    $("#btnSub").on("click", function() {
        var data = {
//            title: $("input[name='title']:checked").val().trim(),
            title: $("#title").val().trim(),
            class_id: $("#class_id").val().trim(),
            pic: $("#pic").val().trim(),
            content: editor.txt.html(),
            signature: $("#signature").val().trim(),
        }
        var succ_url='/Mars/article/index';
        if(data.title == ""||data.title ==null||data.title ==undefined) {
            $("#title").addClass('error');
            return false
        }
        if(data.class_id == ""||data.class_id ==null||data.class_id ==undefined) {
            $("#class_id").addClass('error');
            return false
        }
        if(data.pic == ""||data.pic ==null||data.pic ==undefined) {
            $("#pic").addClass('error');
            return false
        }
        if(data.content == ""||data.content ==null||data.content ==undefined) {
            $("#content").addClass('error');
            return false
        }
        if(data.signature == ""||data.signature ==null||data.signature ==undefined) {
            $("#signature").addClass('error');
            return false
        }
        $.ajax({
            url: '/Mars/article/add',
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
    $(function () {

        //图片上传
        $("#uploadfy").uploadify({
            'swf': '/js/uploadify/uploadify.swf',//uploadify.swf 文件的路径（绝对路径、相对路径都可以）
            uploader: '/Mars/customer/upload',//服务器响应地址
            multi: true,//是否多文件
            auto: true,//是否自动上传，true，选择文件后上传，false，点击上传开始上传，默认true
            removeCompleted: false,
            removeTimeout: 60,
            buttonText: "上传文件",//空间名称
            preventCaching: false,//是否缓存
            fileSizeLimit: 1024 * 1024 * 10,//单个文件限制大小
            //fileTypeDesc: '*.jpg;*.png;*.doc;*.txt;*.zip;*.rar;',//文件后缀描述
            fileTypeExts: '*.jpg;*.png;*.xls;*.pdf;*.xlsx;',//文件后缀限制
            height: 20,//高度
            width: 80,
            uploadLimit: 5,
            onUploadSuccess: function (file, data, response) {//上传成功后事件
                data = eval('(' + data + ')');
                if (data.ret == 1) { //data 返回值自己在后端自定义
                    //自己的代码
                    layer.msg(data.msg);
                    $("#imgs").attr("src", data.data);
                    $("#pic").val(data.data);
                    return;
                } else {
                    layer.msg('上传失败');
                    return;
                }
                //$(".waitImg").last().css("background", "url(" + data.data + ") no-repeat").css("background-size", "48px 48px")
                //imgOver();
            }
        });
    })

</script>