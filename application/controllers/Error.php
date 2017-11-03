<?php

/**
 * Description of Error
 *
 * @author Sgenmi
 */
class Controller_Error extends Yaf_Controller_Abstract
{

    public function errorAction($exception)
    {
        switch ($exception->getCode()) {
            case YAF_ERR_NOTFOUND_MODULE:
            case YAF_ERR_NOTFOUND_CONTROLLER:
            case YAF_ERR_NOTFOUND_ACTION:
            case YAF_ERR_NOTFOUND_MODULE:
                $this->E404($exception);
                break;
            default :
                $message = $exception->getMessage();
                echo 0, ":", $exception->getMessage();
                break;
        }

        Yaf_Dispatcher::getInstance()->disableView();
    }

    private function E404($error)
    {
        if (DEVELOPMENT) {
            echo 404, ":", str_replace(BASE_PATH, "", $error->getMessage());
        } else {
            $this->getView()->setLayout('index');
            $this->display('errorPage', array('noLeft' => true, 'noright' => true));
        }
    }

    /**
     * url错误。
     * 如参数非法数据
     */
    public function showMsg($msg, $code)
    {
        echo sprintf('错误消息：%s，错误代码：%d 点击<a href="http://ssp.juhuisuan.com">这里</a>返回首页', $msg, $code);
    }

}

?>
