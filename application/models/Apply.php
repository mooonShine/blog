<?php
/**
 * Created by IntelliJ IDEA.
 * User: lidc
 * Date: 17-3-10
 * Time: 下午1:16
 */
class Model_Apply extends Smodel{

    protected $table = "apply";

    /**
     * 获取列表
     */
    public function getList($condition, $p, $r = 20)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['ORDER'] = ' create_time desc ';
        $where['LIMIT'] = array(($p - 1) * $r, $r);
        $list = $this->select('*', $where);
        return array('list' => $list, 'count'=> ceil($count / $r));
    }


    private function listCondition($condition)
    {
        $where = [];
        if(isset($condition['is_delete']))
        {
            $where['AND']['is_delete'] = $condition['is_delete'];
        }
        if(isset($condition['status']))
        {
            $where['AND']['status'] = $condition['status'];
        }
        $where['AND']['status[!]'] = 3;
        return $where;
    }


    /**
     * 状态修改
     * */
    public function applyStatus($condition)
    {
        if(!isset($condition['id']))
        {
            return '';
        }
        $where['id'] = $condition['id'];
        if(isset($condition['status']))
        {
            $data['status'] = $condition['status'];
        }
        if(isset($condition['is_delete']))
        {
            $data['is_delete'] = $condition['is_delete'];
        }
        return $this->update($data,$where);
    }


}