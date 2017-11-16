<?php

/**
 * Created by IntelliJ IDEA.
 * User: zh
 * Date: 17-2-8
 * Time: 上午10:25
 */
class Model_Article extends Smodel
{
    protected $table = "article";

    /**
     * 获取列表
     */
    public function getList($condition, $p, $r = 20)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['ORDER'] = ' id desc ';
        $where['LIMIT'] = array(($p - 1) * $r, $r);
        $list = $this->select('*', $where);
        $list = $this->externalConnection($list,$condition);
        return array('list' => $list, 'count'=> ceil($count / $r));
    }

    /**
     * 添加文章
     */
    public function addArticle($infos)
    {
        $this->_checkData($infos);
        $data=array(
            'title'=>$infos['title'],
            'class_id'=>$infos['class_id'],
            'pic'=>$infos['pic'],
            'content'=>$infos['content'],
            'signature'=>$infos['signature'],
            'create_time'=>time()
        );
        $list = $this->insert($data);
        echo $this->last_query();die;
        if($list){
            return array('ret'=>'1');
        }else{
            return array('ret'=>'2');
        }
    }

    /**
     * @param $data
     * @info 检查数据合法性
     * 2017-02-15　modify by zh
     */
    public function checkUser($data)
    {
        if(isset($data['user_name'])&&$data['user_name']){
            $info = $this->select('id',array('user_name'=>$data['user_name']));
            if(count($info)>0){
                fn_ajax_return(1, "用户名已存在！", "");
            }
        }
        if(isset($data['phone'])&&$data['phone']){
            $info = $this->select('id',array('phone'=>$data['phone']));
            if(count($info)>0){
                fn_ajax_return(1, "手机号已存在！", "");
            }
        }
        if(isset($data['email'])&&$data['email']){
            $info = $this->select('id',array('email'=>$data['email']));
            if(count($info)>0){
                fn_ajax_return(1, "邮箱已存在！", "");
            }
        }
    }

    /**
     * 验证数据
     * @return [type] [description]
     */
    private function _checkData($data)
    {
        if (!isset($data['title']) || !$data['title']) {
            fn_ajax_return(1, "标题必填！", "");
        }
        if (!isset($data['class_id']) || !$data['class_id']) {
            fn_ajax_return(1, "分类必选！", "");
        }
        if (!isset($data['pic']) || !$data['pic']) {
            fn_ajax_return(1, "图片必须上传！", "");
        }
        if (!isset($data['content']) || !$data['content']) {
            fn_ajax_return(1, "内容必填！", "");
        }

        if (!isset($data['signature']) || !$data['signature']) {
            fn_ajax_return(1, "署名必填！", "");
        }
    }

    /**
     * 条件处理
     * */
    public function listCondition($condition)
    {
        if(!$condition)return array();
        $where =array();
        if(isset($condition['name']) && $condition['name']){
            $where['AND']['OR']['title[~]'] = $condition['title'];
            $where['AND']['OR']['signature[~]'] = $condition['signature'];
        }
        if(isset($condition['is_del']) && $condition['is_del']){
            $where['AND']['is_del'] = $condition['is_del'];
        }
        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['create_time[>=]'] = strtotime($condition['start_date']. ' 00:00:00');
        }
        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['create_time[<=]'] = strtotime($condition['end_date']. ' 23:59:59');
        }
        return $where;
    }

    /**
     * 连接外表
     */
    public function externalConnection($list) {
        if(empty($list)) {
            return array();
        }
        $class = new Model_Class();
        foreach($list as $k=>$v) {
            $list[$k]['class_id'] = $class->get('name',['id' => $v['class_id']]);
            $list[$k]['content'] = isset($v['content']{50}) ? substr($v['content'], 0, 50) . '...' : $v['content'];
        }
        return $list;
    }

    /*
     * 获取单条信息
     */
    public function getInfo($id)
    {
        return $this->get("*", ['id' => $id]);
    }

    /*
     * 伪删除
     */
    public function del($id)
    {
        return $this->update(['is_del'=>2],['id'=>$id]);
    }

}