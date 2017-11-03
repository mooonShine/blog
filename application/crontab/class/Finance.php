<?php

class Finance extends FinanceHelper
{
    private $table_revenue_agent;
    private $table_cost;
    private $table_revenue_data;
    private $table_revenue_google;
    private $table_revenue_sales;
    private $table_revenue_site;
    private $pay_url = "http://pay.9xu.com/interface/"; //财务接口

    public function __construct()
    {
        parent::__construct();
        $this->table_revenue_agent = 'revenue_agent';
        $this->table_revenue_data = 'revenue_data';
        $this->table_revenue_google = 'revenue_google';
        $this->table_revenue_sales = 'revenue_sales';
        $this->table_revenue_site = 'revenue_site';
        $this->table_cost = 'cost';
    }
    //每个月xx号跑上个月数据
    //请求接口获取财务数据写入finance_9xu
    public function getFinanceAction()
    {
        $this->get_mysql_connect();
        $this->_db->setTable($this->table_revenue_site);
        //获取上月区间
        $month = intval(date('m', time()));
        $year = intval(date('y', time()));
        $begin = mktime(0, 0, 0, $month - 1, 1, $year);
        $end = mktime(0, 0, 0, $month, 1, $year);
        $params = array(
            'type' => 'getFinance',
            'start_time' => $begin,
            'end_time' => $end,
        );
        $result = json_decode($this->fn_get_contents($this->pay_url . 'pay', $params, 'POST'), true);
        if ($result['ret'] == 0 && !empty($result['data'])) {
            $data = $result['data'];
            foreach ($data as $ks => $vs) {
                $new_data[$ks]['user_id'] = $vs['uid'];
                $new_data[$ks]['m_consume'] = $vs['m_consume'];
                $new_data[$ks]['m_payment'] = $vs['m_payment'];
                $new_data[$ks]['refund'] = $vs['refund'];
                $new_data[$ks]['balance'] = $vs['remain_money'];
                $new_data[$ks]['status'] = 0;
                $new_data[$ks]['create_time'] = time();
                $new_data[$ks]['date'] = $begin;
                $new_data[$ks]['update_time'] = 0;
            }
            $this->_db->insert($new_data);
        }
    }

    //每个月26号跑上个月数据，写入累计收款(累计付款，累计充值)，累计消耗。余额
    public function writeDataAction()
    {
        $this->get_mysql_connect();
        $this->_db->setTable($this->table_cost);
        //获取上月时间
        $month = intval(date('m', time()));
        $year = intval(date('y', time()));
        $begin = mktime(0, 0, 0, $month - 1, 1, $year);
        //获取上上月时间
        $s_begin = mktime(0, 0, 0, $month - 2, 1, $year);
        $wheres['AND']['date'] = $begin;
        //表名集合
        $table_array = array('table_cost', 'table_revenue_sales', 'table_revenue_agent', 'table_revenue_google', 'table_revenue_data');
        //查询收入
        foreach ($table_array as $v) {
            $this->_db->setTable($this->$v);
            $list = $this->_db->select('*', $wheres);
            if (!empty($list)) {
                foreach ($list as $kk => $vv) {
                    $where = array('AND' => array('user_id' => $vv['user_id'], 'date' => $s_begin));
                    $datas = $this->balanceCalculate($this->$v, $where, $vv);
                    $this->_db->update($datas, array('AND' => array('user_id' => $vv['user_id'], 'date' => $begin)));
                }
            }
        }
    }

    /**
     * @param $table 表名
     * @param $where 条件
     * @param $datas 数据
     * @return array
     * @Author: zhanghuang@pv25.com
     * @Since:2017-01-18
     * @Info:计算部分
     */
    public function balanceCalculate($table, $where, $datas)
    {
        $newdata = array(
            'total_payment' => 0,
            'total_consume' => 0,
            'balance' => 0,
        );
        $this->get_mysql_connect();
        $this->_db->setTable($table);
        $s_total_payment = $this->_db->get('total_payment', $where);
        $s_total_consume = $this->_db->get('total_consume', $where);
        $s_total_payment = isset($s_total_payment) ? $s_total_payment : 0;
        $s_total_consume = isset($s_total_consume) ? $s_total_consume : 0;
        $newdata['total_payment'] = $s_total_payment + $datas['m_payment'];
        $newdata['total_consume'] = $s_total_consume + $datas['m_consume'];
        $newdata['balance'] = $datas['b_money'] + $datas['m_payment'] - $datas['m_consume'] - $datas['refund'];
        if ($table == 'revenue_google') {
            $dollar_total_consume = $this->_db->get('dollar_total_consume', $where);
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
        if ($table == 'cost') {
            $newdata['balance'] = $datas['b_money'] + $datas['m_consume'] - $datas['m_payment'] - $datas['refund'];//渠道  余额=本月期初+本月消耗-本月付款
        }
        if ($table == 'revenue_sales') {
            $newdata['balance'] = $datas['b_money'] + $datas['m_payment'] - $datas['m_consume'] - $datas['refund'] - $datas['rebates'];//销售  余额=本月期初+本月付款-本月消耗-退款-返点
        }
        return $newdata;
    }
}