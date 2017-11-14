<?php

/**
 * Created by IntelliJ IDEA.
 * User: yingrr
 * Date: 17-2-7
 * Time: 下午5:57
 */
class Controller_Finance extends Base
{
    protected $layout = "layouts";
    protected $finance;
    protected $admin_id;

    public function init()
    {
        parent::init();
        $this->finance = new Model_Finance();
        $this->admin_id = $_SESSION['userinfo']['id'];
    }

    /**
     * [添加充值]
     */
    public function addRechargeAction()
    {
        if ($this->_request->getPost()) {
            $data = array(
                'user_name' => $this->_request->getPost('username'),
                'phone' => $this->_request->getPost('phone'),
                'money' => $this->_request->getPost('count'),
                'type' => $this->_request->getPost('type'),
                'date' => $this->_request->getPost('time'),
                'time' => time(),
                'operator_id' => $this->admin_id,
            );
            $return = $this->finance->addRecharge($data);
            if ($return['ret'] == '1') {
                fn_ajax_return(0, "添加成功！", "");
            } else if ($return['ret'] == '3') {
                fn_ajax_return(1, "用户名或手机号有误！", "");
            } else {
                fn_ajax_return(2, "系统繁忙，请联系管理员！", "");
            }
        }
        $this->display('finance/addRecharge');
    }

    /**
     * [充值记录]
     */
    public function rechargeRecordAction()
    {

        $p = fn_get_val('p', 1);
        $condition=$this->_request->getQuery();
        $res=$this->getthemonth(time());
        if(!isset($condition['start_date'])||!isset($condition['end_date'])||$condition['start_date']==''||$condition['end_date']==''){
            $condition['start_date']=$res[0];
            $condition['end_date']=$res[1];
        }
        $list = $this->finance->getlist('rechargeRecord', $condition, $p, 10, false);

        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('finance/rechargeRecord');
    }
    /**
     * [消费记录]
     */
    public function costRecordAction()
    {

        $p = fn_get_val('p', 1);
        $condition=$this->_request->getQuery();
        $res=$this->getthemonth(time());
        if(!isset($condition['start_date'])||!isset($condition['end_date'])||$condition['start_date']==''||$condition['end_date']==''){
            $condition['start_date']=$res[0];
            $condition['end_date']=$res[1];
        }

        $list = $this->finance->getlist('costRecord',$condition, $p, 10, false);

        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('finance/costRecord');
    }
}