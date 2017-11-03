<?php

/**
 * Description of Web
 *
 * @author Sgenmi
 * @date 2014-02-18
 */
class Web extends Yaf_Controller_Abstract
{

	protected $_session;
    protected $layout;
    protected $_config;
    protected $_request;
    protected $view_path;
    protected $_m;
    protected $_c;
    protected $_a;

    public function init()
    {
        //配置项
        $this->_config = Yaf_Application::app()->getConfig();
        $this->_session = new Component_Session;
        //请求信息
        $this->_request = $this->getRequest();
        $this->_m = strtolower($this->getRequest()->getModuleName());
        $this->_c = strtolower($this->getRequest()->getControllerName());
        $this->_a = strtolower($this->getRequest()->getActionName());
        //设置模板页
        $this->getView()->setLayout($this->layout);
        //防止自动渲染模板页
        Yaf_Dispatcher::getInstance()->disableView();
        //账号定义
        DEFINE('PERMI_ADMIN',1);//大账号
        DEFINE('PERMI_FINANCIAL_LOOK',2);//财务(看)
        DEFINE('PERMI_FINANCIAL',3);//财务
        DEFINE('PERMI_SALES',4);//销售
        DEFINE('PERMI_SITE',5);//站内
        DEFINE('PERMI_AGENT',6);//代理
        DEFINE('PERMI_GOOGLE',7);//谷歌
        DEFINE('PERMI_DATA',8);//数据
        DEFINE('PERMI_COST',9);//渠道
        //部门定义
        DEFINE('DEPART_SALES',1);//销售部
        DEFINE('DEPART_SITE',2);//站内
        DEFINE('DEPART_AGENT',3);//代理
        DEFINE('DEPART_GOOGLE',4);//谷歌
        DEFINE('DEPART_DATA',5);//数据
        DEFINE('DEPART_COST',6);//渠道
        //判断子账号添加过期日期号
        DEFINE('TIME_START_DAY',10);
        DEFINE('TIME_END_DAY',26);
    }

    //渲染视图
    protected function display($view_path = NULL, array $tpl_vars = array())
    {
        if (empty($view_path)) {
            $this->set_view_path($this->_c . '/' . $this->_a);
        } elseif (strpos($view_path, '/')) {
            $this->set_view_path($view_path);
        } else {
            $this->set_view_path($this->_c . '/' . $view_path);
        }
        self::getView()->display($this->view_path, $tpl_vars);
        return;
    }

    /**
     * 返回视图->实际是在视图中，加载另一个视图用
     */
    public function render($view_path = NULL, array $tpl_vars = array())
    {
        if (!$this->set_view_path($view_path)) {
            return;
        }
        echo $this->getView()->render($this->view_path, $tpl_vars);
    }

    /**
     * 给视图中变量赋值
     */
    protected function assign($name = NULL, $value = NULL)
    {
        if (!$name) {
            return;
        }

        if (is_string($name)) {
//            if (!$value) {
//                return;
//            }
            return $this->getView()->assign($name, $value);
        } else {
            return $this->getView()->assign($name);
        }
    }

    /**
     * 设置视图路径
     * @param  string $view_path
     * @return boolean
     */
    private function set_view_path($view_path)
    {
        $fileInfo = pathinfo($view_path);
        if (!isset($fileInfo['extension'])) {
            $view_path .= "." . $this->_config->application->view->ext;
        }
        $this->view_path = $view_path;
        return TRUE;
    }

}
