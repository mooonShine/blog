<?php
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/6
 * Time:  10:13
 */
class Controller_Member extends Front
{
    protected $log='';
    public function init()
    {
        parent::init();
        $this->log = new Model_Log();
    }

    /**
     * 后台用户登录
     */
    public function loginAction()
    {
        if($this->getRequest()->isPost())
        {
            $username = trim($this->_request->getPost('username'));
            $password = trim($this->_request->getPost('password'));
            $this->assign('username',$username);
            //判断用户提交的信息是否为空
            if(!$username || !$password)
            {
                echo json_encode(array('type'=>'fail','msg'=>'用户名或密码不能为空！'));
                exit;
            }

            //登陆
            $Model_Admin = new Model_Admin();
            $admin = $Model_Admin->login($username,$password);
            if(empty($admin)||$admin['ret']==1) {
                echo json_encode(array('type'=>'fail','msg'=>'用户名或密码错误！'));
                die;
            }

            if(isset($admin) && !empty($admin)) {
                $this->_session->set('ADMIN_ID',$admin['data']['id']);
                $this->_session->set('PERMI_ID',$admin['data']['permi_id']);
                $this->_session->set('USERNAME',$admin['data']['username']);
                $data=getAuthName($_SESSION['PERMI_ID']).'登录,登录ip:'.fn_get_ip();
                $this->log->add(4,$data);
                echo json_encode(array('type'=>'success'));
            }
        }
        else
        {
            $ADMIN_ID = $this->_session->get("ADMIN_ID");
            if($ADMIN_ID) {
                Header("Location: /");
            }
            $this->display("member/login");
        }
    }

    /**
     * 退出清空session
     */
    public function logoutAction(){
        $this->_session->del('log_count');
        if (isset($_SESSION['ADMIN_ID']))
        {
            $data=getAuthName($_SESSION['PERMI_ID']).'退出系统,登录ip:'.fn_get_ip();
            $this->log->add(5,$data);
            $this->_session->del('ADMIN_ID');
            unset($_SESSION);
            session_destroy();
            $this->display("member/login");
        }
        else
        {
            $this->display("member/login");
        }
    }

    /**
     * 验证码
     */
    public function codeAction()
    {
        fn_get_code();
    }

    /**
     * 更改用户密码
     */
    public function passwordAction(){
        if($this->_request->isPost()){
            $pwd1 = trim($this->_request->getPost('password'));
            $pwd2 = trim($this->_request->getPost('pwd'));
            $user = trim($this->_request->getPost('user'));
            if (!$pwd1 || !$pwd2){
                fn_json_return(300,'密码不能为空！');
                exit;
            }
            if($pwd1!=$pwd2){
                fn_json_return(300,'两次密码输入不正确！');
                exit;
            }
            $username = $user?$user:$_SESSION['ADMIN_NAME'];
            $val = array('username'=>$username,'pwd'=>$pwd1,'id'=>$_SESSION['ADMIN_ID']);
            $data = array('type'=>'update','info'=>json_encode($val));
            $info = json_decode(fn_get_contents($this->user_url,$data,'post'),true);
            if($info && isset($info['data']) && $info['ret']==0){
                fn_json_return(200,'修改成功！');
                exit;
            }else{
                fn_json_return(300,'修改失败！');
                exit;
            }
        }else{
            $this->display("member/password");
        }

    }
}