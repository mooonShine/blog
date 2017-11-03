<?php
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/6
 * Time:  13:33
 */
class Model_Admin extends Smodel
{
    protected $table = "admin";

    /**
     * @param $condition
     * @param $p  页码
     * @param int $r  获取数据条数
     * @return array
     * @Author: zhanghuang@pv25.com
     * 获取多条信息
     */
    public function getList($condition, $p, $r = 20)
    {
        $where = array();
        if (isset($condition['begin_date'])) {
            $where['AND']['op_time[>=]'] = $condition['begin_date'];
        }
        if (isset($condition['end_date'])) {
            $where['AND']['op_time[<=]'] = $condition['end_date'];
        }
        if(isset($condition['user_name'])){
            $where['AND']['username'] = $condition['user_name'];
        }
        if(isset($condition['permi'])){
            $where['AND']['permi_id'] = $condition['permi'];
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

    /**
     * @Author: zhanghuang@pv25.com
     * @Since:
     * @Info:
     */
    public function addUser($data){
        $salt = mt_rand(1000, 9999);
        $data = array(
            'username' => $data['username'],
            'pwd' => md5(md5($data['pwd']) . "_" . $salt),
            'salt' => $salt,
            'permi_id' => $data['permi_id'],
            'create_time' => time()
        );
        return $this->insert($data);
    }


    /**
     * 登陆
     */
    public function login($username,$password){
        $where['AND']['username'] =  $username;
        if ($row = $this->get('*', $where)) {
            if ($row['password'] == md5(md5($password) . "_" . $row['salt'])) {
                return array('ret'=>0,'msg'=>'登陆成功','data'=>$row);
            } else {
                return array('ret'=>1,'msg'=>'密码错误！','data'=>'');
            }
        } else {
            return array('ret'=>1,'msg'=>'用户名错误！','data'=>'');
        }

    }

    /**
     * 随机生成salt
     * */
    public function getSalt()
    {
        return  rand(1000,9999);
    }


}