<?php

/**
 * Description of File
 *
 * @author sjm
 * @date 2013-09-11
 *
 * @edit:2014-12-17
 */
class Component_Redis
{

    private $_redis = NULL;
    private $_redis_config = array(
        'host' => '192.168.1.112',
        'port' => '6379',
        'pwd' => ''
    );

    public function __construct( $_config = array() )
    {
        if ($_config)
        {
            $this->_redis_config = array(
                'host' => $_config['host'],
                'port' => $_config['port'],
                'pwd' => ''
            );
        } else
        {

            $_redis_config = Yaf_Application::app()->getConfig()->toArray();

            if (isset( $_redis_config['redis']['params']['host'] ) && $_redis_config['redis']['params']['host'])
            {
                $this->_redis_config['host'] = $_redis_config['redis']['params']['host'];
            }
            if (isset( $_redis_config['redis']['params']['port'] ) && $_redis_config['redis']['params']['port'])
            {
                $this->_redis_config['port'] = $_redis_config['redis']['params']['port'];
            }
            if (isset( $_redis_config['redis']['params']['pwd'] ) && $_redis_config['redis']['params']['pwd'])
            {
                $this->_redis_config['pwd'] = $_redis_config['redis']['params']['pwd'];
            }
        }

        $this->_redis = new Redis();
        $this->_redis_connect();
    }

    private function _redis_connect()
    {
        try {
            $this->_redis->connect( $this->_redis_config['host'], $this->_redis_config['port'], 10000 );
            if ($this->_redis_config['pwd'])
            {
                $this->_redis->auth( $this->_redis_config['pwd'] );
            }
        } catch (Exception $exc) {
            $this->_redis = NULL;
        }
    }

    /*
     * title:追增字符串到$key的值 return 追加后的长度
     *       $key:[string]
     *       $value:[string]
     */

    public function append( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->append( $key, (string) $value );
    }

    /*
      // Simple key -> value set
      $redis->set('key', 'value');

      // Will redirect, and actually make an SETEX call
      $redis->set('key','value', 10);

      // Will set the key, if it doesn't exist, with a ttl of 10 seconds
      $redis->set('key', 'value', Array('nx', 'ex'=>10);

      // Will set a key, if it does exist, with a ttl of 1000 miliseconds
      $redis->set('key', 'value', Array('xx', 'px'=>1000);

     */

    public function set( $key = NULL, $value = NULL, $time = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        if ($time && (is_int( $time ) || is_array( $time )))
        {
            return $this->_redis->set( $key, $value, $time );       //$time 秒为单位
        } else
        {
            return $this->_redis->set( $key, $value );
        }
    }

    public function setex( $key = NULL, $time = 0, $value = NULL )
    {
        return $this->set( $key, $value, $time );
    }

    /*
     * title:设置$key的值$value,如果不存在,则成功,反之失败, return true or false;
     */

    public function setnx( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->setnx( $key, $value );
    }

    public function get( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        $d = $this->_redis->get( $key );
        return $d;
    }

    /*
     * title:删除key,返回删除数量
     *      $key:[string,array]
      $redis->delete('key1', 'key2'); return 2
      $redis->delete(array('key3', 'key4'));  return 2
     */

    public function del( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->delete( $key );
    }

    /*
     * title :检测key是否存在,return true or return false
     *      $key:[string]
     */

    public function exists( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->exists( $key );
    }

    /*
     * title :设置key过期时间,return true or return false
     *      $key:[string],
     *      $time:[int]
     */

    public function expire( $key = NULL, $time = 86400 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->expire( $key, (int) $time );
    }

    /*
     * title :设置key过期时间[时间戳],return true or return false
     *      $key:[string],
     *      $time:[int时间戳]
     */

    public function expireAt( $key = NULL, $time = 0 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->expireAt( $key, $time );
    }

    /*
     * $redis->incr('key1');  key1 didn't exists, set to 0 before the increment
      and now has the value 1
      $redis->incr('key1'); 2
      $redis->incr('key1');  3
      $redis->incr('key1'); 4
      $redis->incrBy('key1', 10); 14
     */

    public function incr( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->incr( $key );
    }

