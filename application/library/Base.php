<?php

/**
 * @author zhanghuang 2016-12-2
 */
class Base extends Admin
{
    protected $login_url = 'http://login.juhuisuan.com/interface/';

    public function init()
    {
        parent::init();
        // $this->checkAuth();

    }

    private function checkAuth()
    {
        $auth = $this->getAuth();
        $own_authority = false;
        foreach ($auth as $k => $v) {
            if ($k == strtolower($this->_c)) {
                if (in_array(strtolower($this->_a), $v)) {
                    $own_authority = true;
                }
            }
        }

        if ($own_authority !== true) {
            echo "无权限";
            exit;
        }
    }

    /**
     * 获取权限
     */
    private function getAuth()
    {

        $permi_id = $_SESSION['PERMI_ID'];

        if ($permi_id == 1) {
            $auth = array(
                'index' => array('index'),
                'sales' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
                'cost' => array('index', 'addcost', 'upload', 'validationuser', 'datainfo'),
                'admin' => array('index', 'adduser', 'validationuser'),
                'user' => array('index', 'adduser', 'validationuser'),
                'log' => array('index'),
            );
        } else if ($permi_id == 2) {
            $auth = array(
                'index' => array('index'),
                'sales' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        } else if ($permi_id == 3) {
            $auth = array(
                'index' => array('index'),
                'sales' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
                'cost' => array('index', 'addcost', 'upload', 'validationuser', 'datainfo'),
                'user' => array('index', 'adduser', 'validationuser'),
            );
        } else if ($permi_id == 4) {
            $auth = array(
                'index' => array('index'),
                'sales' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        } else if ($permi_id == 5) {
            $auth = array(
                'index' => array('index'),
                'site' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        } else if ($permi_id == 6) {
            $auth = array(
                'index' => array('index'),
                'agent' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        } else if ($permi_id == 7) {
            $auth = array(
                'index' => array('index'),
                'google' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        } else if ($permi_id == 8) {
            $auth = array(
                'index' => array('index'),
                'data' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        } else if ($permi_id == 9) {
            $auth = array(
                'index' => array('index'),
                'cost' => array('index', 'addincome', 'upload', 'validationuser', 'datainfo', 'del', 'updatestatus'),
            );
        }
        return $auth;
    }


    /**
     * 调用接口通用方法
     */
    public function callInterface($url, $data, $type = 'post')
    {
        $result = json_decode(fn_get_contents($url, $data, $type), true);
        if (isset($result['ret']) && $result['ret'] == "0") {
            if (isset($result['data']) && !empty($result['data'])) {
                return $result['data'];
            } else {
                return null;
            }
        } else {
            return false;
        }
    }

    /**
     * 导出通用方法
     * @head   头
     * @data 数据
     * @author zh <zhanghuang@pv25.com>
     * @since 2016-08-25
     */
    public function crateHtmlExport($head, $data)
    {
        echo <<<EOT
<html xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns="http://www.w3.org/TR/REC-html40">
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html>
     <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
         <style id="Classeur1_16681_Styles"></style>
     </head>
     <body>
         <div id="Classeur1_16681" align=center x:publishsource="Excel">
             <table x:str border=0 cellpadding=0 cellspacing=0 width=100% style="border-collapse: collapse">
EOT;
        echo '<tr>';
        foreach ($head as $value) {
            echo '<td class=xl2216681 nowrap>' . $value . '</td>';
        }
        echo '</tr>';

        foreach ($data as $value) {
            echo '<tr>';
            foreach ($value as $value2) {
                echo '<td class=xl2216681 nowrap>' . $value2 . '</td>';
            }
            echo '</tr>';
        }

        echo <<<EOT
             </table>
         </div>
     </body>
 </html>
EOT;
    }

    /**
     * @param $data content数据
     * @param int $status 内容格式：0默认,1对账单,2后台用户,3前台用户
     * @return string
     * @Author: zhanghuang@pv25.com
     * @Since:2016-12-15
     * @Info:日志内容拼接
     */
    public function contentItem($data = array(), $status = 0)
    {
        if (empty($data)) return '';
        isset($data['username']) ? $data['username'] : $data['username'] = '未知用户';
        switch ($status) {
            case 1:
                $content = getAuthName($_SESSION['PERMI_ID']) . ',修改对账单状态为[' . $data['status'] . '],用户名:' . $data['username'] . ',所属部门:' . $data['depart'] . ',id=' . $data['id'];
                break;
            case 2:
                $content = getAuthName($_SESSION['PERMI_ID']) . '后台用户,用户名:' . $data['username'] . ',所属权限组:' . getAuthName($data['permi_id']);
                break;
            case 3:
                $content = getAuthName($_SESSION['PERMI_ID']) . '添加用户,用户名:' . $data['username'] . ',所属部门:' . getDepartName($data['depart_id']);
                break;
            default:
                $content = getAuthName($_SESSION['PERMI_ID']) . ',' . $data['username'] . ',';
                $content .= isset($data['b_money']) ? ',期初:' . $data['b_money'] : '';
                $content .= isset($data['m_consume']) ? ',本月消耗:' . $data['m_consume'] : '';
                $content .= isset($data['m_payment']) ? ',本月收款:' . $data['m_payment'] : '';
                $content .= isset($data['total_payment']) ? ',累计收款:' . $data['total_payment'] : '';
                $content .= isset($data['total_consume']) ? ',累计消耗:' . $data['total_consume'] : '';
                $content .= isset($data['refund']) ? ',退款:' . $data['refund'] : '';
                $content .= isset($data['balance']) ? ',余额:' . $data['balance'] : '';
                $content .= isset($data['id']) ? '.id:' . $data['id'] : '';
                break;
        }
        return $content;
    }


    /**
     * 年份
     * */
    public function getYears()
    {

        $years = array();
        for ($i = 1; $i < 20; $i++) {
            $years[$i] = 2014 + $i;
        }
        return $years;
    }

    /**
     * 账号当前年月
     * */
    public function getAccountM($years, $month)
    {
        $permi_id = $this->_session->get('PERMI_ID');
        $date = array();
        if ($permi_id < 3) {
            $date['years'] = $years;
            $date['month'] = $month;
        } else {
            $years = date('Y', time());
            $month = date('m', time());
            if ($month == 1) {
                $date['years'] = $years - 1;
                $date['month'] = 12;
            } else {
                $date['years'] = $years;
                $date['month'] = $month - 1;
            }
        }
        return $date;
    }

    /**
     * 删除相对路径图片
     * */
    public function delPic($pic, $Newpic = '')
    {
        $Newpic = $Newpic ? json_decode($Newpic, true) : '';
        $pic = json_decode($pic, true);
        if ($pic) {
            foreach ($pic as $key => $val) {
                if ($Newpic) {
                    $status = in_array($val, $Newpic);
                    if (!$status) @unlink(BASE_PATH . '/public' . $val);
                } else {
                    @unlink(BASE_PATH . '/public' . $val);
                }
            }
        }
    }

    /**
     * 图片地址处理成josn
     * */

    public function picAddrs($picData, $EXTENSION = false)
    {
        if ($EXTENSION) {
            if (!$picData) return '';
            $picData = json_decode($picData);
            $fileName = array();
            foreach ($picData as $k => $v) {
                $fileName[$k]['pic'] = $v;
                $fileName[$k]['fileName'] = basename($v);
            }
            return $fileName;
        } else {
            if (!$picData) return '';
            $picData = str_replace(array('[', ']'), '', $picData);
            $picData = explode(',', $picData);
            if (!$picData[0]) return '';
            return json_encode($picData);
        }
    }

    /**
     *　根据权限,显示部门标签
     * @return array
     */
    public function getNav($permi_id)
    {
        if ($permi_id) {
            $navs = array();
            if ($permi_id < PERMI_SALES) {
                $navs = array(
                    1 => array('name' => '销售部', 'url' => '/sales/index'),
                    2 => array('name' => '站内', 'url' => '/site/index'),
                    3 => array('name' => '代理', 'url' => '/agent/index'),
                    4 => array('name' => '谷歌项目', 'url' => '/google/index'),
                    5 => array('name' => '数据定制', 'url' => '/data/index'),
                );
            } elseif ($permi_id == PERMI_SALES) {
                $navs = array(1 => array('name' => '销售部', 'url' => '/sales/index'));
            } elseif ($permi_id == PERMI_SITE) {
                $navs = array(2 => array('name' => '站内', 'url' => '/site/index'));
            } elseif ($permi_id == PERMI_AGENT) {
                $navs = array(3 => array('name' => '代理', 'url' => '/agent/index'));
            } elseif ($permi_id == PERMI_GOOGLE) {
                $navs = array(4 => array('name' => '谷歌项目', 'url' => '/google/index'));
            } elseif ($permi_id == PERMI_DATA) {
                $navs = array(5 => array('name' => '数据定制', 'url' => '/data/index'));
            } elseif ($permi_id == PERMI_COST) {
                $navs = array(5 => array('name' => '渠道部', 'url' => '/cost/index'));
            }
            return $navs;
        }
        return array();
    }


    /**
     *　根据权限,显示列表数据
     * @return array
     */
    public function getNavAndcontent($res, $userArry, $permi_id, $depart_id = 1)
    {
        $data = array();
        if ($permi_id < PERMI_SALES) {
            if ($depart_id == DEPART_SALES) {
                $navs = array('客户名', '期初余额', '本月消耗', '本月返点', '本月截图', '本月收款', '累计收款', '累计消耗', '退款', '余额', '对账单');
            } elseif ($depart_id == DEPART_SITE) {
                $navs = array('客户名', '期初余额', '本月充值', '本月截图', '本月消耗', '累计充值', '累计消耗', '退款', '余额', '对账单');
            } elseif ($depart_id == DEPART_COST) {
                $navs = array('客户名', '期初余额', '本月消耗', '本月截图', '累计消耗', '累计付款', '付款', '退款', '余额');
            } elseif ($depart_id == DEPART_GOOGLE) {
                $navs = array('客户名', '期初余额', '本月应收', '本月截图', '本月收款(¥)', '本月收款($)', '累计应收', '累计收款(¥)', '累计收款($)', '退款', '余额', '对账单');
            } else {
                $navs = array('客户名', '期初余额', '本月应收', '本月截图', '本月收款', '累计应收', '累计收款', '退款', '余额', '对账单');
            }

            if (!empty($res)) {
                foreach ($res as $k => $v) {
                    $currency = '';
                    if ($depart_id == DEPART_GOOGLE) {
                        if ($v['type']) {
                            $currency = '($)';
                        } else {
                            $currency = '(¥)';
                        }
                    }
                    $data[$k]['id'] = $v['id'];
                    if (count($userArry)) {
                        for ($i = 0; $i < count($userArry); $i++) {
                            if ($userArry[$i]['id'] == $v['user_id']) {
                                $data[$k]['username'] = $userArry[$i]['username'];
                            }
                        }
                    }
                    if (!isset($data[$k]['username'])) {
                        $info['uid'] = $v['user_id'];
                        $info['fields'] = 'username';
                        $info['type'] = 'getUserInfo';
                        $res = fn_get_contents($this->login_url . 'jhs', $info, 'post');
                        $eval_info = json_decode($res, true);
                        $data[$k]['username'] = $eval_info['ret'] == 0 ? $eval_info['data']['username'] : '未知用户';
                    }
                    $data[$k]['username'] = isset($data[$k]['username']) && $data[$k]['username'] ? $data[$k]['username'] : '未知用户';
                    $data[$k]['b_money'] = $currency . $v['b_money'];
                    if ($depart_id == DEPART_SALES || $depart_id == DEPART_COST) {
                        $data[$k]['m_consume'] = $v['m_consume'];
                    } else {
                        $data[$k]['m_payment'] = $currency . $v['m_payment'];
                    }
                    if ($depart_id == DEPART_SALES) {
                        $data[$k]['rebates'] = $v['rebates'];
                    }
                    $data[$k]['m_pic'] = $v['m_pic'];
                    if ($depart_id == DEPART_COST) {
                        $data[$k]['total_consume'] = $v['total_consume'];
                        $data[$k]['total_payment'] = $v['total_payment'];
                        $data[$k]['m_payment'] = $v['m_payment'];
                    } elseif ($depart_id == DEPART_SALES) {
                        $data[$k]['m_payment'] = $v['m_payment'];
                        $data[$k]['total_payment'] = $v['total_payment'];
                        $data[$k]['total_consume'] = $v['total_consume'];
                    } elseif ($depart_id == DEPART_GOOGLE) {
                        $data[$k]['m_consume'] = $v['m_consume'];
                        $data[$k]['dollar_m_consume'] = $v['dollar_m_consume'];
                        $data[$k]['total_payment'] = $currency . $v['total_payment'];
                        $data[$k]['total_consume'] = $v['total_consume'];
                        $data[$k]['dollar_total_consume'] = $v['dollar_total_consume'];
                    } else {
                        $data[$k]['m_consume'] = $v['m_consume'];
                        $data[$k]['total_payment'] = $v['total_payment'];
                        $data[$k]['total_consume'] = $v['total_consume'];
                    }
                    $data[$k]['refund'] = $currency . $v['refund'];
                    if ($depart_id == DEPART_GOOGLE) {
                        if ($v['type']) {
                            $data[$k]['balance'] = '($)' . $v['balance'];
                        } else {
                            $data[$k]['balance'] = '(¥)' . $v['balance'];
                        }
                    } else {
                        $data[$k]['balance'] = $v['balance'];
                    }
                    if (isset($v['status'])) $data[$k]['status'] = $v['status'];
                }
            }
        } else {
            if ($permi_id == PERMI_SALES) {
                $navs = array('客户名', '本月消耗', '本月返点', '本月截图', '退款');
            } else if ($permi_id == PERMI_SITE) {
                $navs = array('客户名', '本月消耗', '本月截图', '退款');
            } else if ($permi_id == PERMI_COST) {
                $navs = array('客户名', '本月消耗', '本月截图', '退款');
            } else {
                $navs = array('客户名', '本月应收', '本月截图', '退款');
            }
            if (!empty($res)) {
                foreach ($res as $k => $v) {
                    $currency = '';
                    if ($depart_id == DEPART_GOOGLE) {
                        if ($v['type']) {
                            $currency = '($)';
                        } else {
                            $currency = '(¥)';
                        }
                    }
                    $data[$k]['id'] = $v['id'];
                    if (count($userArry)) {
                        for ($i = 0; $i < count($userArry); $i++) {
                            if ($userArry[$i]['id'] == $v['user_id']) {
                                $data[$k]['username'] = $userArry[$i]['username'];
                            }
                        }
                    }
                    if (!isset($data[$k]['username'])) {
                        $info['uid'] = $v['user_id'];
                        $info['fields'] = 'username';
                        $info['type'] = 'getUserInfo';
                        $res = fn_get_contents($this->login_url . 'jhs', $info, 'post');
                        $eval_info = json_decode($res, true);
                        $data[$k]['username'] = $eval_info['ret'] == 0 ? $eval_info['data']['username'] : '未知用户';
                    }
                    $data[$k]['username'] = isset($data[$k]['username']) ? $data[$k]['username'] : '未知用户';
                    if ($depart_id == DEPART_SALES || $depart_id == DEPART_COST || $depart_id == DEPART_SITE) {
                        $data[$k]['m_consume'] = $v['m_consume'];
                    } else {
                        $data[$k]['m_payment'] = $currency . $v['m_payment'];
                    }
                    if ($depart_id == DEPART_SALES) {
                        $data[$k]['rebates'] = $v['rebates'];
                    }
                    $data[$k]['m_pic'] = $v['m_pic'];
                    $data[$k]['refund'] = $currency . $v['refund'];
                }
            }
        }
        $NavAndData = array('navs' => $navs, 'data' => $data);
        return $NavAndData;
    }

    /**
     * 显示权限判断
     * @variable $permi_id  账号所属权限组ID
     * @return array
     * */
    public function getPermissions($permi_id)
    {
        $fc = new FileCache();
        $isopen = $fc->get("canedit");
        $permissions = array();

        //判断是否大账号
        if ($permi_id == PERMI_ADMIN) {
            $permissions['adminAccount'] = true;
        } else {
            $permissions['adminAccount'] = false;
        }

        //添加按钮权限判断
        //大账号  或者 （时间超过25号且超过10号且不等于财务）
        //当前权限组ID可拥有
        if ($isopen == "ok" || $permi_id == PERMI_ADMIN ||
            ($isopen == "ok" && $permi_id != PERMI_FINANCIAL_LOOK &&
                $permi_id != PERMI_FINANCIAL)
        ) {
            $permissions['addButton'] = true;
        } else {
            $permissions['addButton'] = false;
        }
        //年份选择权限 只限大账号 财务（看） 财务
        if ($isopen == "ok" || $permi_id < PERMI_SALES) {
            $permissions['lookYear'] = true;
        } else {
            $permissions['lookYear'] = false;
        }

        //时间选择权限 只限大账号 财务（看） 财务
        if ($isopen == "ok" || $permi_id < PERMI_SALES) {
            $permissions['timeChoose'] = true;
        } else {
            $permissions['timeChoose'] = false;
        }
        //添加退款权限判断 已排除部门账号组 只限财务或大账号
        if ($isopen == "ok" || $permi_id != PERMI_FINANCIAL && $permi_id != PERMI_FINANCIAL_LOOK) {
            $permissions['addFieldRefund'] = true;
        } else {
            $permissions['addFieldRefund'] = false;
        }
        //添加付款权限判断  除财务和财务（看）
        if ($isopen == "ok" || $permi_id == PERMI_FINANCIAL || $permi_id == PERMI_ADMIN) {
            $permissions['addFieldPayment'] = true;
        } else {
            $permissions['addFieldPayment'] = false;
        }
        //编辑对账单 已排除部门账号组 只有大账号和财务
        if ($isopen == "ok" || $permi_id != PERMI_FINANCIAL_LOOK) {
            $permissions['editorStatus'] = true;
        } else {
            $permissions['editorStatus'] = false;
        }
        //编辑权限判断
        //大账号  或者 （时间超过25号且超过10号且不等于财务）
        //当前权限组ID可拥有
        if ($isopen == "ok" || $permi_id == PERMI_ADMIN ||
            ($isopen == "ok" && $permi_id != PERMI_FINANCIAL_LOOK)
        ) {
            $permissions['editor'] = true;

        } else {
            $permissions['editor'] = false;
        }
        $permissions['permi_id'] = $permi_id;
        return $permissions;
    }


    /**
     *获取累计数据的ID
     * @parameter   $list          部门当月所有数据
     * @parameter   $totalPayment  查询条件  1<50W  2>=50W
     * @return      array()
     * */
    public function getTotalId($list, $totalPayment)
    {
        $listId = array();
        if ($list) {
            foreach ($list as $key => $value) {
                if ($totalPayment == 1) {
                    if ($value['total_payment'] < 500000) {
                        $listId[] = $value['id'];
                    }
                } elseif ($totalPayment == 2) {
                    if ($value['total_payment'] >= 500000) {
                        $listId[] = $value['id'];
                    }
                }
            }
        }
        if ($listId) return $listId;
        return -1;
    }


    /**
     * 权限,一段时间你允许增删改
     */
//    public function AllowOperation() {
//        $day = date('d');
//        if( $day >= 10 && $day <= 25 ) {
//            $AllowOperation = 1;
//        } else {
//            $AllowOperation = 2;
//        }
//        return $AllowOperation;
//    }

    /*
     * 计算金钱数据
     */
    public function calcDataAction()
    {
        $month = $this->_request->getQuery("month");
        $year = $this->_request->getQuery("year");
        $table = $this->_request->getQuery("table");
        if (!$month || !$table) {
            fn_json_return(1, "参数不全", null);
        }

        $cm = new Model_Crontab();
        $cm->calculateMoneyData($year, $month, $table);
        fn_json_return(0, "", null);
    }
}
