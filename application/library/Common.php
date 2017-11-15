<?php

//==============================================================================
//                          公共方法
//                      代码规范：以fn开头
//==============================================================================

/**
 * 获取远程内容（接口数据获取）
 * @param $url
 * @param array $keysArr
 * @param string $mothod
 * @param bolen $is_header
 * @param int $flag
 * @return mixed
 */
function fn_get_contents($url, $keysArr = array(), $mothod = 'get', $is_header = 1, $flag = 0)
{
    $ch = curl_init();
    if (!$flag) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if (strtolower($mothod) == 'post') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
    } else {
        $url = $url . "?" . http_build_query($keysArr);
    }
    curl_setopt($ch, CURLOPT_URL, $url);

    if ($is_header) {
        $_time = time();
        $headers['ktime'] = $_time;
        $headers['kmd5'] = md5($_time . fn_get_interface_key());
        foreach ($headers as $n => $v) {
            $headerArr[] = md5($n) . ':' . $v;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
    }

    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

/*
 * 获限interface接口，加密key
 * @author :Sgenmi
 * @date : 2014-07-13
 *
 */

function fn_get_interface_key()
{
    $interface_key = "#&0%o#d8$*s&5u^@*^s456";
    $_config = Yaf_Application::app()->getConfig();
    if (isset($_config->keys->interface_key)) {
        $interface_key = $_config->keys->interface_key;
    }
    return $interface_key;
}

/*
 * 获限interface接口，加密key
 * @author :Sgenmi
 * @date : 2014-07-13
 *
 */

function fn_get_invite_user_key()
{
    $invite_user_key = "#&0%o#d8$*s&5u^@*^s456";
    $_config = Yaf_Application::app()->getConfig();
    if (isset($_config->keys->invite_user)) {
        $invite_user_key = $_config->keys->invite_user;
    }
    return $invite_user_key;
}

/**
 * 获取POST或GET提交的值
 * @param $name
 * @param string $default
 * @return string
 */
function fn_get_val($name, $default = '')
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    return $default;
}

/**
 * JS跳转
 * @param string $msg
 * @param string $url
 */
function fn_js_redirect($msg = '', $url = '')
{
    header('Content-Type:text/html;charset=utf-8');

    $js = '<script type="text/javascript">';

    if (!empty($msg)) {
        $js .= "alert('$msg');";
    }

    if (!empty($url)) {
        $js .= "window.location = '$url';";
    }

    echo $js . '</script>';
}

/**
 * Ajax 返回JSON
 * @param  integer $return 0：失败， 1：成功
 * @param  string $message 提示信息
 * @param  array $data 返回的数据
 * @return JSON
 * */
function fn_ajax_return($return = 0, $message = null, $data = null)
{
    $r_data['ret'] = $return;
    if ($message) {
        $r_data['msg'] = $message;
    }
    if ($data) {
        $r_data['data'] = $data;
    }

    exit(json_encode($r_data));
}

//获取IP

function fn_get_ip()
{
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknow";
    }

    return $ip;
}

/**
 * 验证码 字符类型
 * getCode(4,60,20);
 * @param type $num
 * @param type $w
 * @param type $h
 */
