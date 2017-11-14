<?php
/**
 * Created by IntelliJ IDEA.
 * User: zh
 * Date: 17-2-8
 * Time: 下午4:55
 */
class Model_Report extends Smodel
{
    protected $table = "report";

    /**
     * 获取列表
     */
    public function getList($condition, $p, $r = 20)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['ORDER'] = ' date desc,id desc';
        $where['LIMIT'] = array(($p - 1) * $r, $r);
        $field=array('id','user_id','ad_id','pv','click','date');
        $list = $this->select($field, $where);
        $list = $this->externalConnection($list);
        return array('list' => $list, 'count'=> ceil($count / $r));
    }

    /**
     * @param $condition
     * @param $p
     * @param int $r
     * @return array
     */
    public function sumData($data,$condition=array())
    {
        $where = $this->listCondition($condition);
        return $this->sum($data,$where);
    }

    /**
     * 条件处理
     * */
    public function listCondition($condition)
    {
        $users = new Model_Users();
        $advert= new Model_Advert();
        if(!$condition)return array();
        $where =array();
        if(isset($condition['status'])&& $condition['status']&&isset($condition['username'])&&$condition['username']){
            switch ($condition['status']){
                case 1:
                    $wheres['AND']['title[~]'] = $condition['username'];
                    $advert = $advert->select('id',$wheres);
                    $where['AND']['ad_id'] = $advert;
                    break;
                case 2:
                    $wheres['AND']['id'] = $condition['username'];
                    $advert = $advert->select('id',$wheres);
                    $where['AND']['ad_id'] = $advert;
                    break;
                case 3:
                    $wheres['AND']['house_name[~]'] = $condition['username'];
                    $advert = $advert->select('id',$wheres);
                    $where['AND']['ad_id'] = $advert;
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
        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['date[>=]'] =strtotime($condition['start_date']);
        }
        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['date[<]'] = strtotime($condition['end_date']) + 86399;
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
        $advert = new Model_Advert();
        $users = new Model_Users();
        $advert_field = array('title','pic','house_name','click_url');
        $users_field = array('user_name','contact','phone','flow','email');
        $default_adinfo=array(
            'title'=>'-',
            'pic'=>0,
            'house_name'=>'-',
            'click_url'=>'',
        );
        $default_usinfo=array(
            'user_name'=>'-',
            'email'=>'-',
            'contact'=>'-',
            'phone'=>'-',
            'flow'=>0,
        );
        foreach($list as $k=>$v) {
            $ad_where['AND']['id'] =$v['ad_id'];
            $us_where['AND']['id']=$v['user_id'];
            $adinfo = $advert->get($advert_field,$ad_where);
            $userinfo = $users->get($users_field,$us_where);
            if(!$adinfo){
                $adinfo=$default_adinfo;
            }
            if(!$userinfo){
                $userinfo=$default_usinfo;
            }
            $list[$k] = array_merge($v, $adinfo,$userinfo);
        }
        return $list;
    }
}