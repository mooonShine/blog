<?php
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/6
 * Time:  13:34
 */
class Model_User extends Smodel
{
    protected $table = "user";

    //
    public function getList($condition, $p, $r = 20)
    {
        $where = array();
        if(isset($condition['user_name'])){
            $where['AND']['username'] = $condition['user_name'];
        }
        if(isset($condition['depart'])){
            $where['AND']['depart_id'] = $condition['depart'];
        }
        $where['ORDER'] = 'id DESC';
        if ($p && $r) {
            $where['LIMIT'] = array(($p - 1) * $r, $r);
        }
        $list = $this->select('*', $where);
        $count = 0;
        if ($list) {
            unset($where['ORDER'], $where['LIMIT']);
            $count = $this->count($where);
        }
        return array('data' => $list, 'count' => $count);
    }

    //根据用户名查询信息
    public function selectUserByName($username,$depart_id=-1){
        $where['AND']['username'] = $username;
        if($depart_id!=-1){
            $where['AND']['depart_id'] = $depart_id;
        }
        $user = $this->select("*",$where);
        return $user;
    }
    /**
     * @param $fields
     * @param $uid
     * @return bool
     * @Author: zhanghuang@pv25.com
     * @Since:2016-12-09
     * @Info:接口获取单个用户
     */
    public function getUser($fields,$uid){
        $res = $this->get($fields,array('zhi_userid'=>$uid));
        return $res;
    }
    /**
     * @param $data
     * @param null $where
     * @return bool|int
     * @Author: zhanghuang@pv25.com
     * @Since:2016-12-09
     * @Info: 修改用户名
     */
    public function updateUserName( $data, $where = null){
       $res =  $this->update(array('username'=>$data,'update_time'=>time()),$where);
        return $res;
    }

    /**
     * 获取部门所属客户组
     * */
    public function getUsername($depart_id)
    {
        if(!$depart_id) $depart_id = -1;
        return $this->select(array('id','username','zhi_userid','depart_id'),array('depart_id'=>$depart_id));
    }

}