    //见上面
    public function incrBy( $key = NULL, $count = 0 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        $count = intval( $count );
        return $this->_redis->incrBy( $key, $count );
    }

    /*
     * title:增加key浮点精度的值,return 增加后的新值
     *      $key:[string]
     */

    public function incrByFloat( $key = NULL, $value = 0.0 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->incrByFloat( $key, $value );
    }

    /*
     * title:自减1 return 自减后的结果
     *      $key:[string]
     */

    public function decr( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->incr( $key );
    }

    /*
     * title:从$key数值中减掉$count ,return 减后的结果
     *      $key:[string],
     *      $count:[int]
     */

    public function decrBy( $key = NULL, $count = 0 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        $count = intval( $count );
        return $this->_redis->incrBy( $key, $count );
    }

    /*
     * title:获取$key中$start_len位置到$end_len位位置的值 [第一个位位置是0],return string
     *      $key:[string],
     *      $start_len:[int]
     *      $end_len:[int]
     */

    public function getRange( $key = NULL, $start_len = 0, $end_len = 0 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->getRange( $key, (int) $start_len, (int) $end_len );
    }

    /*
     * title:从$start_len位置替换$key的值为$value,保留其他,只替换$value长度,return 新的长度
     *      $key:[string],
     *      $start_len:[int]
     *      $value:[string]
     */

    public function setRange( $key = NULL, $start_len = 0, $value = NULL )
    {
        if (!$key || !$this->_redis || !is_string( $value ))
        {
            return FALSE;
        }
        return $this->_redis->setRange( $key, (int) $start_len, $value );
    }

    /*
     * title:获取一个key值的长度
     *      $key:[string],
     */

    public function strlen( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->strlen( $key );
    }

    /*
     * $redis->set('key1', 'value1');
      $redis->set('key2', 'value2');
      $redis->set('key3', 'value3');
      $redis->mGet(array('key1', 'key2', 'key3'));  array('value1', 'value2', 'value3');
      $redis->mGet(array('key0', 'key1', 'key5'));  array(`FALSE`, 'value2', `FALSE`);
     */

    public function mGet( $key_value = array() )
    {
        if (!$key_value || !is_array( $key_value ) || !$this->_redis)
        {
            return array();
        }

        return $this->_redis->mGet( $key_value );
    }

    /*
     * title:多个key同时设置,array('k1'=>'v1','k2'=>'v1'),return true or false
     */

    public function mSet( $key_value = array() )
    {
        if (!$key_value || !is_array( $key_value ) || !$this->_redis)
        {
            return array();
        }
        return $this->_redis->mSet( $key_value );
    }

    /*
     * title:多个key同时设置,array('k1'=>'v1','k2'=>'v1'),return true or false
     * 注意:如果其中任何一个key已存在,则都不会被设置
     */

    public function mSetNX( $key_value = array() )
    {
        if (!$key_value || !is_array( $key_value ) || !$this->_redis)
        {
            return array();
        }
        return $this->_redis->mSetNX( $key_value );
    }

    /*
     * $redis->set('x', '42');
      $exValue = $redis->getSet('x', 'lol');  // return '42', replaces x by 'lol'
      $newValue = $redis->get('x')'       // return 'lol'
     */

    public function getSet( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        if ($this->exists( $key ))
        {
            return $this->_redis->getSet( $key, $value );
        }
        return FALSE;
    }

    //注:$key绝不能为*,key大,很严重;

    public function keys( $key = "*" )
    {
        if ($key == "*" || !$this->_redis)
        {
            return array();
        }
        return $this->_redis->keys( $key );
    }

    //真正获取所有吸key
    public function get_keys( $key = "*" )
    {
        if (!$key || !$this->_redis)
        {
            return array();
        }
        return $this->_redis->keys( $key );
    }

    /*
     * title:移动key到db_index数据库 ,return true or false;
     *      $key:[string]
     *      $db_index:[0~15]
     */

