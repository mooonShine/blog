<?php

/**
 * Created by IntelliJ IDEA.
 * User: zb
 * Date: 16-12-5
 * Time: 下午2:19
 */
class Model_Log extends Smodel
{
    protected $table = "log";
    protected $types=array(1=>'add',2=>'update',3=>'del',4=>'login',5=>'logout');
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
     * @param $type  类型
     * @param $content 内容
     * @return bool
     * @Author: zhanghuang@pv25.com
     * @throws Exception
     */
    public function add($type,$content){
        $s = new Component_Session();
        $admin_id = $s->get("ADMIN_ID");
        $admin_name = $s->get("USERNAME");
        if (!$admin_id||!$admin_name) {
            throw  new Exception("用户信息丢失");
            return false;
        }
        $res=$this->insert([
            'op_name' => $admin_name,
            'op_id' => $admin_id,
            'op_content' => $content,
            'op_action' =>$this->types[$type],
            'op_time' => time(),
            'op_date' => strtotime(date('Y-m-d', time())),
        ]);
        if($res){
            return array('ret'=>1,'msg'=>'添加成功');
        }else{
            return array('ret'=>0,'msg'=>'添加失败');
        }
    }

    /**
     * @param $where
     * @return bool|int
     * @Author: zhanghuang@pv25.com
     * 获取count
     */
    public function getCount($where){
        $count = $this->count($where);
        return $count;
    }

}