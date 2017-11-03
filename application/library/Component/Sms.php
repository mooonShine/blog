<?php
/**
 * 短信发送类
 * Created by PhpStorm.
 * User: cyl
 * Date: 24-6-6
 * Time: 上午10:17
 */
class Component_Sms{
	private $username = 'jhsyzm';
	private $password = 'jhsyzmx';
	private $url 	  = '';
 	/**
    * 发送接口
    * @param $mobile  接收号码
    * @param $content 发信内容
    * @param $url   接口地址
    * 
    */
	public function sms_to($mobile,$content) {  
		if ($mobile){
			$this->url = 'http://116.213.72.20/SMSHttpService/send.aspx?';
			$post_data = array();
		    $post_data['username'] = $this->username;//用户名
		    $post_data['password'] = $this->password;//密码
		    $post_data['mobile'] = $mobile;//手机号，多个号码以分号分隔，如：13407100000;13407100001;13407100002
		    $post_data['content'] = urlencode("【久旭直通车】您正在进行密码找回，验证码：{$content}，请勿向他人泄露此验证码");//内容，如为中文一定要使用一下urlencode函数
		    $post_data['extcode'] = "";//扩展号，可选
		    $post_data['senddate'] = "";//发送时间，格式：yyyy-MM-dd HH:mm:ss，可选
		    $post_data['batchID'] = "";//批次号，可选
		    $data = $this->url_join($post_data);
			return fn_get_contents($this->url, $data, 'post');
		}
	}
	/**
    * 余额查询
    * 
    */
	public function sms_remain(){
		$this->url = 'http://116.213.72.20/SMSHttpService/Balance.aspx';
		$post_data = array();
	    $post_data['username'] = $this->username;;//用户名
	    $post_data['password'] = $this->password;//密码
	    $data = $this->url_join($post_data);
	    return fn_get_contents($this->url, $data, 'post');
	}
	/**
    * url传送数据拼接
    * @param $data  传送数据
    */
	private function url_join($data){
		$o = "";
	    foreach ($data as $k=>$v)
	    {
	        $o.= "{$k}=".$v."&";
	    }
	    $data = substr($o,0,-1); 
	    return $data;
	}
}


