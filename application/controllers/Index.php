<?php

/**
 * Created by IntelliJ IDEA.
 * User: zb
 * Date: 16-12-5
 * Time: 下午1:39
 */
class Controller_Index extends Base
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
        $this->display('index/index');
    }
}