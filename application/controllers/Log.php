<?php
/**
 * User: lidc
 * Date: 16-12-6
 */
class controller_Log extends Front{

    protected $layout = 'layouts';
    protected $log='';

    public function init()
    {
        parent::init();
        $this->log = new Model_Log();
    }

    /**
     * @Author: zhanghuang@pv25.com
     * 日志列表
     */
    public function indexAction()
    {
        $d = intval(date("d"))-1;
        $date_start = '- '.$d. 'day';
        $date = fn_get_date($date_start, '0 day');
        $bdate = $date['bdate'];
        $edate = $date['edate'];
        $page = $this -> _request -> getQuery('p');
        $page = $page ? $page : 1;
        $rows = $this -> _request -> getQuery('pageSize');
        if(!$rows) {
            $rows= 20;
        }
        $condition['begin_date']=$bdate;
        $condition['end_date']=$edate;
        $list=$this->log->getList($condition,$page,$rows);
        $page = new Component_Page($page, $list['count'], $this -> _a,$rows);
        $this -> assign('beginDate', fn_ymd($bdate));
        $this -> assign('endDate', fn_ymd($edate));
        $this -> assign('page', $page -> display());
        $this->assign('list',$list);
        $this->display('log/index');
    }
}