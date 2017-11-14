<?php

/**
 * Created by IntelliJ IDEA.
 * User: lidc
 * Date: 17-2-8
 * Time: 上午10:25
 */
class Model_Admin extends Smodel
{
    protected $table = "admin";

    /*
     * 登陆验证
     */
    public function loginCheck($info)
    {
        if (trim($info['username']) == "") {
            return '用户名不能为空';
        }
        if (trim($info['pwd']) == "") {
            return '密码不能为空';
        }
        if (trim($info['code']) == "") {
            return '验证码不能为空';
        }
        if (!isset($_SESSION['verify_code'])) {
            return '未识别到验证码';
        }

        if (isset($_SESSION['verify_code']) && strtolower($info['code']) != $_SESSION['verify_code']) {
            return '验证码错误';
        }

        $res = $this->get("*", ['AND' => ['name' => $info['username']]]);
        if ($res['pwd'] != md5(md5($info['pwd']) . $res['salt'])) {
            return '用户名或密码不正确';
        }

        if($res['status']==2){
            return '用户名已被冻结,请找相关联系人处理!';
        }

        return $res;
    }

    /**
     * 添加
     */
    public function add($data)
    {
        $errorMsg = $this->_checkData($data);
        $count = $this->count(array('name'=>$data['name']));
        if($count){
            $errorMsg[] = '*用户名已存在！';
        }
        if (count($errorMsg) > 0) {
            return $errorMsg;
        } else {
            $salt = rand(1000, 9999);
            $pwd = md5((md5($data['pwd']) . $salt));
            $info = array(
                'name' => $data['name'],
                'pwd' => $pwd,
                'salt' => $salt,
                'username' => $data['username'],
                'create_time' => time(),
                'login_time' => time(),
                'last_ip' => fn_get_ip(),
                'group_id' => $data['group_id'],
            );
            $this->insert($info);
        }
    }


    /**
     * 列表查询
     * */
    public function getList($condition=array(),$p = 1, $size = 10)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['LIMIT'] = array(($p - 1) * $size, $size);
        $where['ORDER'] =' id desc ' ;
        $list = $this->select('*',$where);
        return array('list'=>$list,'count'=> ceil($count / $size));
    }

    public function editInfo($info)
    {
        $data = array();
        if(!isset($info['id']) && !$info['id']){
            return $errorMsg[] = '*数据错误！';
        }
        if(isset($info['name']) && trim($info['name'])){
            $data['name'] = $info['name'];
        }
        if(isset($info['username']) && $info['username']){
            $data['username'] = $info['username'];
        }
        if(isset($info['group_id']) && $info['group_id']){
            $data['group_id'] = $info['group_id'];
        }
        if(isset($info['pwd']) && $info['pwd']){
            if($info['pwd']==$info['password']){
                $salt = rand(1000, 9999);
                $pwd = md5((md5($info['pwd']) . $salt));
                $data['pwd'] = $pwd;
                $data['salt'] = $salt;
            }else{
                $errorMsg[] = '*两次密码错误！';
                return $errorMsg;
            }
        }
        if(isset($info['status']) && $info['status']){
            $data['status'] = $info['status'];
        }
        $this->update($data,array('id'=>$info['id']));
    }

    /*
     * 获取列表
     */
    public function listCondition($condition=array())
    {
        $where = array();
        if(isset($condition['name']) && $condition['name']){
            $where['AND']['username[~]'] =$condition['name'];
        }
        if(isset($condition['status_type']) && $condition['status_type']){
            if($condition['status_type']==1 && $condition['name_type']){
                $where['AND']['name[~]'] =$condition['name_type'];
            }
            if($condition['status_type']==2 && $condition['name_type']){
                $where['AND']['username[~]'] =$condition['name_type'];
            }
        }
        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['create_time[<]'] = strtotime($condition['end_date'].' 23:59:59');
        }

        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['create_time[>=]'] = strtotime($condition['start_date'].' 00:00:00');
        }

        return $where;
    }

    /**
     * 验证数据
     * @return [type] [description]
     */
    private function _checkData($data)
    {
        $errorMsg = array();

        if (empty($data['name'])) {
            $errorMsg[] = '*请输入用户名称！';
        }

        if (empty($data['username'])) {
            $errorMsg[] = '*请输入姓名！';
        }

        if (empty($data['pwd'])) {
            $errorMsg[] = '*请输入密码！';
        }

        if ($data['pwd'] != $data['password']) {
            $errorMsg[] = '两次密码输入不正确！';
        }

        return $errorMsg;

    }

    /**
     *重置密码
     * */
    public function editPwd($data,$info)
    {
        $errorMsg=array();
        if (empty($data['pwd']) && !$data['pwd']) {
            $errorMsg[] = '*密码不能为空！';
        }

        if ($data['pwd'] != $data['password']) {
            $errorMsg[] = '*两次密码输入不正确！';
        }

        if(isset($info['id']) && !$info['id']){
            $errorMsg[] = '*操作错误！';
        }
        if (count($errorMsg) > 0) {
            return $errorMsg;
        } else {
            $salt = rand(1000, 9999);
            $pwd = md5((md5($data['pwd']) . $salt));
            $re = array(
                'pwd' => $pwd,
                'salt' => $salt,
            );
            $this->update($re, array('id' => $info['id']));
        }
    }



    /*
     * 修改登录信息
     */
    public function editLoginInfo($info)
    {
        return $this->update($info, ['id' => $info['id']]);
	}

    /**
     * [删除]
     */
    public function del($id)
    {
        $this->delete(array('id' => intval($id)));
    }

}