    public function move( $key = NULL, $db_index = 0 )
    {
        if (!$key || $db_index > 15 || $db_index < 0 || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->move( $key, $db_index );
    }

    //随机一个key返回
    public function randomKey()
    {
        if (!$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->randomKey();
    }

    /*
     * title:key重命名,return true or false
     *       $old_key:[string]
     *       $new_key:[string]
     * 注意:如果$new_key本身就存在,重命名后,则复盖原来的$new_key的值,切记
     *
     */

    public function rename( $old_key = NULL, $new_key = NULL )
    {
        if (!$old_key || !$new_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->rename( $old_key, $new_key );
    }

    /*
     * title:key重命名,return true or false
     *       $old_key:[string]
     *       $new_key:[string]
     * 注意:如果$new_key本身就存在,重命名失败
     *
     */

    public function renameNx( $old_key = NULL, $new_key = NULL )
    {
        if (!$old_key || !$new_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->renameNx( $old_key, $new_key );
    }

    //获限key的类型
    public function type( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->type( $key );
    }

    /*
     * title:排序列表中的元素,根据实际情况返回值不同
     *  $key:[string]
     *  $option:[array]
      array(
      'by' => 'some_pattern_*',
      'limit' => array(0, 1),
      'get' => 'some_other_pattern_*' or an array of patterns,
      'sort' => 'asc' or 'desc',
      'alpha' => TRUE,
      'store' => 'external-key'
      )
     *
     */

    public function sort( $key = NULL, $option = array() )
    {
        if (!$key || !is_array( $option ) || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->sort( $key, $option );
    }

    //返回key有效期时间,无有效期:返回-1,当key不存在:返回-2
    public function ttl( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->ttl( $key );
    }

    /*
     * title:获取正则$pattern所有key,和keys命令类似,return array;
     *      $pattern:[string]
     *      $count:[int]
     */

    public function Scan( $pattern = NULL, $count = 10 )
    {
        $ret = array();
        if (!$this->_redis)
        {
            return FALSE;
        }
//        $this->_redis->setOption( Redis::OPT_SCAN, Redis::SCAN_RETRY );
        $it = NULL;
        while ($arr_keys = $this->_redis->Scan( $it, $pattern, $count ))
        {
            foreach ($arr_keys as $v)
            {
                $ret[] = $v;
            }
        }
        return $ret;
    }

    //HASH表操作

    /*
     * title:设置$key中$hash_key元素值为$value,return true or false;
     * 注:如果$key的中的元素存在,则$value值复盖旧的值
     *      $key:[string]
     *      $hash_key:[string]
     *      $value:[string]
     */

    public function hSet( $key = NULL, $member_key = NULL, $value = NULL )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->hSet( $key, (string) $member_key, (string) $value );
    }

    /*
     * title:设置$key的hash表中$member_key成员的值,return true or false;
     *      $key:[string]
     *      $member_key:[array]
     */

    public function hMSet( $key = NULL, $member_key = array() )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hMSet( $key, $member_key );
    }

    //同上
    //注:如果$key的中的元素存在,则设置失败
    public function hSetNx( $key = NULL, $member_key = NULL, $value = NULL )
    {
        if (!$key || !$member_key || !$this->_redis || !$value)
        {
            return FALSE;
        }

        return $this->_redis->hSetNx( $key, $member_key, $value );
    }

    /*
     * title:获取$key的hash表中$member_key成员的值,return string or false;
     *      $key:[string]
     *      $member_key:[string]
     */

    public function hGet( $key = NULL, $member_key = NULL )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hGet( $key, $member_key );
    }

    /*
     * title:获取$key的hash表中$member_key成员的值,return array;
     *      $key:[string]
     *      $member_key:[array]
     */

    public function hMGet( $key = NULL, $member_key = array() )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hMGet( $key, $member_key );
    }

    /*
     * title:获取$key的hash表中所有成员的值,return array;
     *      $key:[string]
     */

    public function hGetAll( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hGetAll( $key );
    }

    /*
     * title:检测$member_key成员是否在$key的hash表中,return true or false
     *      $key:[string]
     *      $member_key:[string]
     */

    public function hExists( $key = NULL, $member_key = NULL )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hExists( $key, $member_key );
    }

    /*
     * title:增加$int到$key的hash表中$member_key的值,return 增加后的整数数值
     *      $key:[string]
     *      $member_key:[string]
     *      $int:[int]
     */

