<?php

/**
 * Description of memcache
 *
 * @author sgenmi
 * @date 2014-04-10
 */
class Component_Memcache
{

    private $_mem_config = Array(
        0 => array(
            'host' => "192.168.0.69",
            'port' => 11311,
            'weight' => 1
        )
    );
    private $_mem = NULL;
    public $is_connect = FALSE;
    protected static $_instance = NULL;

    public static function initialise()
    {
        if (NULL === self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $_mem_config = Yaf_Application::app()->getConfig()->toArray();

        if (isset( $_mem_config['memcache']['params'] ))
        {
            $this->_mem_config = $_mem_config['memcache']['params'];
        }

        $this->_mem = new Memcache();
        $this->_mem_connect();
    }

    private function _mem_connect()
    {
        foreach ($this->_mem_config as $v)
        {
            if ($this->_mem->connect( $v['host'], $v['port'] ))
            {
                //如果连接出问题,做出报告
                $this->is_connect = TRUE;
                break;
            }
        }
        
        if( !$this->is_connect  )
        {
            $this->_mem = FALSE;
        }
    }

    public function set( $key = NULL, $value = NULL, $expire = 0 )
    {
        if (!$key || !is_int( $expire - 0 ) || !$this->_mem)
        {
            return FALSE;
        }
        $value = json_encode($value);
        return $this->_mem->set( $key, $value, 0, $expire );
    }

    public function get( $key )
    {
        if (!$key || !$this->_mem)
        {
            return FALSE;
        }
        return json_decode($this->_mem->get( $key ), TRUE);
    }

    public function del( $key )
    {
        if (!$key || !$this->_mem)
        {
            return FALSE;
        }
        return $this->_mem->delete( $key );
    }

}

