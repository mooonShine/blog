<?php

/**
 * Created by IntelliJ IDEA.
 * User: lidc
 * Date: 17-2-21
 * Time: 下午3:25
 */
class Model_CrowdPack extends Smodel
{
    protected $table = "crowd_pack";

    public function getCrowdPack($condition=[],$flie='*')
    {
        $where = $this->listCondition($condition);
        $list = $this->select($flie,$where);
        if($list)
        {
            foreach ($list as &$value)
            {
                if(isset($value['conditions'])){
                    $value['conditions'] = json_decode($value['conditions'],true);
                }
            }
        }
        return $list;
    }


    private function listCondition($condition=[]){
        $data = [];
        if(isset($condition['name']) && $condition['name'])
        {
            $data['AND']['name'] = $condition['name'];
        }
        if(isset($condition['tp']) && $condition['tp'])
        {
            $data['AND']['tp'] = $condition['tp'];
        }
        if(isset($condition['create_by']) && $condition['create_by'])
        {
            $data['AND']['create_by'] = $condition['create_by'];
        }
        if(isset($condition['uid']) && $condition['uid'])
        {
            $data['AND']['uid'] = $condition['uid'];
        }
        if(isset($condition['id']) && $condition['id'])
        {
            $data['AND']['id'] = $condition['id'];
        }
        return $data;
    }

}