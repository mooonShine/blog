<?php
/**
 * Created by IntelliJ IDEA.
 * User: zhanghuang
 * Date: 17-11-15
 * Time: 下午1:44
 */
class Controller_Class extends Base
{

    protected $layout = "layouts";
    private $errorMsg = array();
    protected $class;

    public function init()
    {
        parent::init();
        $this->class = new Model_Class();
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
        $list = $this->class->getList($condition, $p, 10);
        $this->assign('list', $list['list']);
        $this->assign('count', $list['count']);
        $this->display('class/index');
    }

    /*
     * 添加
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            $info = $this->_request->getPost();
            $res = $this->class->add($info);
            if($res['ret'] == '1') {
                fn_ajax_return(0, "添加成功！", "");
            } else if($res['ret'] == '2') {
                fn_ajax_return(1, "添加失败！", "");
            }else {
                fn_ajax_return(2, "系统繁忙，请联系管理员！", "");
            }
        }
        $class = $this->class->select('*',[]);
        $this->assign('class', $class);
        $this->assign('errorMsg', $this->errorMsg);
        $this->display('class/add');
    }
    /*
     * 删除分类
     */
    public function delAction()
    {
        $id = $this->_request->getPost('id');
        $res = $this->class->del($id);
        if ($res['ret'] == 1) {
            fn_ajax_return(0, "删除成功！", "");
        }else {
            fn_ajax_return(1, "删除失败！", "");
        }
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
}
