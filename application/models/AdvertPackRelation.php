<?php
/**
 * Created by IntelliJ IDEA.
 * User: lidc
 * Date: 17-3-21
 * Time: 下午3:50
 */

class Model_AdvertPackRelation extends Smodel
{
    protected $table = 'advert_pack_relation';


    public function getAdvertPack($condition=[])
    {
        $where =[];
        if(isset($condition['ad_id']) && $condition['ad_id'])
        {
            $where['AND']['ad_id'] = $condition['ad_id'];
        }
        if(isset($condition['pack_id']) && $condition['pack_id'])
        {
            $where['AND']['pack_id'] = $condition['pack_id'];
        }
        $list =  $this->select('*',$where);
        if($list)
        {
            $list = $this->getCRowdPackId($list);
        }
        return $list;
    }

    private function getCRowdPackId($list)
    {
        $packId = [];
        foreach ($list as $key=>$value)
        {
            $packId[] = $value['pack_id'];
        }
        $crowdPack = new Model_CrowdPack();
        $data = $crowdPack->getCrowdPack(['id'=>$packId],['id','name','conditions','tp']);
        return $data;
    }


}