<?php

/**
 * 调用接口类
 *
 * @author zhanghuang 2016-12-2
 */
class CallInterface
{

    protected $url = '';
    protected $interface_url = array(
        'user_url' => "http://login.juhuisuan.com/interface",
        'zhi_url' => "http://zhi.9xu.com/interface",
        'pay_url' => "http://pay.9xu.com/interface"
    );
    public $success_flag = 0;

    public function __construct($type = '', $refer = 'ht')
    {
        if (!empty($type)) {
            $this->setUrl($type, $refer);
        }
    }

    public function setUrl($type, $refer = 'ht')
    {
        $this->url = $this->interface_url[$type];
        if (!empty($refer)) {
            $this->url.='/' . $refer;
        }
    }

    public function run($data, $method = 'post')
    {
        $res = json_decode(fn_get_contents($this->url, $data, $method), true);
        if (!$res || !isset($res['ret']) || $res['ret'] == $this->success_flag) {
            return isset($res['data'])?$res['data']:array();
        } else {
            return false;
        }
    }

}
