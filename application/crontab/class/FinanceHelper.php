<?php
abstract class FinanceHelper
{

    protected $_db_config = array();
    protected $_db = NULL;

    public function __construct()
    {
        $this->set_config();
    }

    protected function set_config()
    {
        $_config = require 'config.php';

        $this->_db_config = $_config['mysql'];
    }

    protected function get_mysql_connect()
    {
        if ( !$this->_db )
        {
            $this->_db = new Smodel( $this->_db_config );
        }
        return $this->_db;
    }

    function fn_get_contents($url, $keysArr = array(), $mothod = 'get', $return_status = 0, $is_header = 1, $flag = 0)
    {
        $ch = curl_init();
        if (!$flag) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (strtolower($mothod) == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
        } else {
            $url = $url . "?" . http_build_query($keysArr);
        }
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($is_header) {
            $headers['keyAuth'] = md5($this->fn_get_crontab_key());
            $headers['keyVa'] = md5($this->fn_get_crontab_key().$this->fn_get_finance_key());
            foreach ($headers as $n => $v) {
                $headerArr[] = md5($n) . ':' . $v;
            }
            $headerArr[] = "Authorized:".md5($this->fn_get_finance_key());
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        }

        $ret = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($return_status == "1") {
            return array($ret, $code);
        }

        return $ret;
    }

    /**
     * crontab接口key
     */

    function fn_get_crontab_key()
    {
        $crontab_key = "*v*5&~As#841$29^^15%oO*7a";
        return $crontab_key;
    }

    /**
     * finance接口key
     */

    function fn_get_finance_key()
    {
        $finance_key = "~ds#a&84^24*os$74fg";
        return $finance_key;
    }

}
