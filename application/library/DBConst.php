<?php

/**
 * 常量类
 * @author zhengbo
 */
class DBConst
{
    //投放类型
    const PUT_TYPE_CPC = 0;
    const PUT_TYPE_CPM = 1;
    const PUT_TYPE_HOT = 2;
    const PUT_TYPE_BANNER = 3;
    const PUT_TYPE_WAP = 50;
    const PUT_TYPE_MAP = 60;

    static public $price_limit = array(  //投放种类价格限制
        '0' => 0.3,
        '1' => 0.3,
        '2' => 0.3,
        '3' => 0.5,
        '50' => 0.3
    );

    public static function getPriceLimit()
    {
        return self::$price_limit;
    }

    public static function getPcType()
    {
        return array(0,2,3,60);
    }

    public static function getMobileType()
    {
        return array(50);
    }
}