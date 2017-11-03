<?php
/**
 * Created By:  PhpStorm
 * Author: zhanghuang@pv25.com
 * Date:  2017/1/11
 * Time:  11:54
 * 任务计划入口文件
 */
define('BASE_PATH', dirname(__FILE__)."/");
if ( isset($argv[1]) )
{
    $medooPath = BASE_PATH . '../library/Medoo.php';
    includeFile(BASE_PATH.'class/FinanceHelper.php');
    includeFile(BASE_PATH. 'class/Finance.php');
    includeFile($medooPath);
    class Smodel extends Medoo{
        protected $table='';
        public function setTable($table){
            $this->table=$table;
        }
    }    //medoo是个抽象类


    $action  = $argv[1];
    $report = new Finance();
    $report->$action();
    // save_log($action);   //如果需要记录运行log 这个打开
}else{
    exit('请输入正确的参数' . PHP_EOL);
}

/**
 * 引入文件用
 */
function includeFile( $filePath )
{
    if ( file_exists($filePath) ) {
        include_once $filePath;
    }else{
        exit($filePath . ' 未找到');
    }
}

/**
 * 记录日志
 */
function save_log( $action )
{
    $file_name = 'crontab_' . date('YmdHi') . '.log';
    $file_path = __DIR__ . '/log';
    $txt = '执行时间:' . date('Y-m-d H:i:s') . ' 运行' . $action . '完成';
    if (!is_dir( $file_path ))
    {
        mkdir( $file_path, 0777 );
    }
    $file = $file_path . "/" . $file_name;
    file_put_contents($file,$txt,FILE_APPEND);
}