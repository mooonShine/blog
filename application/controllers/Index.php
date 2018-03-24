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
    private $class;
    public function init()
    {
        $this->class = new Model_Class();
        $all = $this->class->select(['id','name'],['is_del' => 0]);
        $this->assign('all', $all);
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
    public function single1Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single1');
    }
    public function single2Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single2');
    }
    public function single3Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single3');
    }
    public function single4Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single4');
    }
    public function single5Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single5');
    }
    public function single6Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single6');
    }
    public function single7Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single7');
    }
    public function single8Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single8');
    }
    public function single9Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single9');
    }
    public function single10Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single10');
    }
    public function single11Action()
    {
        $this->assign('data', 'sub');
        $this->display('index/single11');
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