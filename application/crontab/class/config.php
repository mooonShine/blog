<?php
$ini_file = realpath(__DIR__ .'/../../conf/config.ini');
if ( !file_exists($ini_file) ) exit('无配置文件');

$config = parse_ini_file( $ini_file );
return array(
    'mysql' => array(
            'server' => $config['database.params.master.server'],
            'username' => $config['database.params.master.username'],
            'password' => $config['database.params.master.password'],
            'database_type' => $config['database.params.master.database_type'],
            'database_name' => $config['database.params.master.database_name'],
            'charset' => $config['database.params.master.charset'],
            'port' => $config['database.params.master.port'],
            'prefix' => $config['database.params.master.prefix'],
            'master' => $config['database.params.master.master'],
    ),
);
