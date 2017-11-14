<?php

class Controller_Index extends Base
{
    /**
     * @Author: zhanghuang@pv25.com
     *   添加初始化
     */
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $this->display('index/index');
    }

    public function mainAction()
    {
        $this->getView()->setLayout("");
        $this->display("index/main");
    }
}
