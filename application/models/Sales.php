<?php

/**
 *
 * Sales
 * User: Administrator
 */
class Model_Sales extends Smodel
{
    protected $table = "revenue_sales";

    public function getList($condition, $p, $r = 20, $state = false)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['ORDER'] = ' id desc ';
        if (!$state) {
            $where['LIMIT'] = array(($p - 1) * $r, $r);
        }
        $list = $this->select('*', $where);
        return array('list' => $list, 'count' => $count);
    }


    /**
     * 条件处理
     * */
    public function listCondition($condition)
    {
        if (!$condition) return array();
        $where = array();

        $where['AND']['del'] = 0;
        if (isset($condition['user_id']) && $condition['user_id']) {
            $where['AND']['user_id'] = $condition['user_id'];
        }
        if (isset($condition['id']) && $condition['id']) {
            $where['AND']['id'] = $condition['id'];
        }
        if (isset($condition['start_date']) && $condition['start_date']) {
            $where['AND']['date[>=]'] = $condition['start_date'];
        }
        if (isset($condition['end_date']) && $condition['end_date']) {
            $where['AND']['date[<]'] = $condition['end_date'];
        }
        if (isset($condition['total_payment']) && $condition['total_payment']) {
            if ($condition['total_payment'] == 1) {
                $where['AND']['total_payment[<]'] = 500000;
            } else {
                $where['AND']['total_payment[>=]'] = 500000;
            }
        }
        return $where;
    }

    /**
     * 累计数据
     * */
    public function total($list, $start_date)
    {
        $idArrr = array();
        $month = date('m', $start_date);
        $years = date('Y', $start_date);
        $newD = date('d', time());
        $newTime = strtotime(date("Y-m-01", strtotime("-1 month")));
        $start = strtotime(date($years . '-' . $month . '-1'));

        //1月则 超过TIME_END_DAY号  查询的月份不等于上过月
        if ($month == 01 || $newD > TIME_END_DAY || $start != $newTime) return $list;

        $month--;
        $start = strtotime(date($years . '-' . $month . '-1'));
        if (!$list) return $list;
        foreach ($list as $key => $value) {
            $idArrr[] = $value['user_id'];
        }
        //获取上个月数据
        $data = $this->select(array('id', 'user_id', 'b_money', 'total_payment', 'total_consume', 'balance'), array('AND' => array('user_id' => $idArrr, 'date' => $start, 'del' => 0)));

        $listUser = array();

        if ($data) {
            foreach ($data as $k => $v) {
                $listUser[$v['user_id']] = $v;
            }
        }

        foreach ($list as $j => &$l) {
            $total_payment = isset($listUser[$l['user_id']]['total_payment']) ? $listUser[$l['user_id']]['total_payment'] : 0;
            $total_consume = isset($listUser[$l['user_id']]['total_consume']) ? $listUser[$l['user_id']]['total_consume'] : 0;
            $l['total_payment'] = $total_payment + $l['m_payment'];
            $l['total_consume'] = $total_consume + $l['m_consume'];
            //余额=上月余额+本月收款-本月消耗-本月返点-退款
            $l['balance'] = sprintf("%0.2f", $l['b_money'] + $l['m_payment'] - $l['m_consume'] - $l['refund'] - $l['rebates']);
        }
        return $list;
    }

}