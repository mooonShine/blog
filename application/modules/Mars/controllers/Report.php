<?php
/**
 * Created by IntelliJ IDEA.
 * User: zh
 * Date: 17-2-8
 * Time: 下午4:46
 */
class Controller_Report extends Base
{

    protected $layout = "layouts";
    protected $report;
    protected $advert;

    public function init()
    {
        parent::init();
        $this->report = new Model_Report();
        $this->advert = new Model_Advert();
    }

    /*
     * 列表
     */
    public function indexAction()
    {
        $p = fn_get_val('p', 1);
        $condition=$this->_request->getQuery();
        if(!isset($condition['start_date'])||!isset($condition['end_date'])||$condition['start_date']==''||$condition['end_date']==''){
            $condition['start_date']=date('Y-m-01', time());
            $condition['end_date']=date('Y-m-d',time()-86400);
        }
        $list = $this->report->getList($condition, $p, 10);
        $total_pv=$this->report->sumData('pv',$condition);
        $total_click=$this->report->sumData('click',$condition);
        $this->assign('total_pv', isset($total_pv)?$total_pv:0);
        $this->assign('total_click', isset($total_click)?$total_click:0);
        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('report/index');
    }

    /*
    * 今日数据
    */
    public function pcTodayAction()
    {
        $p = fn_get_val('p', 1);
        $condition=$this->_request->getQuery();
        $condition['put_status']=1;
        $list = $this->advert->getList($condition, $p, 10);
        if(!empty($list['list'])){
            $res=$this->getTodayData($list['list']);
            $list['list']=$res['list'];
            $total_pv=$res['total_pv'];
            $total_click=$res['total_click'];
        }
        $this->assign('total_pv', isset($total_pv)?$total_pv:0);
        $this->assign('total_click', isset($total_click)?$total_click:0);
        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('report/pcToday');
    }


    /**
     * @param $aids
     * @return array
     * redis获取今日pv click
     */
    private function getTodayData($list)
    {
        $today = date('Y-m-d',time());
        $_redis_config = Yaf_Application::app()->getConfig()->toArray();
        $redis_config['host'] = $_redis_config['redis']['params']['host'];
        $redis_config['port'] = $_redis_config['redis']['params']['port'];
        $redis = new Component_Redis($redis_config);
        $redis->select(2);
        $total_pv=0;
        $total_click=0;
        foreach ($list as $ks=>$vs){
            $key_pv = "house_pv_" . $today . "_" . $vs['id'];
            $key_click = "house_click_" . $today . "_" . $vs['id'];
            $list[$ks]['pv'] = $redis->get($key_pv)?$redis->get($key_pv):0;
            $list[$ks]['click'] = $redis->get($key_click)?$redis->get($key_click):0;
            $list[$ks]['date'] = $today;
            $total_pv+=$redis->get($key_pv)?$redis->get($key_pv):0;
            $total_click+=$redis->get($key_click)?$redis->get($key_click):0;
        }
        return array('list'=>$list,'total_pv'=>$total_pv,'total_click'=>$total_click);
    }
}