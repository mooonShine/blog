<?php

/**
 * data
 * User: lidc
 * data: 16-12-6
 */
class Controller_Data extends Base
{

    protected $layout = 'layouts';
    protected $data;
    protected $user;
    protected $log;
    protected $permi_id;
    protected $depart_id;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->data = new Model_Data();
        $this->user = new Model_User();
        $this->log = new Model_Log();
        $this->permi_id = $this->_session->get('PERMI_ID');
        $this->depart_id = DEPART_DATA;
    }

    /**
     * 数据定制
     * */
    public function indexAction()
    {
        $p = $this->_request->getQuery('p');
        $p = isset($p) ? $p : 1;

        $y = intval(date('Y', time()));
        $m = intval(date('m', time()));
        $newD = date('d', time());
        if ($m == 1) {
            $y -= 1;
            $m = 12;
        } else {
            $m -= 1;
        }

        $year = $this->_request->getQuery('year', $y);
        $month = $this->_request->getQuery('month', $m);
        $username = $this->_request->getQuery('username');
        $totalPayment = $this->_request->getQuery('total_payment');

        $where = array();

        $start_date = strtotime($year . "-" . $month);//上个月初
        if ($month == 12) {
            $end_date = strtotime(($year + 1) . "-1");
        } else {
            $end_date = strtotime($year . "-" . ($month + 1));
        }

        if ($username) {
            $userId = $this->user->select('id', array('username[~]' => $username));
            $where['user_id'] = $userId;
        }

        $where['start_date'] = $start_date;
        $where['end_date'] = $end_date;

        //部门标签
        $NavAndData = $this->getNav($this->permi_id);

        if ($this->permi_id > PERMI_FINANCIAL) {
            $this->depart_id = array_keys($NavAndData)[0];
        }

        //累计收款
        if (isset($totalPayment) && $totalPayment) {
            //获取符合条件的累计id
            if ($newD < TIME_END_DAY && $newD > TIME_START_DAY) {
                $toList = $this->data->getlist($where, '', '', true);
                $toList = $this->data->total($toList['list'], $start_date);
                $listId = $this->getTotalId($toList, $totalPayment);
                $where['id'] = $listId;
            } else {
                $where['total_payment'] = $totalPayment;
            }
        }

        $list = $this->data->getlist($where, $p);
        $list['list'] = $this->data->total($list['list'], $start_date);
        $page = new Component_Page($p, $list['count'], $this->_a, 20);

        //数据标签
        $userArry = $this->user->getUsername($this->depart_id);
        $NavAndcontent = $this->getNavAndcontent($list['list'], $userArry, $this->permi_id, $this->depart_id);

        //判断时间是否显示编辑过往数据功能
        $According = 1;//原为0
        if ($m == $month) $According = 1;
        $this->assign('According', $According);

        $this->assign('data', $NavAndcontent['data']);
        $this->assign('navs', $NavAndcontent['navs']);
        $this->assign('years', $this->getYears());
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->assign('permissions', $this->getPermissions($this->permi_id));
        $this->assign('Nav', $NavAndData);
        $this->assign('depart_id', $this->depart_id);
        $this->assign('permi_id', $this->permi_id);
        $this->assign('page', $page->display());
        $this->display('data/index');
    }

    /**
     * 添加数据
     * */
    public function addIncomeAction()
    {
        if ($this->_request->getPost()) {
            $data = $this->_request->getPost();
            $contents = $data;
            if (isset($data['type']) && $data['type'] == 'update') {
                $id = $data['id'];
                $count = $this->data->count(array('id' => $id));
                if ($count) {
                    $pic = $this->data->get('m_pic', array('id' => $id));
                    $info['m_pic'] = $this->picAddrs($data['m_pic']);
                    if (isset($data['m_consume']) && $data['m_consume']) $info['m_consume'] = $data['m_consume'];
                    if (isset($data['refund']) && $data['refund']) $info['refund'] = $data['refund'];
                    if (isset($data['b_money']) && $data['b_money']) $info['b_money'] = $data['b_money'];
                    if (isset($data['m_payment']) && $data['m_payment']) $info['m_payment'] = $data['m_payment'];
                    $info['update_time'] = time();
                    $re = $this->data->update($info, array('id' => $id));
                    if ($re) $this->delPic($pic, $info['m_pic']);
                    $content = $this->contentItem($contents);
                    $this->log->add(2, $content);
                    ajaxReturn(1, '修改成功');
                }
                ajaxReturn(0, '修改失败');
            } else {
                $info['user_id'] = isset($data['user_id']) ? $data['user_id'] : '';
                $info['m_consume'] = isset($data['m_consume']) ? $data['m_consume'] : '';
                $info['refund'] = isset($data['refund']) ? $data['refund'] : '';
                $info['b_money'] = isset($data['b_money']) ? $data['b_money'] : '';
                $info['m_payment'] = isset($data['m_payment']) ? $data['m_payment'] : '';
                $info['m_pic'] = $this->picAddrs(isset($data['m_pic']) ? $data['m_pic'] : '');
                $info['create_time'] = time();
//                if($this->permi_id==PERMI_ADMIN){
                $year = isset($data['year']) ? $data['year'] : '';
                $month = isset($data['month']) ? $data['month'] : '';
                $info['date'] = strtotime(date($year . '-' . $month . '-01'));
//                }else{
//                    $info['date'] = strtotime(date('Y-m-01', strtotime('-1 month')));
//                }
                $res = $this->data->get('id', array('AND' => array('user_id' => $info['user_id'], 'date' => $info['date'], 'del' => 0)));
                if ($res) ajaxReturn(2, '每个客户每月只可添加一条数据');
                $re = $this->data->insert($info);
                $content = $this->contentItem($contents);
                $this->log->add(1, $content);
            }
            if ($re) ajaxReturn(1, '添加成功');
            ajaxReturn(0, '添加失败');
        }
        echo '非法请求';
    }

    /**
     * 上传图片
     * 添加数据使用
     * */
    public function uploadAction()
    {
        if (!isset($_FILES['Filedata']['name'])) ajaxReturn(0, '上传错误');
        $data = json_decode(fn_upload_img('Filedata'));
        ajaxReturn(1, $data);
        exit;
    }


    /**
     * 客户名验证是否存在
     * */
    public function validationUserAction()
    {
        if ($this->_request->getPost()) {
            $username = $this->_request->getPost('username');
            if (!$username) ajaxReturn(0, '无此客户');
            $re = $this->user->get('id', array('AND' => array('username' => $username, 'depart_id' => $this->depart_id)));
            if ($re) ajaxReturn(1, $re);
            ajaxReturn(0, '无此客户');
        }
        ajaxReturn(0, '非法请求');
    }

    /**
     * 编辑/获取数据信息
     * */
    public function dataInfoAction()
    {
        if ($this->_request->getPost()) {
            $id = $this->_request->getPost('id');
            if (!$id) ajaxReturn(0, '');
            if ($this->permi_id < PERMI_SALES) {
                $re = $this->data->get('*', array('id' => $id));
            } else {
                $re = $this->data->get(array('id', 'user_id', 'm_payment', 'refund', 'm_pic'), array('id' => $id));
            }
            if (!$re) ajaxReturn(0, '获取数据失败');
            $username = $this->user->get('username', array('AND' => arraY('id' => $re['user_id'], 'depart_id' => $this->depart_id)));
            //var_dump($re);
            if ($re['m_pic']) $re['m_pic'] = $this->picAddrs($re['m_pic'], true);
            $re['username'] = $username ? $username : '';
            ajaxReturn(1, $re);
        }
    }

    /**
     * 删除
     * */
    public function delAction()
    {
        if ($this->_request->getPost()) {
            $id = $this->_request->getPost('id');
            if (!$id) ajaxReturn(0, '');
            $userinfo = $this->data->get(array('id', 'user_id', 'b_money', 'm_consume', 'm_payment', 'total_payment', 'total_consume', 'refund', 'balance'), array('id' => $id));
            $user_name = $this->user->get('username', array('id' => $userinfo['user_id']));
            $re = $this->data->update(array('del' => 1), array('id' => $id));
            if (!$re) ajaxReturn(0, '删除失败');
//            $m_pic = $this->data->get('m_pic',array('id'=>$id));
//            $this->delPic($m_pic);
            $user_name = isset($user_name) ? $user_name : '未知用户';
            $data = $userinfo;
            $data['username'] = $user_name;
            $content = $this->contentItem($data);
            $this->log->add(3, $content);
            ajaxReturn(1, '删除成功');
        }
    }


    /**
     * 修改对账状态
     * */
    public function updateStatusAction()
    {
        if ($this->_request->getPost()) {
            $id = $this->_request->getPost('id');
            $status = $this->_request->getPost('status');
            if (!$id) ajaxReturn(0, '参数错误');
            $statu = $status == 0 ? 1 : 0;
            $re = $this->data->update(array('status' => $statu), array('id' => $id));

            if ($re) {
                $userid = $this->data->get('user_id', array('id' => $id));
                $user_name = $this->user->get('username', array('id' => $userid));
                $user_name = isset($user_name) ? $user_name : '未知用户';
                $status = $statu == 1 ? '已对账' : '未对账';
                $data = array(
                    'id' => $id,
                    'depart' => '数据定制',
                    'status' => $status,
                    'username' => $user_name
                );
                $content = $this->contentItem($data, 1);
                $this->log->add(2, $content);
                ajaxReturn(1, '修改成功');
            }
            ajaxReturn(0, '修改失败');
        }

    }

}