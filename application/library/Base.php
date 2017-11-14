<?php

class Base extends Web
{
    protected $user;

    public function init()
    {
        parent::init();
        $this->checkLogin();
    }

    private function checkLogin()
    {
        if (!$this->_session->get('userinfo')) {
            $this->redirect("/Mars/member/login");
            exit;
        }
    }

    /**
     * @param $date
     * @return array
     * 获取某个月的第一天和最后一天
     */
    public function getthemonth($date)
    {
        $firstday = date('Y-m-01', $date);
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
        return array($firstday, $lastday);
    }

}