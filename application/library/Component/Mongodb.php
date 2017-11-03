<?php

/**
 * Created by IntelliJ IDEA.
 * User: godsoul
 * Date: 15-6-17
 * Time: 下午2:25
 */
class Component_Mongodb
{
    public static $mongo_instance = null;
    private $debug = false;
    public function __construct()
    {
        self::$mongo_instance = self::getInstance();
        $this->getDebug();
    }

    /**
     * 获取是否是debug模式
     * @return [type] [description]
     */
    private function getDebug()
    {
        $conf = Yaf_Registry::get('config');
        if (isset($conf["application"]["showErrors"]) && $conf["application"]["showErrors"] == "1") {
            $this->debug = true;
        }
    }

    /**
     * 获取实例
     * @return [type] [description]
     */
    public static function getInstance()
    {
        try {
            if (self::$mongo_instance == null) {
//                $conf = Yaf_Registry::get('config');
//                $host = $conf["mongo"]["params"]["host"];
//                $port = $conf["mongo"]["params"]["port"];
//                $db_name = $conf["mongo"]["params"]["db_name"];
//                $db_user = $conf["mongo"]["params"]["db_user"];
//                $db_pwd = $conf["mongo"]["params"]["db_pwd"];
                $ini_config = Yaf_Application::app()->getConfig()->toArray();
                //var_dump($ini_config);die;
                $mongo_config = $ini_config['mongodb']['cookie']['params'];
                $host = $mongo_config['host'];
                $db_name = $mongo_config['db'];
                $connect_str = sprintf("mongodb://%s/%s", $host, $db_name);

                $connect = new MongoClient($connect_str);
                $db = $connect->$db_name;
                self::$mongo_instance = $db;
            }
            return self::$mongo_instance;
        } catch (MongoException $e) {
            exit("数据库连接失败");
        }
    }

    /**
     * 查找
     * @param  array $where [查询数组]
     * @param  array $field [查询字段]
     * @return [type]        [description]
     */
    public function find($table,$where = array(), $field = array(), $option = array())
    {
        try {
            $connect = self::getInstance();
            $list = array();

            if (!$table) {
                exit("数据表未定义");
            }

            $coursor = $connect->$table->find($where, $field);

            if (isset($option['skip']) && !empty($option['skip'])) {
                $coursor = $coursor->skip($option['skip']);
            }
            if (isset($option['limit']) && !empty($option['limit'])) {
                $coursor = $coursor->limit($option['limit']);
            }
            if (isset($option['sort']) && !empty($option['sort'])) {
                $coursor = $coursor->sort($option['sort']);
            }

            foreach ($coursor as $data) {
                if (isset($data["_id"])) {
                    $data["_id"] = (string)$data["_id"];
                }

                $list[] = $data;
            }

            return $list;
        } catch (MongoException $e) {
            if ($this->debug) {
                exit($e->getMessage());
            } else {
                exit("查询发生错误");
            }
        }
    }

    /**
     * 插入
     * @param  array $data [数据]
     * @param  array $option [选项]
     */
    public function insert($table,$data, $option = array())
    {
        try {
            $connect = self::getInstance();
            $list = array();

            if (!$table) {
                exit("数据表未定义");
            }
            //生成ID
            if (!isset($data['_id'])) {
                $data['_id'] = $this->MID();
            }
            $connect->$table->insert($data, $option);
            return (string)$data['_id'];
        } catch (MongoException $e) {
            if ($this->debug) {
                exit($e->getMessage());
            } else {
                exit("插入失败");
            }
        }
    }

    /**
     * 修改
     * @param  array $where [查询数据]
     * @param  array $data [修改数据]
     * @param  array $option [选项]
     */
    public function update($table,$where, $data, $option = array())
    {
        try {
            $connect = self::getInstance();
            $list = array();

            if (!$table) {
                exit("数据表未定义");
            }
            //$option['multiple'] = true;
            $connect->$table->update($where, $data, $option);
        } catch (MongoException $e) {
            if ($this->debug) {
                exit($e->getMessage());
            } else {
                echo $e->getMessage();
                exit("更新失败");
            }
        }
    }

    /**
     * 删除
     * @param  array $where [查询数据]
     * @param  array $option [选项]
     */
    public function remove($table,$where, $option = array())
    {
        try {
            $connect = self::getInstance();
            $list = array();

            if (!$table) {
                exit("数据表未定义");
            }

            $connect->$table->remove($where, $option);
        } catch (MongoException $e) {
            if ($this->debug) {
                exit($e->getMessage());
            } else {
                exit("删除失败");
            }
        }
    }

    /**
     * 获取数量
     * @param  [type]  $where [description]
     * @param  integer $limit [description]
     * @param  integer $skip [description]
     * @return [type]         [description]
     */
    public function count($table,$where, $limit = 0, $skip = 0)
    {
        try {
            $connect = self::getInstance();
            $list = array();

            if (!$table) {
                exit("数据表未定义");
            }
            return $connect->$table->count($where, $limit, $skip);
        } catch (MongoException $e) {
            if ($this->debug) {
                exit($e->getMessage());
            } else {
                exit("获取个数失败");
            }
        }
    }

    /**
     * 查找一条数据
     * @param string $table
     * @param  array $where [查询数组]
     * @param  array $field [查询字段]
     * @return [type]        [description]
     */
    public function get($table,$where = array(), $field = array())
    {
        try {
            $connect = self::getInstance();
            if (!$table) {
                exit("数据表未定义");
            }

            $data = $connect->$table->findOne($where, $field);
            if (isset($data["_id"])) {
                $data["_id"] = (string)$data["_id"];
            }

            return $data;
        } catch (MongoException $e) {
            if ($this->debug) {
                exit($e->getMessage());
            } else {
                exit("查询发生错误");
            }
        }
    }

    /**
     * 获取mongodb　ID对象
     * 用于查询根据_id查询，或者生成唯一_id
     * @param [type] $str [description]
     */
    public function MID($str = null)
    {
        return new MongoId($str);
    }

    public function MidValid($str)
    {
        try {
            $a = new MongoId($str);
            return true;
        } catch (MongoException $e) {
            return false;
        }
    }

}