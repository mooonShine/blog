<?php

/**
 * 数据接口
 * User: zb
 * Date: 17-3-1
 * Time: 上午10:20
 */
class Model_Crontab extends Smodel
{
    /*
     * 计算这月数据
     */
    public function calculateMoneyData($year, $month, $table)
    {
        //获取上月时间
        $begin = mktime(0, 0, 0, $month, 1, $year);
        //获取上上月时间
        $s_begin = mktime(0, 0, 0, $month - 1, 1, $year);
        $wheres['AND']['date'] = $begin;
        $wheres['AND']['del'] = 0;
        //查询收入
        $this->table = $table;
        $list = $this->select('*', $wheres);
        if (!empty($list)) {
            foreach ($list as $kk => $vv) {
                $where = array('AND' => array('user_id' => $vv['user_id'], 'del' => 0, 'date' => $s_begin));
                $datas = $this->balanceCalculate($where, $vv);
                $this->update(array(
                    'total_payment' => 0,
                    'total_consume' => 0,
                    'balance' => 0,
                ), array('AND' => array('user_id' => $vv['user_id'], 'del' => 0, 'date' => $begin)));
                $this->update($datas, array('AND' => array('user_id' => $vv['user_id'], 'del' => 0, 'date' => $begin)));
            }
        }
    }

    public function balanceCalculate($where, $datas)
    {
        $newdata = array(
            'total_payment' => 0,
            'total_consume' => 0,
            'balance' => 0,
        );

        $wd = $where['AND']['date'];
        $wdy = date('Y', $wd);
        $wdm = date('m', $wd);
        for ($i = $wdm; $i >= 1; $i = $i - 1) {
            $where['AND']['date'] = mktime(0, 0, 0, $i, 1, $wdy);
            $where['AND']['del'] = 0;
            $s_total_payment = $this->get('total_payment', $where);
            $s_total_consume = $this->get('total_consume', $where);
            if ($s_total_consume || $s_total_payment) {
                break;
            }
        }

        $s_total_payment = isset($s_total_payment) ? $s_total_payment : 0;
        $s_total_consume = isset($s_total_consume) ? $s_total_consume : 0;
        $newdata['total_payment'] = $s_total_payment + $datas['m_payment'];
        $newdata['total_consume'] = $s_total_consume + $datas['m_consume'];
        $newdata['balance'] = $datas['b_money'] + $datas['m_payment'] - $datas['m_consume'] - $datas['refund'];
        if ($this->table == 'revenue_google') {
            $dollar_total_consume = $this->get('dollar_total_consume', $where);
            $dollar_total_consume = isset($dollar_total_consume) ? $dollar_total_consume : 0;
            $newdata['total_consume'] = $s_total_consume + $datas['m_consume'];
            $newdata['dollar_total_consume'] = $dollar_total_consume + $datas['dollar_m_consume'];
            if ($datas['type'] == 1) {
                //google部门且为美元对账
                $newdata['balance'] = $datas['b_money'] + $datas['m_payment'] - $datas['dollar_m_consume'] - $datas['refund'];
            } else {
                //google部门且为人民币对账
                $newdata['balance'] = $datas['b_money'] + $datas['m_payment'] - $datas['m_consume'] - $datas['refund'];
            }
        }
        if ($this->table == 'cost') {
            //$newdata['balance'] = $datas['b_money'] + $datas['m_consume'] - $datas['m_payment'] - $datas['refund'];//渠道  余额=本月期初+本月消耗-本月付款
            $newdata['balance'] = $datas['b_money'] - $datas['m_consume'] +
                $datas['m_payment'] - $datas['refund'];//渠道  余额=本月期初-本月消耗+本月付款-退款
        }
        if ($this->table == 'revenue_sales') {
            $newdata['balance'] = $datas['b_money'] + $datas['m_payment'] - $datas['m_consume'] - $datas['refund'] - $datas['rebates'];//销售  余额=本月期初+本月付款-本月消耗-退款-返点
        }
        return $newdata;
    }


}
