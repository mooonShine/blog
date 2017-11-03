<?php
//1000    参数错误
//1001    无用户信息
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/7
 * Time:  17:23
 */
class Controller_Interface extends Web
{

    private $allow_ip = array(
        'ip' => array(
            '122.225.98.67',
            '122.225.98.68',
            '122.225.98.69',
            '122.225.98.70',
            '122.225.98.71',
            '122.225.98.72',
            '122.225.98.73',
            '122.225.98.74',
            '122.225.98.75',
            '122.225.98.76',
            '122.225.98.77',
            '122.225.98.78',
            '122.225.98.79',
            '122.225.98.80',
            '122.225.98.81',
            '122.225.98.82',
            '122.225.98.83',
            '122.225.98.84',
            '122.225.98.85',
            '122.225.98.86',
            '122.225.98.87',
            '122.225.98.88',
            '122.225.98.89',
            '122.225.98.90',
            '122.225.98.91',
            '122.225.98.92',
            '122.225.98.93',
            '122.225.98.94',
            '122.225.98.95',
            '122.225.98.96',
            '122.225.98.97',
            '122.225.98.98',
            '122.225.98.99',
            '122.225.98.100',
            '192.168.1.112',
            '192.168.1.199',
            '192.168.1.130',
            '192.168.1.122',
            '192.168.1.123',
            '192.168.1.129',
            '192.168.1.119',
            '192.168.1.117',
            '192.168.1.116',
            '115.197.137.127',
            '127.0.0.1',
            '192.168.1.146',
            '192.168.1.147',
            '115.192.123.147',
            '192.168.1.132',
            '103.227.76.156',
            '192.168.1.118',
            '192.168.1.135',
            '192.168.1.120',
            '192.168.1.134',
            '192.168.1.121',
            '192.168.1.127',
            '192.168.1.116',
        )
    );
    protected $model_user = '';
    private $interface_key = '';
    protected $model_log='';

    public function init()
    {
        parent::init();
        $this->model_user = new Model_User();
        $this->log = new Model_Log();
        $this->interface_key = fn_get_interface_key();
    }

    public function ZhiAction()
    {
        $this->check_allow("ip", "zhi");
    }
    private function check_allow($allow_ip, $from)
    {
        $ip = fn_get_ip();
        $ktime = $this->_request->getServer('HTTP_8706C971C8BE6CDE39DDEF6A39C36572'); //'HTTP_'. strtoupper(md5('ktime'))
        $kmd5 = $this->_request->getServer('HTTP_6B7D574EAA7A0F332F05624E17F4BE01'); //'HTTP_'. strtolower(md5('kmd5'))
        if (!$ktime || !$kmd5 || !in_array($ip, $this->allow_ip[$allow_ip]) || md5($ktime . $this->interface_key) != $kmd5) {
            fn_ajax_return(1, "无权限" . $ip);
        }
        $type = $this->_request->getPost('type');

        $action = "action_" . $from . "_" . $type;
        if (!method_exists($this, $action)) {
            fn_ajax_return(1, "无动作");
        }
        $this->type = $type;
        $this->$action();
    }

    /**
     * @Author: zhanghuang@pv25.com
     * 修改用户信息接口
     * since 2016-12-7
     */
    private function action_zhi_updateUser()
    {
        $username = $this->_request->getPost('username');
        $uid = $this->_request->getPost('uid');
        if (!$uid || !is_numeric($uid) || !is_int($uid - 0)) {
            fn_ajax_return(1, '', array('err_code' => 1000));
        }
        if (!$username) {
            fn_ajax_return(1, '', array('err_code' => 1000));
        }
        $rs = $this->model_user->getUser('*',$uid);
        if($rs){
            $res=$this->model_user->updateUserName($username,array('zhi_userid'=>$uid));
            if ($res===false) {
                fn_ajax_return(1, '用户信息更新失败');
            }
        }else{
            fn_ajax_return(1, '', array('err_code' => 1001));
        }
        fn_ajax_return(0, '用户信息更新成功');
    }
}