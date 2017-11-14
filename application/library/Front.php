<?php

class Front extends Web
{
    public function init()
    {
        parent::init();
//        $this->checkLogin();
//        $this->userInfo();
    }

    public function checkLogin()
    {
        if (!$this->_session->get('customer_info')) {
            $this->redirect("/member/login");
        }
    }

    public function userInfo()
    {
        $customer = new Model_Customer();
        $info = $this->_session->get('customer_info');
        $userInfo = $customer->get('*',['id'=>$info['id']]);
        $this->assign('data',$this->_c);
        $this->assign('userInfo', $userInfo);
    }

}