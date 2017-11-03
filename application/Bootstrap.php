<?php

/**
 * Description of Bootstrap
 *
 * @author sjm
 * @date 2013-09-02
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{

    private $_config;

    //配置考备
    public function _initBootstrap()
    {
        $this->_config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->_config);
    }

    //是否开始错语报告，上线后，一定要关掉
    public function _initErrors()
    {
        if ($this->_config->application->showErrors)
        {
            ini_set( 'display_errors', 'On' );
        } else
        {
            error_reporting( 0 );
            ini_set( 'display_errors', 'Off' );
        }
    }

    //初始化引入目录，本地类库目录
    public function _initIncludePath()
    {
        set_include_path( get_include_path() . PATH_SEPARATOR . $this->_config->application->library );
    }

    //导入公共库
    public function _initCommon()
    {
        Yaf_Loader::import( "Common.php" );
    }

    //初始化路由
    public function _initRoutes( Yaf_Dispatcher $dispatcher )
    {
        $router = $dispatcher->getRouter();
    }

    //初始化视图模板
    public function _initLayout( Yaf_Dispatcher $dispatcher )
    {
        $layout = new Layout( $this->_config->application->layout->directory );
        $dispatcher->setView( $layout );
    }

    //初始化错误处理
    public function _initErrorConst()
    {
        //URL参数错误
        define( "YAF_ERR_URL", 600 );
        //数据错误
        define( "YAF_ERR_DATA", 601 );
    }

}
