<?php
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2016/12/6
 * Time:  13:36
 */
class Model_Income extends Smodel
{
    protected $table = "income";


    /**
     * 年份
     * */
    public function getYears(){
        return arraY(
            '1'=>2014,
            '2'=>2015,
            '3'=>2016,
            '4'=>2017,
            '5'=>2018,
            '6'=>2019,
            '7'=>2020,
        );
    }

    /**
     * 月份
     * */
    public function getMonth(){
        return arraY(
            '1'=>'1月',
            '2'=>'2月',
            '3'=>'3月',
            '4'=>'4月',
            '5'=>'5月',
            '6'=>'6月',
            '7'=>'7月',
            '8'=>'8月',
            '9'=>'9月',
            '10'=>'10月',
            '11'=>'11月',
            '12'=>'12月',
        );
    }

    public function getList($condition, $p, $r = 10)
    {
        $where = $this->listCondition($condition);
        $count = $this->count($where);
        $where['ORDER'] =' id desc ' ;
        $where['LIMIT'] = array(($p - 1) * $r, $r);
        $list = $this->select('*',$where);
        return array('list'=>$list,'count'=>$count);
    }

    /**
     * 图片地址处理成josn
     * */

    public function  picAddrs($picData ,$EXTENSION = false)
    {
        if($EXTENSION){
            if(!$picData) return '';
            $picData = json_decode($picData);
            $fileName = array();
            foreach($picData as $k=>$v){
                $fileName[$k]['pic'] = $v;
                $fileName[$k]['fileName'] = basename($v);
            }
            return $fileName;
        }else{
            if(!$picData) return '';
            $picData = str_replace(array('[',']'),'',$picData);
            $picData = explode(',',$picData);
            if(!$picData[0]) return '';
            return json_encode ($picData);
        }
    }

    /**
     * 获取部门所属客户组
     * */
    public function getUsername($depart_id)
    {
        $user = new Model_User();
        if(!$depart_id) $depart_id = -1;
        return $user->select(array('id','username','zhi_userid','depart_id'),array('depart_id'=>$depart_id));
    }

    /**
     * 条件处理
     * */
    public function listCondition($condition)
    {
        if(!$condition)return array();
        $where =array();
        if(isset($condition['user_id']) && $condition['user_id']){
            $where['AND']['user_id'] = $condition['user_id'];
        }
        if(isset($condition['start_date'])&& $condition['start_date']){
            $where['AND']['date[>=]'] = $condition['start_date'];
        }
        if(isset($condition['end_date']) && $condition['end_date']){
            $where['AND']['date[<]'] = $condition['end_date'];
        }
        if(isset($condition['depart_id']) && $condition['depart_id']){
            $where['AND']['depart_id'] = $condition['depart_id'];
        }

        if(isset($condition['total_payment']) && $condition['total_payment']){
            if($condition['total_payment']==1){
                $where['AND']['total_payment[<]'] = 500000;
            }else{
                $where['AND']['total_payment[>=]'] = 500000;
            }
        }
        return $where;
    }

    /**
     * 累计收款统计
     * */
    public function totalPayment($totalPayment,$years,$month,$condition)
    {
        $where = ' 1=1 ';
        $years = strtotime($years.'-1');

        if($totalPayment==2){
            $where .= " and total_payment>=500000 ";
        }elseif($totalPayment==1){
            $where .= " and total_payment<500000 ";
        }
        if(isset($condition['user_id'])&&is_numeric($condition['user_id'])){
            $where .= " and user_id={$condition['user_id']} ";
        }
        $where .= " and date>={$years} ";
        $where .= " and date<{$month} ";

        $sql = sprintf('select id,user_id,sum(total_payment) as total_payment,sum(total_consume) as total_consume from %sincome where  %s GROUP BY user_id ORDER BY id desc ', $this->prefix,$where);

        $lists = $this->query($sql);
        $list= $lists->fetchAll();
        if($list){
            $data = array();
            foreach($list as $key=> $val){
                $data[$val['user_id']]['user_id']=$val['user_id'];
                $data[$val['user_id']]['total_payment']=$val['total_payment'];
                $data[$val['user_id']]['total_consume']=$val['total_consume'];
            }
            return $data;
        }
        return array();

    }


    /**
     * 删除相对路径图片
     * */
    public function delPic($pic){
        $pic = json_decode($pic,true);
        if($pic){
            foreach($pic as $key=>$val){
                @unlink(BASE_PATH.'/public'.$val);
            }
        }
    }

}