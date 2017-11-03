<?php


include APP_PATH."/library/sdk/taobao/TopSdk.php";
include APP_PATH."/library/sdk/taobao/top/TopClient.php";
include APP_PATH."/library/sdk/taobao/top/RequestCheckUtil.php";
include APP_PATH."/library/sdk/taobao/top/request/TbkItemsDetailGetRequest.php";

/**
 * 抓取商品类
 * ＠author zb
 */
class Component_Grab 
{
    
    private $infoppkey = "21321716";
    private $secret = "3867c28038e5ab4fd90e4d637e3fa502";

    public function taobao($url)
    {
        //获取numid
        $url=htmlspecialchars($url);//获取商品链接
        preg_match('/id=\d*/', $url, $u);
        if (empty($u))
        {
            return "url错误";
        }
        $num_iid = str_replace('id=', '', $u[0]);//商品id

        $c = new TopClient;
        $c->appkey = $this->infoppkey;
        $c->secretKey = $this->secret;
        $c->format = 'json';
        $req = new TbkItemsDetailGetRequest;
        $req->setFields("num_iid,seller_id,nick,title,price,volume,pic_url,item_url,shop_url");
        $req->setNumIids($num_iid);
        $resp = $c->execute($req);

        $result = isset($resp->tbk_items->tbk_item) ? $resp->tbk_items->tbk_item : null;

        if ($result)
        {
            return $result[0];
        }
        else
        {
            return "该商品抓取数据失败，可能原因该商品未设置淘宝佣金";
        }
    }
    
    
    /**
     * 京东商品
     * @return 没有数据，就返回false
     */
    public function jd($url)
    {
        $url=htmlspecialchars($url);//获取商品链接
        preg_match("/\d+/", $url, $u);
        
        if (empty($u))
        {
            return "url错误";
        }

        $num_iid = str_replace('id=', '', $u[0]);//商品id
        
        
        $info = fn_get_contents("http://d.360buy.com/fittingInfo/get?skuId={$num_iid}&callback=Recommend.cbRecoFittings",array(),'get');
        
        if (strpos("Recommend.cbRecoFittings", $info) != 0)
        {
            return false;
        }
        
        $info = str_replace("Recommend.cbRecoFittings (", "", $info);
        $info = str_replace(")", "", $info);
        
        $info = json_decode($info, true);
        $info = $info['master'];
        $info['pic'] = "http://img13.360buyimg.com/n1/". $info['pic'];
        
        return $info;
    }
}