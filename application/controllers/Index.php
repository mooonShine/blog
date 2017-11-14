<?php

/**
 * Created by IntelliJ IDEA.
 * User: zb
 * Date: 16-12-5
 * Time: 下午1:39
 */
class Controller_Index extends Front
{
    protected $layout = 'layouts';
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
        $this->assign('data', 'index');
        $this->display('index/index');
    }
    public function singleAction()
    {
        $this->assign('data', 'sub');
        $this->display('index/single');
    }
    public function archiveAction()
    {
        $this->assign('data', 'sub');
        $this->display('index/archive');
    }
    public function contactAction()
    {
        $this->assign('data', 'sub');
        $this->display('index/contact');
    }
}