    public function hIncrBy( $key = NULL, $member_key = NULL, $int = 0 )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hIncrBy( $key, $member_key, (int) $int );
    }

    /*
     * title:增加$float到$key的hash表中$member_key的值,return 增加后的浮点数值
     *      $key:[string]
     *      $member_key:[string]
     *      $float:[float]
     */

    public function hIncrByFloat( $key = NULL, $member_key = NULL, $float = 0 )
    {
        if (!$key || !$member_key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hIncrByFloat( $key, $member_key, (float) $float );
    }

    /*
     * title:获取$key的hash表中所有成员,return array;
     *      $key:[string]
     */

    public function hKeys( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hKeys( $key );
    }

    /*
     * title:获取$key的hash表中成员个数,return 整数数值 or false;
     *      $key:[string]
     */

    public function hLen( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hLen( $key );
    }

    /*
     * title:获取$key的hash表中所有成员值,return array;
     *      $key:[string]
     */

    public function hVals( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hVals( $key );
    }

    /*
     * title:删除$key的hash表中$member_key,return 1 or 0 ->true or false;
     *      $key:[string]
     *      $member_key:[string]
     */

    public function hDel( $key = NULL, $member_key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->hDel( $key, $member_key );
    }

    /*
     * title:获取$key的hash表中正则$pattern所有成员值,return array;
     *      $key:[string],
     *      $pattern:[string]
     */

    public function hScan( $key = NULL, $pattern = NULL, $count = 10 )
    {
        $ret = array();
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
//        $this->_redis->setOption( Redis::OPT_SCAN, Redis::SCAN_RETRY );
        $it = NULL;
        while ($arr_keys = $this->_redis->hScan( $key, $it, $pattern, $count ))
        {
            foreach ($arr_keys as $k => $v)
            {
                $ret[$k] = $v;
            }
        }
        return $ret;
    }

    //Lists

    /*
     * title:按参数 key 的先后顺序依次检查各个列表，弹出第一个非空列表的头元素 return array
     *
     *      $key:[array]
     *      $timeout:[int]
     */

    public function blPop( $key = array(), $timeout = 2 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->blPop( (array) $key, $timeout );
    }

    /*
     * title:按参数 key 的先后顺序依次检查各个列表，弹出第一个非空列表的尾元素 return array
     *
     *      $key:[array]
     *      $timeout:[int]
     */

    public function brPop( $key = array(), $timeout = 2 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->brPop( (array) $key, $timeout );
    }

    /*
     * title:(1)将列表 $key 中的最后一个元素(尾元素)弹出，并返回给客户端。
      (2)将 $key 弹出的元素插入到列表 $dstkey ，作为 $dstkey 列表的的头元素
     */

    public function brpoplpush( $key = NULL, $dstkey = NULL, $timeout = 2 )
    {
        if (!$key || !$dstkey || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->brPop( $key, $dstkey, $timeout );
    }

    /*
     * title:获限$key列表中索引$index的值 return string or false
     *      $key:[string]
     *      $index:[int]
     */

    public function lIndex( $key = NULL, $index = 0 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->lIndex( $key, (int) $index );
    }

    public function lGet( $key = NULL, $index = 0 )
    {
        return $this->lIndex( $key, $index );
    }

    /*
     * title:将值 value 插入到列表 key 当中，位于值 pivot 之前或之后 当key或者pivot不存在时,
     * return:(1)返回0,-1[pivot不存在],操作失败,(2)返回大于0的整数,操作在功
     *      $key:[string]
     *      $position:(before,after)
     *      $pivot:[string]
     *      $value:[string]
     */

    public function lInsert( $key = NULL, $position = 'before', $pivot = NULL, $value = NULL )
    {
        if (!$key || !$position || !$this->_redis)
        {
            return FALSE;
        }
        $position = $position ? $position : 'before';
        $_pt = Redis:: AFTER;
        if (strtolower( $position ) == 'before')
        {
            $_pt = Redis:: BEFORE;
        }
        return $this->_redis->lInsert( $key, $_pt, $pivot, $value );
    }

    /*
     * title:获取列表 key 的长度。return int or false
     *      $key:[string]
     */

    public function lLen( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lLen( $key );
    }

    /*
     * title:移除并返回列表 key 的头元素。return STRING or false
     *      $key:[string]
     */

    public function lPop( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lPop( $key );
    }

    /*
     * title:將$value值插入到列表key的头元素。return int or false
     *      $key:[string]
     */

    public function lPush( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lPush( $key, $value );
    }

    /*
     * title:將$value值插入到列表key的头元素。return int or false
     * 返回:(1)当key不存在,返回0,(2)成功返回位数,(3)当key不是列表时返回false;
     *      $key:[string]
     */

    public function lPushx( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lPushx( $key, $value );
    }

    /*
     * title:获取列表 key 中指定区间内的元素，区间以偏移量 $start_index 和 $end_index 指定索引地址。
     * return array
     *      $key:[string]
     *      $start_index:[int]
     *      $end_index:[int]
     *
     */

    public function lRange( $key = NULL, $start_index = 0, $end_index = -1 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lRange( $key, (int) $start_index, (int) $end_index );
    }

    /*
     * title:移除列表key中$count个等于$value的值 return 成功的个数,当key不是list返回false
     *      $key :[string]
     *      $value :[string]
     *      $count :[int]
     */

    public function lRem( $key = NULL, $value = NULL, $count = 1 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lRem( $key, $value, (int) $count );
    }

    /*
     * title:设置列表key中索引位置$index的值$value return true or false;
     *      $key :[string]
     *      $index :[int]
     *      $value :[string]
     */

    public function lSet( $key = NULL, $index = 0, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lSet( $key, (int) $index, $value );
    }

    /*
     * title:保留索引$start_index至$end_index的所有列表值,其他都删除;
     *      $key :[string]
     *      $start_index :[int]
     *      $end_index :[int]
     */

    public function lTrim( $key = NULL, $start_index = 0, $end_index = -1 )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->lTrim( $key, (int) $start_index, (int) $end_index );
    }

    /*
     * title:移除并返回列表 key 的尾元素。return STRING or false
     *      $key:[string]
     */

    public function rPop( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->rPop( $key );
    }

    /*
     * title:(1)将列表 $key 中的最后一个元素(尾元素)弹出，并返回给客户端。
      (2)将 $key 弹出的元素插入到列表 $dstkey ，作为 $dstkey 列表的的头元素
     */

    public function rpoplpush( $key = NULL, $dstkey = NULL )
    {
        if (!$key || !$dstkey || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->brPop( $key, $dstkey );
    }

    /*
     * title:將$value值插入到列表key的尾元素。return int or false
     *      $key:[string]
     *      $value:[string]
     */

    public function rPush( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->rPush( $key, $value );
    }

    /*
     * title:將$value值插入到列表key的尾元素。return int or false
     * 返回:(1)当key不存在,返回0,(2)成功返回位数,(3)当key不是列表时返回false;
     *      $key:[string]
     */

    public function rPushx( $key = NULL, $value = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->rPushx( $key, $value );
    }

    //无序集合
    /*
     *
     * title :增加无序集合
     * content: $value:[string],return 1 or return 0
     *          $value:[array],return array
     */

    public function sAdd( $key = NULL, $value = NULL, $result = FALSE )
    {
        if (!$key || !$value || !$this->_redis)
        {
            return FALSE;
        }
        if (is_array( $value ))
        {
            if ($result)
            {
                foreach ($value as $v)
                {
                    if ($v)
                    {
                        $ret[$v] = $this->_redis->sAdd( $key, $value );
                    }
                }
            } else
            {
                $v = $this->member_array( array($key), $value );
                $ret = call_user_func_array( array($this->_redis, "sAdd"), $v );
            }
        } else
        {
            $ret = $this->_redis->sAdd( $key, $value );
        }
        return $ret;
    }

    /*
     * title:获限无序集合长度
     * content:$key:[string]
     */

    public function sCard( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->sCard( $key );
    }

    /*
     * title:获限无序集合中差集
     * content:$key:[string]为主key,
     *         $diff_key:[string,array]对比差集key,已$key为主体
     */

    public function sDiff( $key = NULL, $diff_key = NULL )
    {
        if (!$key || !$diff_key || !$this->_redis)
        {
            return FALSE;
        }
        $v = $this->member_array( array($key), $diff_key );
        return $this->_redis->sDiff( $v );
    }

    /*
     * title:获限无序集俣中差集结果并放入$key中
     * content:$key:[string]放入结果集key
     *         $main_key:[string]比较差集主key,
     *         $diff_key:[string,array]对比差集key,已$main_key为主体
     */

    public function sDiffStore( $key = NULL, $main_key = NULL, $diff_key = NULL )
    {
        if (!$key || !$main_key || !$diff_key || !$this->_redis)
        {
            return FALSE;
        }

        $v = $this->member_array( array($key, (string) $main_key), $diff_key );
        return $this->_redis->sDiffStore( $v );
    }

    /*
     * title:获限无序集合的交集
     * content: $key:[string,array]
     */

    public function sInter( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->sInter( (array) $key );
    }

    /*
     * title:获限无序集合中交集结果并放入$key中
     * content:$key:[string]放入结果集key
     *         $inter_key:[string,array]交集,
     */

    public function sInterStore( $key = NULL, $inter_key = NULL )
    {
        if (!$key || !$inter_key || !$this->_redis)
        {
            return FALSE;
        }

        $v = $this->member_array( array($key), $inter_key );
        return $this->_redis->sInterStore( $v );
    }

    /*
     * title:获限无序集合中合集
     * content: $key:[string,array]
     */

    public function sUnion( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }

        return $this->_redis->sUnion( (array) $key );
    }

    /*
     * title:获限无序集合中合集结果并放入$key中
     * content:$key:[string]放入结果集key
     *         $inter_key:[string,array]交集,
     */

    public function sUnionStore( $key = NULL, $union_key = NULL )
    {
        if (!$key || !$union_key || !$this->_redis)
        {
            return FALSE;
        }

        $v = $this->member_array( array($key), $union_key );
        return $this->_redis->sUnionStore( $v );
    }

    /*
     * title:检查$value值是否在key集合中 return true or return false
     *      $key:[string]
     */

    public function sIsMember( $key = NULL, $value = NULL )
    {
        if (!$key || !$value || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->sIsMember( $key, $value );
    }

    /*
     * title:获取key集合 return array
     *       $key:[string]
     */

    public function sMembers( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return array();
        }
        return $this->_redis->sMembers( $key );
    }

    /*
     * title:移动$from_key集合中$value值到$to_key return true or return false
     *       $from_key:[string]
     *       $to_key:[string]
     *       $value:[string]
     */

    public function sMove( $from_key = NULL, $to_key = NULL, $value = NULL )
    {
        if (!$from_key || !$to_key || !$value || !$this->_redis)
        {
            return FALSE;
        }
        $v = $this->member_array( array($from_key, $to_key), $value );
        return call_user_func_array( array($this->_redis, "sMove"), $v );
    }

    /*
     * title:随机弹出一个value,并移除, return value or return false;
     *       $key:[string]
     */

    public function sPop( $key = NULL )
    {
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->sPop( $key );
    }

    /*
     * title:随机弹出$count个value,不移除, return value or return array;
     *       $key:[string]
     */

    public function sRandMember( $key = NULL, $count = 0 )
    {
        if (!$key || !$count || !is_numeric( $count ) || !$this->_redis)
        {
            return FALSE;
        }
        return $this->_redis->sRandMember( $key, intval( $count ) );
    }

    /*
     * title:移除$key集合中$value, return移出个数;
     *       $key:[string]
     */

    public function sRem( $key = NULL, $value = NULL )
    {
        if (!$key || !$value || !$this->_redis)
        {
            return FALSE;
        }
        $v = $this->member_array( array($key), $value );
        return call_user_func_array( array($this->_redis, "sRem"), $v );
    }

    public function sScan( $key= NULL, $pattern="*" )
    {
        $ret = array();
        if (!$key || !$this->_redis)
        {
            return FALSE;
        }
        $it = NULL;
        while ($arr_mems = $this->_redis->sscan( $key, $it, $pattern ))
        {
            foreach ($arr_mems as $v)
            {
                $ret[] = $v;
            }
        }
    }
    //有序集合



    private function member_array( $v_header, $v_main )
    {
        return array_filter( array_merge( $v_header, (array) $v_main ) );
    }

    public function close()
    {
        $this->_redis->close();
    }

    public function __destruct()
    {
        if ($this->_redis)
        {
            $this->close();
        }
    }

}
