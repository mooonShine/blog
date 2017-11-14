<?php

/**
 * Created by IntelliJ IDEA.
 * User: lidc
 * Date: 17-2-8
 * Time: 上午10:25
 */
class Model_Advert extends Smodel
{
    protected $table = "advert";

    /**
     * 获取列表
     * */
    public function getList($condition = array(),$p = 1, $size = 10)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['LIMIT'] = array(($p - 1) * $size, $size);
        $where['ORDER'] =' id desc ' ;
        $list = $this->select('*',$where);
        if($list){
            $list = $this->getUser($list);
        }
        return array('list'=>$list,'count'=> ceil($count / $size));
    }

    /**
     * 获取用户信息
     * */
    public function getUser($list){
        $users = new Model_Users();
        $userArr =array();
        foreach ($list as $key=>$value)
        {
            $userArr[]= $value['user_id'];
        }
        $userlist = $users->select(array('id','user_name','contact','phone','flow','email'),array('id'=>$userArr));
        if($userlist){
            $newList =array();
            foreach ($userlist as $k=>$v){
                $newList[$v['id']] = $v;
            }
        }
        if($list){
            foreach ($list as $l=>$i)
            {
                if(isset($newList[$i['user_id']]))
                {
                    $list[$l]['user_name'] = $newList[$i['user_id']]['user_name'];
                    $list[$l]['contact'] = $newList[$i['user_id']]['contact'];
                    $list[$l]['phone'] = $newList[$i['user_id']]['phone'];
                    $list[$l]['flow'] = $newList[$i['user_id']]['flow'];
                    $list[$l]['email'] = $newList[$i['user_id']]['email'];
                }else{
                    $list[$l]['user_name'] = '未知';
                    $list[$l]['contact'] = '未知';
                    $list[$l]['phone'] = '无';
                    $list[$l]['flow'] = '0';
                    $list[$l]['email'] = '无';
                }
            }
        }

        return $list;
    }

    /**
     * 列表条件筛选
     * */
    public function listCondition($condition=array())
    {
        $where = array();
        if(isset($condition['title']) && $condition['title']){
            $where['AND']['title[~]'] =$condition['title'];
        }
        if(isset($condition['review_status'])){
            $where['AND']['review_status'] = $condition['review_status'];
        }

        if(isset($condition['status_type'])&& $condition['status_type']&&isset($condition['username'])&&$condition['username']){
            $users = new Model_Users();
            switch ($condition['status_type']){
                case 1:
                    $where['AND']['title[~]'] = $condition['username'];
                    break;
                case 2:
                    $where['AND']['id'] = $condition['username'];
                    break;
                case 3:
                    $where['AND']['house_name[~]'] = $condition['username'];
                    break;
                case 4:
                    $wheres['AND']['user_name[~]'] = $condition['username'];
                    $user = $users->select('id',$wheres);
                    $where['AND']['user_id'] = $user;
                    break;
                case 5:
                    $wheres['AND']['contact[~]'] = $condition['username'];
                    $user = $users->select('id',$wheres);
                    $where['AND']['user_id'] = $user;
                    break;
                case 6:
                    $wheres['AND']['phone[~]'] = $condition['username'];
                    $user = $users->select('id',$wheres);
                    $where['AND']['user_id'] = $user;
                    break;
                case 7:
                    $wheres['AND']['email[~]'] = $condition['username'];
                    $user = $users->select('id',$wheres);
                    $where['AND']['user_id'] = $user;
                    break;
                default:
                    break;
            }
        }
        if(isset($condition['check_status']) && $condition['check_status'])
        {
            $where['AND']['review_status[!]'] =0;
        }

        if(isset($condition['put_status']) && $condition['put_status']!='')
        {
            $where['AND']['put_status'] =$condition['put_status'];
        }
        if(isset($condition['weight']) && $condition['weight'])
        {
            $where['AND']['weight'] =$condition['weight'];
        }


        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['create_time[<]'] = strtotime($condition['end_date'].' 23:59:59');
        }

        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['create_time[>=]'] = strtotime($condition['start_date'].' 00:00:00');
        }
        $where['AND']['is_del'] = 0;
        return $where;
    }

    public function getInfo($aid)
    {
        $info = $this->get("*", ['id' => $aid]);
        return $info;
    }

    public function verification($info)
    {
        $data['AND']['click_url']= $info['click_url'];
        $data['AND']['pic']= $info['pic'];
        return $this->get('id', $data);
    }

    public function editSimple($where, $data)
    {
        return $this->update($data, $where);
    }

}