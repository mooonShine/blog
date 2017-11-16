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
            if (isset($info['id'])) {
                $res = $this->article->editArticle($info);
                if($res['ret'] == '1') {
                    fn_ajax_return(0, "修改成功！", "");
                } else if($res['ret'] == '2') {
                    fn_ajax_return(1, "修改失败！", "");
                }else {
                    fn_ajax_return(2, "系统繁忙，请联系管理员！", "");
                }
            } else {
                $res = $this->article->addArticle($info);
                if($res['ret'] == '1') {
                    fn_ajax_return(0, "添加成功！", "");
                } else if($res['ret'] == '2') {
                    fn_ajax_return(1, "添加失败！", "");
                }else {
                    fn_ajax_return(2, "系统繁忙，请联系管理员！", "");
                }
            }
        }
        $info = $this->_request->getQuery('id');
        if (isset($info) && $info && is_numeric($info)) {
            $info = $this->article->get('*', ['id' =>$info]);
        }
        $class = new Model_Class();
        $class_arr = $class->select(['id','name'],['is_del'=>0]);
        $this->assign('info', isset($info) ? $info : []);
        $this->assign('class', $class_arr);
        $this->assign('errorMsg', $this->errorMsg);
        $this->display('article/add');
    }
    /*
     * 删除文章
     */
    public function delAction()
    {
        $id = $this->_request->getParam('id');
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $this->article->del($id);
        }
        fn_js_redirect('删除成功！', '/article/index');
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
    * 删除恢复
    */
    public function statusAction()
    {
        $id = $this->_request->getPost('id');
        $status = $this->_request->getPost('status');
        $info=$status?'冻结':'解冻';
        if(!$id||!is_numeric($id)){
            fn_ajax_return(1, "参数错误！", "");
        }
        $res=$this->article->update(array('is_del'=>$status),array('id'=>$id));
        if($res===false)fn_ajax_return(1, $info."失败！", "");
        fn_ajax_return(0, $info."成功！", "");
    }
}
