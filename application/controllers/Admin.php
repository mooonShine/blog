<?php

/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/6
 * Time:  11:09
 */
class Controller_Admin extends Base
{

    protected $layout = 'layouts';
    protected $admin = '';
    protected $user = '';
    protected $log = '';

    public function init()
    {
        parent::init();
        $this->admin = new Model_Admin();
        $this->user = new Model_User();
        $this->log = new Model_Log();
    }

    /**
     * @Author: zhanghuang@pv25.com
     * @Time:  2016-12-6
     * 后台账号管理首页
     */
    public function indexAction()
    {
        $d = intval(date("d")) - 1;
        $date_start = '- ' . $d . 'day';
        $date = fn_get_date($date_start, '0 day');
        $bdate = $date['bdate'];
        $edate = $date['edate'];
        $page = $this->_request->getQuery('p');
        $page = $page ? $page : 1;
        $rows = $this->_request->getQuery('pageSize');
        if (!$rows) {
            $rows = 20;
        }
        $user_name = $this->_request->getQuery('user_name');
        $permi = $this->_request->getQuery('permi');
        $where = array();
        if ($user_name) {
            $where['user_name'] = $user_name;
        }
        if ($permi != 0) {
            $where['permi'] = $permi;
        }
        $list = $this->admin->getList($where, $page, $rows);
        $page = new Component_Page($page, $list['count'], $this->_a, $rows);
        $this->assign('beginDate', fn_ymd($bdate));
        $this->assign('endDate', fn_ymd($edate));
        $this->assign('page', $page->display());
        $this->assign('list', $list);
        $this->display('admin/index');
    }

    /**
     * @Author: zhanghuang@pv25.com
     * @Since:2016-12-09
     * @Info:验证用户名
     */
    public function validationUserAction()
    {
        if ($this->_request->getPost()) {
            $username = $this->_request->getPost('username');
            if (!$username) ajaxReturn(0, '用户必填');
            $user = new Model_Admin();
            $re = $user->get('id', array('username' => $username));
            if ($re) ajaxReturn(0, $re);
            ajaxReturn(1, '可以添加');
        }
        ajaxReturn(0, '非法请求');
    }

    /**
     * @Author: zhanghuang@pv25.com
     * @Since:
     * @Info:
     */
    public function addUserAction()
    {

        IF ($this->_request->getPost()) {
            $data = $this->_request->getPost();
            $type = $this->_request->getPost('type');
            if (!$data && !$type) ajaxReturn(0, '数据错误');
            $salt = $this->admin->getSalt();
            $datas = array(
                'username' => $data['username'],
                'permi_id' => $data['permi_id']
            );
            if ($type == 'add') {
                $info['username'] = $data['username'];
                $info['permi_id'] = $data['permi_id'];
                $info['create_time'] = time();
                $where['update_time'] = time();
                $info['salt'] = $salt;
                $info['password'] = md5(md5($data['password']) . "_" . $salt);
                $re = $this->admin->insert($info);
                $contents = $this->contentItem($datas, 2);
                $this->log->add(1, $contents);
            } else {
                $id = $data['id'];
                $info['salt'] = $salt;
                $info['permi_id'] = $data['permi_id'];
                $info['password'] = md5(md5($data['password']) . "_" . $salt);
                $info['update_time'] = time();
                $re = $this->admin->update($info, array('id' => $id));
                $contents = $this->contentItem($datas, 2);
                $this->log->add(2, $contents);
            }
            if ($re) ajaxReturn(1, $re);
            ajaxReturn(0, '添加失败');

        }
        ajaxReturn(0, '非法请求');
    }

    /**
     *获取后台用户信息
     * */
    public function userInfoAction()
    {
        if ($this->_request->getPost()) {
            $id = $this->_request->getPost('id');
            if (!$id) ajaxReturn(0, '参数错误');
            $info = $this->admin->get(array('id', 'username', 'permi_id'), array('id' => $id));
            if ($info) ajaxReturn(1, $info);
            ajaxReturn(0, '获取失败');
        }
        ajaxReturn(0, '非法请求');
    }

    /*
     * 编辑开放开关
     */
    public function openEditAction()
    {
        $fc = new FileCache();
        $o = $this->_request->getQuery("ed");

        if ($o == 1) {
            $fc->set("canedit", "ok", time() + 86400 * 365);
        } else {
            $fc->set("canedit", "no", time() + 86400 * 365);
        }
        fn_ajax_return(0, "ok");
    }
}