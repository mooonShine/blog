<?php

/**
 * Created by IntelliJ IDEA.
 * User: yingrr
 * Date: 17-2-8
 * Time: 上午10:25
 */
class Model_Finance extends Smodel
{
    protected $table = "finance";

    /**
     * 获取列表
     */
    public function getList($action, $condition, $p, $r = 10, $state = false)
    {
        $where = $this->listCondition($action, $condition);
        $count = $this->count($where);
        $where['ORDER'] = ' id desc ';
        if (!$state) {
            $where['LIMIT'] = array(($p - 1) * $r, $r);
        }
        $list = $this->select('*', $where);
        $list = $this->externalConnection($list);

        return array('list' => $list, 'count' => ceil($count / $r));
    }

    /**
     * 条件处理
     * */
    public function listCondition($action, $condition)
    {
        if (!$condition) return array();
        $where = array();

        if (!empty($condition['start_date'])) {
            $where['AND']['date[>=]'] = strtotime($condition['start_date']);
        }
        if (!empty($condition['end_date'])) {
            $where['AND']['date[<=]'] = strtotime($condition['end_date']) + 86399;
        }

        if (!empty($condition['userinfo'])) {
            $users = new Model_Users();
            $where_user['OR']['user_name'] = $condition['userinfo'];
            $where_user['OR']['real_name'] = $condition['userinfo'];
            $where_user['OR']['phone'] = $condition['userinfo'];
            $where_user['OR']['email'] = $condition['userinfo'];
            $user = $users->select('id', $where_user);
            $where['AND']['uid'] = $user;
        }

        if (!empty($action)) {
            if ($action == 'costRecord') {
                $where['AND']['type'] = 1;
            } else if ($action == 'rechargeRecord') {
                $where['AND']['OR']['type'] = array(2,3,4);
            }
        }

        return $where;
    }

    /**
     * 连接外表
     */
    public function externalConnection($list)
    {
        if (empty($list)) {
            return array();
        }
        $users = new Model_Users();
        $field = array('user_name', 'real_name', 'phone', 'flow', "email");
        foreach ($list as $k => $v) {
            $where['AND']['id'] = $v['uid'];
            $user = $users->get($field, $where);
            if (!$user) {
                $user = array('user_name' => '', 'real_name' => '', 'phone' => '', 'flow' => '', "email" => '');
            }
            $list[$k] = array_merge($v, $user);
        }

        $admin = new Model_Admin();
        $field = array('username');
        foreach ($list as $k => $v) {
            $where['AND']['id'] = $v['operator_id'];
            $operator = $admin->get($field, $where);
            if (!$operator) {
                $operator = array('username' => '');
            }
            $list[$k] = array_merge($v, $operator);
        }

        return $list;
    }

    /**
     * 添加充值
     * 事务
     */
    public function addRecharge($data)
    {

        //获取用户信息
        $users = new Model_Users();
        $where_user['AND']['user_name'] = $data['user_name'];
        $where_user['AND']['phone'] = $data['phone'];
        $user = $users->get('*', $where_user);

        if (empty($user)) {
            return array('ret' => '3');
        }

        $insert_data = array(
            'uid' => $user['id'],
            'money' => $data['money'],
            'type' => $data['type'],
            'date' => $data['date'],
            'remain_money' => $user['flow']+intval($data['money'] / $user['frate']),
            'flow_rate' => $user['frate'],
            'time' => time(),
            'operator_id' => $data['operator_id'],
            'money_flow' => intval($data['money'] / $user['frate'])
        );

        //事务开始
        $this->begin();

        $insert = $this->insert($insert_data);

        $flow = $user['flow'] + intval($data['money'] / $user['frate']);
        $update_info = array('flow' => $flow,'last_update_time'=>time());
        $where_update = array(
            'id' => $user['id']
        );
        $update = $users->update($update_info, $where_update);

        if ($insert && $update) {
            $this->commit();
            return array('ret' => '1');
        } else {
            $this->rollBack();
            return array('ret' => '2');
        }
    }
}