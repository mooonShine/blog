<?php

//Error handle
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
            default:
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
            $this->display('404', array('noLeft' => true, 'noright' => true));
        }
    }
}
