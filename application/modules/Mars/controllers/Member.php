<?php

/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Time:  10:13
 */
class Controller_Member extends Web
{
    protected $layout = 'layouts';

    public function init()
    {
        parent::init();
    }

    /**
     * 后台用户登录
     */
    public function loginAction()
    {
        $um = new Model_Admin();
        $this->getView()->setLayout("");
        if ($this->_request->isXmlHttpRequest()) {
            $info = $this->_request->getPost();
            $res = $um->loginCheck($info);
            if (is_string($res)) {
                fn_ajax_return(1, $res, "");
            } else {
                if ($info['isc'] == 1) {
                    setcookie("uid", fn_authcode($res['id'], "ENCODE"), time() + 7 * 86400, "/", null, null, true);
                }
                //修改登录信息
                $um->editLoginInfo(['last_time' => time(), 'last_ip' => ip2long(fn_get_ip()), 'id' => $res['id']]);
                $this->_session->set("userinfo", $res);
                fn_ajax_return(0, "");
            }
        }

        $this->display("index/login");
    }


    /**
     * 验证码
     */
    public function codeAction()
    {
        fn_get_code();
    }

    /**
     * 上传图片
     * 添加数据使用
     * */
    public function uploadAction()
    {
        if(!isset($_FILES['file']['name'])) fn_ajax_return(0,'上传错误','');
        $result = json_decode(fn_upload_img('file'),true);
        fn_ajax_return(0,'上传成功!',$result['data']);
    }


    /**
     * 退出清空session
     */
    public function logoutAction(){
        $this->_session->del('userinfo');
        $this->display("index/index");
    }

}