function fn_get_code()
{
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $text = "";
    $num = array();
    for ($i = 0; $i < 4; $i++) {
        $num[$i] = rand(0, 25);
        $text .= $str[$num[$i]];
    }

    $_SESSION['verify_code'] = strtolower($text);

    $im_x = 160;
    $im_y = 40;
    $im = imagecreatetruecolor($im_x, $im_y);
    $text_c = ImageColorAllocate($im, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));
    $tmpC0 = mt_rand(100, 255);
    $tmpC1 = mt_rand(100, 255);
    $tmpC2 = mt_rand(100, 255);
    $buttum_c = ImageColorAllocate($im, $tmpC0, $tmpC1, $tmpC2);
    imagefill($im, 16, 13, $buttum_c);

    $font = realpath(BASE_PATH . '/public/t1.ttf');

    for ($i = 0; $i < strlen($text); $i++) {
        $tmp = substr($text, $i, 1);
        $array = array(-1, 1);
        $p = array_rand($array);
        $an = $array[$p] * mt_rand(1, 10); //角度
        $size = 28;
        imagettftext($im, $size, $an, 15 + $i * $size, 35, $text_c, $font, $tmp);
    }

    $distortion_im = imagecreatetruecolor($im_x, $im_y);
    imagefill($distortion_im, 16, 13, $buttum_c);
    for ($i = 0; $i < $im_x; $i++) {
        for ($j = 0; $j < $im_y; $j++) {
            $rgb = imagecolorat($im, $i, $j);
            if ((int)($i + 20 + sin($j / $im_y * 2 * M_PI) * 10) <= imagesx($distortion_im) && (int)($i + 20 + sin($j / $im_y * 2 * M_PI) * 10) >= 0) {
                imagesetpixel($distortion_im, (int)($i + 10 + sin($j / $im_y * 2 * M_PI - M_PI * 0.1) * 4), $j, $rgb);
            }
        }
    }
    //加入干扰象素;
    $count = 160; //干扰像素的数量
    for ($i = 0; $i < $count; $i++) {
        $randcolor = ImageColorallocate($distortion_im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imagesetpixel($distortion_im, mt_rand() % $im_x, mt_rand() % $im_y, $randcolor);
    }

    $rand = mt_rand(5, 30);
    $rand1 = mt_rand(15, 25);
    $rand2 = mt_rand(5, 10);
    for ($yy = $rand; $yy <= +$rand + 2; $yy++) {
        for ($px = -80; $px <= 80; $px = $px + 0.1) {
            $x = $px / $rand1;
            if ($x != 0) {
                $y = sin($x);
            }
            $py = $y * $rand2;

            imagesetpixel($distortion_im, $px + 80, $py + $yy, $text_c);
        }
    }

    //设置文件头;
    Header("Content-type: image/JPEG");

    //以PNG格式将图像输出到浏览器或文件;
    ImagePNG($distortion_im);

    //销毁一图像,释放与image关联的内存;
    ImageDestroy($distortion_im);
    ImageDestroy($im);
}

/*
 * author:Sgenmi
 * date:2014-06-13
 * 判断是否在时间段
 */

function fn_time_interval($time_interval, $time = null)
{
    $is_true = false;
    $week = array(
        0 => 6, //星期天
        1 => 0, //星期一
        2 => 1, //星期二
        3 => 2, //星期三
        4 => 3, //星期四
        5 => 4, //星期五
        6 => 5, //星期六
    );

    if (!isset($time)) {
        $time = time();
    }

    $time_arrya = explode("|", $time_interval);
    $week_array = isset($time_arrya[$week[date('w', $time)]]) ? $time_arrya[$week[date('w', $time)]] : array();
    if ($week_array) {
        $hour_array = str_split($week_array, 1);

        $is_true = isset($hour_array[date('G', $time)]) ? $hour_array[date('G', $time)] : false;
    }

    return $is_true;
}

/**
 * 快速打印数据结果
 */
function d($r)
{
    echo '<pre>';
    print_r($r);
    echo "</pre>";
}

/**
 * 判断是否能开启， 计算投放状态
 */
function fn_canOpen($userid, $adid)
{

//   $put_status = array(
    //        0 => '未投放',
    //        1 => '投放中',
    //        2 => '日限额已到',
    //        3 => '不在投放周期范围',
    //        4 => '未在投放时段内',
    //        5 => '余额不足',
    //        6 => '投放周期已结束',
    //    );
    $url = "http://login.juhuisuan.com/interface/jhs";
    $send_data = array('uid' => $userid, 'fields' => 'money', 'type' => 'getUserInfo');
    $user_info = json_decode(fn_get_contents($url, $send_data, 'post'), true);
    $admodel = new Model_Bidding();
    $model_stats_goods = new Model_StatsGoods();
    $money = $review_status = 0;
    $put_status = 1;
    $time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

    $info = $admodel->get(array('id', 'start_time', 'end_time', 'status', 'review_status', 'day_limit', 'is_open'), array('AND' => array('id' => $adid, 'user_id' => $userid)));

    if ($user_info && $user_info['ret'] == 0) {
        $money = $user_info['data']['money'];
    }

    if ($info !== false) {
        $review_status = $info['review_status'];
        $begin_time = mktime(0, 0, 0, date("m", $info['start_time']), date("d", $info['start_time']), date("Y", $info['start_time']));
        $end_time = mktime(23, 59, 59, date("m", $info['end_time']), date("d", $info['end_time']), date("Y", $info['end_time']));

        $m = $model_stats_goods->get('money', array('AND' => array('user_id' => $userid, 'goods_id' => $adid, 'date' => $time)));

        if ($info['review_status'] == 0) {
            $put_status = 0;
        } else if ($money <= 0) {
            // $put_status = 5; 免费
        } else if ($end_time < $time) {
            $put_status = 6;
        } else if (!($begin_time <= $time && $end_time >= $time)) {
            $put_status = 3;
        } elseif ($m && $m > $info['day_limit']) {
            $put_status = 2;
        } else if ($info['is_open'] == 0) {
            $put_status = 0;
        }
    }

    return $put_status;
}

