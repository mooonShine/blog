<?php
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/6
 * Time:  11:25
 */
class Admin extends Web
{

    public function init()
    {
        parent::init();
//        $this->checkLogin();
    }

    public function checkLogin()
    {
        if (!$this->_session->get('ADMIN_ID')) {
            $this->redirect("/member/login");
        }
    }

}