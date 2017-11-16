<?php
/**
 * Created by IntelliJ IDEA.
 * User: zh
 * Date: 17-2-7
 * Time: 下午5:07
 * info: 客户管理控制器
 */
class Controller_Article extends Base
{

    protected $layout = "layouts";
    private $errorMsg = array();
    protected $article;

    public function init()
    {
        parent::init();
        $this->article = new Model_Article();
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
            $condition['end_date']=date('Y-m-d',time());
        }
        $list = $this->article->getList($condition, $p, 10);
        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('article/index');
    }

    /*
     * 添加
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            $info = $this->_request->getPost();
            $res = $this->article->addArticle($info);
            if($res['ret'] == '1') {
                fn_ajax_return(0, "添加成功！", "");
            } else if($res['ret'] == '2') {
                fn_ajax_return(1, "添加失败！", "");
            }else {
                fn_ajax_return(2, "系统繁忙，请联系管理员！", "");
            }
        }
        $class = new Model_Class();
        $class_arr = $class->select(['id','name'],['is_del'=>0]);
        $this->assign('class', $class_arr);
        $this->assign('errorMsg', $this->errorMsg);
        $this->display('article/add');
    }
    /*
     * 删除用户
     */
    public function delAction()
    {
        $id = $this->_request->getParam('id');
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $this->user->delUser($id);
        }
        fn_js_redirect('删除成功！', '/article/index');
    }

    /*
     * 重置密码
     */
    public function resetAction()
    {
        $id = $this->_request->getPost('id');
        if(!$id||!is_numeric($id)){
            fn_ajax_return(1, "参数错误！", "");
        }
        $pwd=md5('a1234567');
        $res=$this->user->update(array('password'=>$pwd),array('id'=>$id));
        if($res===false)fn_ajax_return(1, "重置失败！", "");
        fn_ajax_return(0, "重置成功！", "");
    }
    /**
     * 上传图片
     * 添加数据使用
     * */
    public function uploadAction()
    {
        if (!isset($_FILES['Filedata']['name'])) ajaxReturn(0, '上传错误');
        $a = fn_upload_img('Filedata');
        exit($a);

    }

    /*
    * 冻结解冻
    */
    public function statusAction()
    {
        $id = $this->_request->getPost('id');
        $status = $this->_request->getPost('status');
        $info=$status?'冻结':'解冻';
        if(!$id||!is_numeric($id)){
            fn_ajax_return(1, "参数错误！", "");
        }
        $res=$this->user->update(array('status'=>$status),array('id'=>$id));
        if($res===false)fn_ajax_return(1, $info."失败！", "");
        fn_ajax_return(0, $info."成功！", "");
    }

    /*
     * 修改比率
     */
    public function editFrateAction()
    {
        $id = $this->_request->getPost('uid');
        $frate= $this->_request->getPost('frate');
        if(!$id||!is_numeric($id)||!$frate||!is_numeric($frate)){
            fn_ajax_return(1, "参数错误！", "");
        }
        $res=$this->user->update(array('frate'=>$frate),array('id'=>$id));
        if($res===false)fn_ajax_return(1, "修改失败！", "");
        fn_ajax_return(0, "修改成功！", "");
    }
    /**
     * 用户名,手机号,邮箱验证
     */
    public function verificationAction(){
        $info = $this->_request->getPost();
        $this->user->checkUser($info);
        fn_ajax_return(0, "验证通过！", "");
    }

    /**
     * 客户申请
     * */
    public function applyAction()
    {
        $p = fn_get_val('p', 1);
        $condition['is_delete'] = 0;
        $list = $this->apply->getList($condition,$p, 10);
        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('article/apply');
    }

    /**
     * 客户不合格
     * */
    public function applyCheckAction()
    {
        $id = $this->_request->getPost('id');
        if(!$id) fn_ajax_return(1, "参数不对！", "");
        $info['id'] = $id;
        $info['status'] = 1;
        $info['is_delete'] = 1;
        $this->apply->applyStatus($info);
        fn_ajax_return(0, "设置成功！", "");
    }

    /**
     * 客户保留
     * */
    public function applyConfirmAction()
    {
        $id = $this->_request->getPost('id');
        if(!$id) fn_ajax_return(1, "参数不对！", "");
        $info['id'] = $id;
        $info['status'] = 2;
        $this->apply->applyStatus($info);
        fn_ajax_return(0, "设置成功！", "");
    }
}