//记日志

function fn_Log($word = '', $path = "/", $file_name = 'log.txt', $show_time = 1)
{
    $_time = "";
    $file_path = LOG_PATH . $path;
    if (!is_dir($file_path)) {
        fn_mkdir($file_path);
    }
    $file = rtrim($file_path, "/") . "/" . $file_name;

    if ($show_time) {
        $_time = "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n";
    }
    $fp = fopen($file, "a+");
    flock($fp, LOCK_EX);
    fwrite($fp, $_time . $word . "\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

function fn_mkdir($file_path)
{

    $_f = "/";
    if (!$file_path) {
        return;
    }
    $file_path = array_filter(explode("/", $file_path));
    foreach ($file_path as $v) {
        if (!$v) {
            continue;
        }
        $_f .= $v . "/";
        if (!is_dir($_f)) {
            mkdir($_f, 0777);
        }
    }
}

/**
 * 是否是测试环境
 */
function fn_IsTest()
{
    $conf = Yaf_Application::app()->getConfig();
    if (isset($conf->application->debug) && $conf->application->debug == 1) {
        return true;
    }
    return false;
}

/**
 * 获取开始和结束日期，并验证日期合法性
 * @param $bstr , $estr。值例如：+5 hours，next Monday，+1 week 3 days 7 hours 5 seconds，灵活定义起止时间
 * @return array(bdate => $intval_1, edate => $intval_2)，验证传入数据非法，则起始日期默认返回昨天
 * @author lizhe
 */
function fn_get_date($bstr = '-1 day', $estr = '-1 day')
{
    $bdate = 0; //beginDate
    $edate = 0; //endDate
    if (isset($_REQUEST['beginDate']) && isset($_REQUEST['endDate']) && $_REQUEST['beginDate'] && $_REQUEST['endDate'] && strtotime($_REQUEST['beginDate']) && strtotime($_REQUEST['endDate'])) {
        $bdate = intval(strtotime($_REQUEST['beginDate'] . ' 00:00:00'));
        $edate = intval(strtotime($_REQUEST['endDate'] . ' 23:59:59'));
    }
    if ($bdate == 0 || $edate == 0) {
        $bdate = strtotime(date('Y-m-d 00:00:00', strtotime($bstr)));
        $edate = strtotime(date('Y-m-d 23:59:59', strtotime($estr)));
    }
    return array('bdate' => $bdate, 'edate' => $edate);
}

/**
 * 实在不想在页面重复用date写Y-m-d格式了
 * @author lizhe
 */
function fn_ymd($intval)
{
    if (!$intval) {
        return '无';
    }
    return date('Y-m-d', $intval);
}

function fn_ymdhis($intval)
{
    if (!$intval) {
        return '无';
    }
    return date('Y-m-d H:i:s', $intval);
}

/**
 * @param $string
 * @return bool|string
 * @Author: zhanghuang@pv25.com
 * @Since:
 * @Info:
 */
function fn_action($string)
{
    if (!$string) {
        return '未知';
    }
    switch ($string) {
        case 'add':
            $action = '添加动作';
            break;
        case 'update':
            $action = '修改动作';
            break;
        case 'del':
            $action = '删除动作';
            break;
        case 'login':
            $action = '登录动作';
            break;
        case 'logout':
            $action = '登出动作';
            break;
        default:
            $action = '未知动作';
            break;
    }
    return $action;
}

/**
 * @Author: zhanghuang@pv25.com
 * @Since:2016-12-08
 * @Info:获取权限id对应权限
 */
function getAuthName($type)
{
    if (!$type) {
        return '未知';
    }
    switch ($type) {
        case 1:
            $action = '大账号';
            break;
        case 2:
            $action = '财务(看)';
            break;
        case 3:
            $action = '财务';
            break;
        case 4:
            $action = '销售部';
            break;
        case 5:
            $action = '站内';
            break;
        case 6:
            $action = '代理';
            break;
        case 7:
            $action = '谷歌项目';
            break;
        case 8:
            $action = '数据定制';
            break;
        case 9:
            $action = '渠道部';
            break;
        default:
            $action = '未知权限';
            break;
    }
    return $action;
}

/**
 * @Author: zhanghuang@pv25.com
 * @Since:2016-12-08
 * @Info:获取客户所属部门
 */
function getDepartName($type)
{
    if (!$type) {
        return '未知';
    }
    switch ($type) {
        case 1:
            $action = '销售部';
            break;
        case 2:
            $action = '站内';
            break;
        case 3:
            $action = '代理';
            break;
        case 4:
            $action = '谷歌项目';
            break;
        case 5:
            $action = '数据定制';
            break;
        case 6:
            $action = '渠道部';
            break;
        default:
            $action = '未知部门';
            break;
    }
    return $action;
}

/*
 * author :Sgenmi
 * module :模块
 * controller:控制器
 * action:动作
 */

function fn_check_auth($module = null, $controller = null, $action = null)
{
    $ret = false;

    if (!$module || !$controller || !$action) {
        return $ret;
    }
    $auth = Yaf_Session::getInstance()->get('USER_AUTH');
    $module = strtolower($module);
    $controller = strtolower($controller);
    $action = strtolower($action);

    if ($auth && isset($auth[$module]) && isset($auth[$module][$controller]) && isset($auth[$module][$controller][$action])) {
        $ret = true;
    }
    return $ret;
}

/**
 * 从数组中取得需要的字段
 * @return array
 * @author lizhe
 */
function fn_get_array_by_field($array, $field)
{
    if (!is_array($array) || count($array) <= 0 || !$field) {
        return false;
    }
    $new_arr = array();
    foreach ($array as $value) {
        $new_arr[] = $value[$field];
    }
    return $new_arr;
}

/**
 * 把图片上传到图片服务器
 * @param $picPath 本地上图图片的路径(要实际路径)
 * @param $isdel 是否删除本地图片　默认为ture
 * @param sp 特殊的保护目录编号。具体值待定
 * @param $nodeal 不处理图片直接上传
 * @return  返回图片服务器上的图片路径。支持多种图片尺寸。具体看例子
 *  eg: 1.http://image.juhuisuan.com/2014/08/20/2014082011143426078.jpg
 *      2.http://image.juhuisuan.com/2014/08/20/2014082011143426078.jpg.300x250.jpg
 *      3.http://image.juhuisuan.com/2014/08/20/2014082011143426078.jpg.300x200.jpg
 */
function fn_upload_image($picPath, $isdel = true, $sp = null)
{
    if (!file_exists($picPath)) {
        return "";
    }

    $url = "http://imgsrc.juhuisuan.com/upimg.php";
    $v = array(
        'pic' => '@' . $picPath,
    );

    if (isset($sp)) {
        $v['sp'] = $sp;
    }

    $ret = json_decode(fn_get_contents($url, $v, 'post'), true);

    if ($ret['ret'] == 0) {
        if ($isdel) {
            unlink($picPath);
        }
        return "http://img1.juhuisuan.com" . $ret['data'];
    }
    return "";
}

function fn_get_pic($pic)
{
    if (empty($pic)) {
        return $pic;
    }
    return 'http://img1.juhuisuan.com' . str_ireplace(array('http://img1.juhuisuan.com', '//'), '', $pic);
}

/**
 * 上传图片
 * @return [type] [description]
 */
function fn_upload_img($name, $options = array(), $doUpload = true, $saveImg = 'http://img.9xu.com/')
{
    $img_url = 'http://img.pv25.com/upload';
    $result = $name;
    if ($doUpload) {
        $fileDriver = new FileUpload($name);
        $result = $fileDriver->run();
        if (is_array($result)) {
            return json_encode(array('ret' => 1, "msg" => $result[0], "data" => ""));
        } else {
            return json_encode(array('ret' => 1, "msg" => "上传成功", "data" => $result));
        }
    }
    $file_name = realPath(BASE_PATH . '/public' . $result);

    //如果为swf文件 更改后缀名
    $fileExt = fn_get_fileExt($file_name);
    if ($fileExt && $fileExt == 'swf') {
        $options['ext'] = $fileExt;
    }
    if ($fileExt && $fileExt == 'gif') {
        $options['ext'] = $fileExt;
    }
    //读取文件内容
    if (file_exists($file_name)) {
        $content = file_get_contents($file_name);
        //删除文件
        @unlink($file_name);
        //参数构建
        $ext_name = isset($options['ext']) ? $options['ext'] : 'jpg';
        $post_options = array('content' => $content, 'ext' => $ext_name);
        if ($options) {
            if (isset($options['type']) && $options['type'] == "1") {
                $post_options['type'] = "1";
                $post_options['height'] = isset($options['height']) ? intval($options['height']) : 300;
                $post_options['width'] = isset($options['width']) ? intval($options['width']) : 300;
            }
            if (isset($options['type']) && $options['type'] == "2") {
                $post_options['type'] = "2";
                $post_options['height'] = isset($options['height']) ? intval($options['height']) : 300;
                $post_options['width'] = isset($options['width']) ? intval($options['width']) : 300;
                $post_options['p1'] = isset($options['p1']) ? intval($options['p1']) : 0;
                $post_options['p2'] = isset($options['p2']) ? intval($options['p2']) : 0;
                $post_options['p3'] = isset($options['p3']) ? intval($options['p3']) : 300;
                $post_options['p4'] = isset($options['p4']) ? intval($options['p4']) : 300;
            }
        }

        $server_result = fn_get_contents($img_url, $post_options, 'post', 1);

        return json_encode(array('ret' => 0, "msg" => "上传成功", 'data' => $saveImg . trim($server_result)));

    } else {
        return json_encode(array('ret' => 1, "msg" => "文件不存在", 'data' => ""));
    }
}

/**
 * 获取文件后缀
 */
function fn_get_fileExt($fileName)
{
    return substr(strrchr($fileName, '.'), 1);
}

/**
 * var_dump格式化输出
 */
function vd($d)
{
    echo '<pre>';
    var_dump($d);
    echo '</pre>';
}

function fn_shieldUserInfo($fields, &$info)
{
    $session = new Component_Session;
    if ($session->get('GROUP_ID') == 8 || $session->get('GROUP_ID') == 9) {
        foreach ($fields as $v) {
            $info[$v] = '-';
        }
    }
}

/**
 * ajax前台返回
 * @param intval $statusCode 必选。状态码(ok = 200, error = 300, timeout = 301)，可以在BJUI.init时配置三个参数的默认值。
 * @param string $message 可选。信息内容。
 * @param string $tabid 可选。待刷新navtab id，多个id以英文逗号分隔开，当前的navtab id不需要填写，填写后可能会导致当前navtab重复刷新。
 * @param string $closeCurrent 可选。是否关闭当前窗口(navtab或dialog)。
 * @param string $dialogid 可选。待刷新dialog id，多个id以英文逗号分隔开，请不要填写当前的dialog id，要控制刷新当前dialog，请设置dialog中表单的reload参数。
 * @param string $divid 可选。待刷新div id，多个id以英文逗号分隔开，请不要填写当前的div id，要控制刷新当前div，请设置该div中表单的reload参数。
 * @param string $forward 可选。跳转到某个url。
 * @param string $forwardConfirm 可选。跳转url前的确认提示信息。
 */
function fn_json_return($statusCode = 300, $message = null, $tabid = '', $closeCurrent = false, $dialogid = '', $divid = '', $forward = '', $forwardConfirm = '')
{
    $return = array(
        'statusCode' => $statusCode,
        'message' => $message,
        'tabid' => $tabid,
        'closeCurrent' => $closeCurrent,
        'dialogid' => $dialogid,
        'divid' => $divid,
        'forward' => $forward,
        'forwardConfirm' => $forwardConfirm
    );
    exit(json_encode($return));
}

/**
 * 查询想要的数据
 * @author lz
 */
function getData($model, $field, $where, $action, $count, $debug)
{
    $field = json_decode($field, true);
    $where = json_decode($where, true);
    switch ($model) {
        case 'ReportAd':
            $model = new Model_ReportAd();
            break;
        case 'ReportAdDay':
            $model = new Model_ReportAdDay();
            break;
        case 'ReportAdTotal':
            $model = new Model_ReportAdTotal();
            break;
        case 'ReportPd':
            $model = new Model_ReportPd();
            break;
        case 'ReportPdDay':
            $model = new Model_ReportPdDay();
            break;
        case 'AdvertPriceLog':
            $model = new Model_PriceLog();
            break;
        case 'ReportAdDayTmp':
            $model = new Model_ReportAdDayTmp();
            break;
        case 'Advert':
            $model = new Model_Advert();
            break;
        case 'Strategy':
            $model = new Model_Strategy();
            break;
        case 'Audit':
            $model = new Model_Audit();
            break;
        case 'Adsize':
            $model = new Model_Adsize();
            break;
        case 'ReportData':
            $model = new Model_ReportData();
            break;
        case 'ReportDataPrecise':
            $model = new Model_ReportDataPrecise();
            break;
        case 'ReportDataUserTest':
            $model = new Model_ReportDataUserTest();
            break;
        case 'ReportAdDayZj':
            $model = new Model_ReportAdDayZj();
            break;
        case 'ZjClick':
            $model = new Model_ZjClick();
            break;
        default:
            fn_ajax_return(1, '未被允许的model');
            exit;
    }
    //调用模型内部方法
    if ($action) {
        if (!method_exists($model, $action)) {
            fn_ajax_return(1, '方法不存在');
        }
        $res = $model->$action($where);
    } else {

        //var_dump($model);
        $res = $model->select($field, $where);
        //echo $model->last_query();die;
//            exit(json_encode($model->last_query()));
        //var_dump($res);
    }
    if ($res) {
        $result['list'] = $res;
        if (isset($where['GROUP']) && $count) {
            unset($where['LIMIT'], $where['ORDER']);
            $countArray = $model->select('id', $where);
            $result['count'] = count($countArray);
        } elseif ($count) {
            unset($where['LIMIT'], $where['ORDER']);
            $count = $model->count($where);
            $result['count'] = $count;
        }
        if ($debug) {
            $result['sql'] = $model->last_query();
        }
        //var_dump($result) ;
        //fn_ajax_return(0, '', $result);
        $r_data['msg'] = '';
        $r_data['data'] = $result;
        $r_data['ret'] = 0;
        return $r_data;
    } else {
        //fn_ajax_return(1, '操作异常或无数据');
    }
}

function get24Data()
{
    $model = new Model_ReportHours();
    $data = $model->get24HoursData();

    $r_data['ret'] = 1;
    $r_data['msg'] = 200;
    $r_data['data'] = $data;
    return $r_data;
}

function formatArray($array)
{
    sort($array);
    $tem = "";
    $temarray = array();
    $j = 0;
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] != $tem) {
            $temarray[$j] = $array[$i];
            $j++;
        }
        $tem = $array[$i];
    }
    return $temarray;
}

/**
 * 获取配置文件
 */
function fn_getConfig()
{
    $_config = Yaf_Registry::get('config');
    if (!$_config) {
        $_config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $_config);
    }
    return $_config;
}

function handleRequest($request, $key, $default = '')
{
    return isset($request[$key]) ? $request[$key] : $default;
}

/**
 * Ajax 返回JSON
 * @param  integer $return 0：失败， 1：成功
 * @param  string $message 提示信息
 * @param  array $data 返回的数据
 * @return JSON
 * */
function ajaxReturn($return = 0, $message = NULL, $data = NULL)
{
    $r_data['ret'] = $return;
    if ($message) {
        $r_data['msg'] = $message;
    }
    if ($data) {
        $r_data['data'] = $data;
    }

    exit(json_encode($r_data));
}
