<?php

/**
 * Created by IntelliJ IDEA.
 * User: zh
 * Date: 17-2-8
 * Time: 上午10:25
 */
class Model_Article extends Smodel
{
    protected $table = "article";

    /**
     * 获取列表
     */
    public function getList($condition, $p, $r = 20)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['ORDER'] = ' id desc ';
        $where['LIMIT'] = array(($p - 1) * $r, $r);
        $list = $this->select('*', $where);
        $list = $this->externalConnection($list,$condition);
        return array('list' => $list, 'count'=> ceil($count / $r));
    }

    /**
     * 添加客户
     */
    public function addUser($infos)
    {
        $this->_checkData($infos);
        $data=array(
            'user_type'=>$infos['user_type'],
            'user_name'=>$infos['user_name'],
            'password'=>md5($infos['password']),
            'real_name'=>$infos['real_name'],
            'contact'=>$infos['contact'],
            'phone'=>$infos['phone'],
            'email'=>$infos['email'],
            'frate'=>$infos['frate'],
            'pid'=>$infos['pid'],
            'create_time'=>time()
        );
        if($data['user_type']==1){
            $data['real_name']=$infos['contact'];
        }
        $list = $this->insert($data);
        if($list){
            return array('ret'=>'1');
        }else{
            return array('ret'=>'2');
        }
    }

    /**
     * @param $data
     * @info 检查数据合法性
     * 2017-02-15　modify by zh
     */
    public function checkUser($data)
    {
        if(isset($data['user_name'])&&$data['user_name']){
            $info = $this->select('id',array('user_name'=>$data['user_name']));
            if(count($info)>0){
                fn_ajax_return(1, "用户名已存在！", "");
            }
        }
        if(isset($data['phone'])&&$data['phone']){
            $info = $this->select('id',array('phone'=>$data['phone']));
            if(count($info)>0){
                fn_ajax_return(1, "手机号已存在！", "");
            }
        }
        if(isset($data['email'])&&$data['email']){
            $info = $this->select('id',array('email'=>$data['email']));
            if(count($info)>0){
                fn_ajax_return(1, "邮箱已存在！", "");
            }
        }
    }

    /**
     * 验证数据
     * @return [type] [description]
     */
    private function _checkData($data)
    {
        if (empty($data['user_name'])) {
            fn_ajax_return(1, "用户名必填！", "");
        }
        if ($data['password'] == "") {
            fn_ajax_return(1, "密码必填！", "");
        }
        if (empty($data['phone'])) {
            fn_ajax_return(1, "手机号必填！", "");
        }
        if ($data['email'] == "") {
            fn_ajax_return(1, "邮箱必填！", "");
        }

        if ($data['repassword'] != $data['password']) {
            fn_ajax_return(1, "两次密码不一致！", "");
        }
        if (!is_numeric($data['frate'])) {
            if(!is_float($data['frate'])){
                fn_ajax_return(1, "转换比率不合法！", "");
            }
        }
    }

    /**
     * 条件处理
     * */
    public function listCondition($condition)
    {
        if(!$condition)return array();
        $where =array();
        if(isset($condition['username']) && $condition['username']){
            $where['AND']['OR']['email[~]'] = $condition['username'];
            $where['AND']['OR']['user_name[~]'] = $condition['username'];
            $where['AND']['OR']['phone[~]'] = $condition['username'];
            $where['AND']['OR']['real_name[~]'] = $condition['username'];
        }
        if(isset($condition['status']) && $condition['status']){
            $where['AND']['status'] = $condition['status'];
            if($condition['status']==2){
                $where['AND']['status'] = 0;
            }
        }
        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['create_time[>=]'] = strtotime($condition['start_date']. ' 00:00:00');
        }
        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['create_time[<=]'] = strtotime($condition['end_date']. ' 23:59:59');
        }
        return $where;
    }

    /**
     * 连接外表
     */
    public function externalConnection($list,$condition) {
        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['date[>=]'] = strtotime($condition['start_date']. ' 00:00:00');
        }
        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['date[<=]'] = strtotime($condition['end_date']. ' 23:59:59');
        }
        $where['AND']['type']=2;
        if(empty($list)) {
            return array();
        }
        $finance = new Model_Finance();
        $admin = new Model_Admin();
        foreach($list as $k=>$v) {
            $where['AND']['uid'] = $v['id'];
            $list[$k]['remain_money'] = $finance->get('remain_money',$where);
            $wheres['AND']['id'] =$v['pid'];
            $list[$k]['agent_name'] = $admin->get('name',$wheres);
            $list[$k]['total_money'] = $finance->sum('money',$where);
            $list[$k]['recharge_count'] = $finance->count($where);
        }
        return $list;
    }

    /*
     * 获取单条信息
     */
    public function getInfo($id)
    {
        return $this->get("*", ['id' => $id]);
    }

    /*
     * 伪删除
     */
    public function deluser($id)
    {
        return $this->update(['deleted'=>1],['id'=>$id]);
    }

}