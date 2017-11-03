<?php

/**
 * $page_size=20;
 * 总条目数
 * $nums=1024;
 * 每次显示的页数
 * $sub_pages=10;
 * 得到当前是第几页
 * $pageCurrent=9;
 * $subPages=new SubPages($page_size,$nums,$pageCurrent,$sub_pages,"test.php?p=");
 * */
class Component_SubPages {

    private $each_disNums; //每页显示的条目数
    private $nums; //总条目数
    private $current_page; //当前被选中的页
    private $sub_pages; //每次显示的页数
    private $pageNums; //总页数
    private $page_array = array(); //用来构造分页的数组
    private $subPage_link; //每个分页的链接
    private $subPage_type; //显示分页的类型
    private $is_ajax = false; //是否ajax
    private $subPageCssStr = NULL;

    /*
      __construct是SubPages的构造函数，用来在创建类的时候自动运行.
      @$each_disNums 每页显示的条目数
      @nums 总条目数
      @current_num 当前被选中的页
      @sub_pages 每次显示的页数
      @subPage_link 每个分页的链接
      @subPage_type 显示分页的类型
     */

    public function getSubPageCssStr() {
        return $this->subPageCssStr;
    }

    function __construct($each_disNums, $nums, $current_page, $sub_pages, $subPage_link,$subPage_type, $is_ajax = false) {
        $this->each_disNums = intval($each_disNums);
        $this->nums = intval($nums);
        if (!$current_page) {
            $this->current_page = 1;
        } else {
            $this->current_page = intval($current_page);
        }
        $this->sub_pages = intval($sub_pages);
        $this->pageNums = ceil($nums / $each_disNums);
        //处理查询参数
        $this->subPage_link = explode('?', $subPage_link);

        if(count($this->subPage_link)>2){
            $this->subPage_link = $this->subPage_link[0] . '?'.$this->subPage_link[1].'&';
        }else{
            $this->subPage_link = $this->subPage_link[0] . '?';
        }


        $this->is_ajax = $is_ajax; //是否是ajax
        foreach ($_GET as $key => $value) {
            if ($key == '_url') {
                continue;
            }
            if ($key != 'page') {
                $this->subPage_link.=$key . '=' . $value . '&';
            }
        }
        $this->subPage_link.='page=';

        /*
        if ($this->is_ajax) {
            $tempurl = "";
            //处理url
            foreach ($_GET as $key => $value) {
                if ($key != "page" && $key != "_url") {
                    $tempurl .= "&" . $key . '=' . $value;
                }
            }

            $tempurl = substr($tempurl, 1, strlen($tempurl));
            $this->subPage_link = $subPage_link;
            $this->subPage_link .= empty($tempurl) ? "?" : "?" . $tempurl . "&";
            $this->subPage_link .='page=';
            //echo $this->subPage_link;die;
        }
        */


        $this->show_SubPages();
    }

    /*
      __destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。
     */

    function __destruct() {
        unset($each_disNums);
        unset($nums);
        unset($current_page);
        unset($sub_pages);
        unset($pageNums);
        unset($page_array);
        unset($subPage_link);
        unset($subPage_type);
    }

    /*
      show_SubPages函数用在构造函数里面。而且用来判断显示什么样子的分页
     */

    function show_SubPages() {
        $this->subPageCss();
    }

    /*
      用来给建立分页的数组初始化的函数。
     */

    function initArray() {
        for ($i = 0; $i < $this->sub_pages; $i++) {
            $this->page_array[$i] = $i;
        }
        return $this->page_array;
    }

    /*
      construct_num_Page该函数使用来构造显示的条目
      即使：[1][2][3][4][5][6][7][8][9][10]
     */

    function construct_num_Page() {
        if ($this->pageNums < $this->sub_pages) {
            $current_array = array();
            for ($i = 0; $i < $this->pageNums; $i++) {
                $current_array[$i] = $i + 1;
            }
        } else {
            $current_array = $this->initArray();
            if ($this->current_page <= 3) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $i + 1;
                }
            } elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = ($this->pageNums) - ($this->sub_pages) + 1 + $i;
                }
            } else {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $this->current_page - 2 + $i;
                }
            }
        }

        return $current_array;
    }

    function subPageCss() {
        $subPageCssStr = "";

        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            //$subPageCssStr.="<ul> <li style='list-style-type:none;'> <a href='$firstPageUrl'>首页</a> </li>";
            $subPageCssStr .= "<ul>";
            $subPageCssStr .= "<li style='list-style-type:none;'> ";
            if ($this->is_ajax) {
                $subPageCssStr .= "<a href='javascript:void(0);' url='$firstPageUrl' spage='1' >首页</a>";
            } else {
                $subPageCssStr .= "<a href='$firstPageUrl'>首页</a>";
            }
            $subPageCssStr .= "</li>";

            //$subPageCssStr.="<li style='list-style-type:none;'> <a href='$prewPageUrl'>«</a> </li>";
            $subPageCssStr.="<li style='list-style-type:none;'>";
            if($this->is_ajax) {
                $subPageCssStr .= "<a href='javascript:void(0);' url='".$prewPageUrl."' spage='".($this->current_page - 1)."' >«</a>";
            } else {
                $subPageCssStr .= "<a href='$prewPageUrl'>«</a>";
            }
            $subPageCssStr .= "</li>";
            
        } else {
            $subPageCssStr.="<ul> <li class='disabled' style='list-style-type:none;'> <a> 首页</a></li>";
            $subPageCssStr.="<li class='disabled' style='list-style-type:none;'> <a>«</a></li>";
        }

        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $subPageCssStr.="<li class='disabled' style='list-style-type:none;'>" . "<a>" . "$s" . "</a> </li>";
            } else {
                $url = $this->subPage_link . $s;
                //$subPageCssStr.="<li style='list-style-type:none;'> <a href='$url'>" . $s . "</a> </li>";
                $subPageCssStr .= "<li style='list-style-type:none;'>";
                if($this->is_ajax){
                    $subPageCssStr.= " <a href='javascript:void(0);' url='$url' spage='$s'>" . $s . "</a> ";
                }else{
                    $subPageCssStr .= "<a href='$url'>" . $s . "</a> ";
                }
                $subPageCssStr .= "</li>";
            }
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            //$subPageCssStr.="<li style='list-style-type:none;'> <a href='$nextPageUrl'>»</a> </li> ";
            $subPageCssStr .= "<li style='list-style-type:none;'>";
            if($this->is_ajax){
                $subPageCssStr .= " <a javascript:void(0); url='$nextPageUrl' spage='".($this->current_page + 1)."' >»</a> ";
            }else{
                $subPageCssStr .= " <a href='$nextPageUrl'>»</a> ";
            }
            $subPageCssStr .= "</li>";
            //$subPageCssStr.="<li style='list-style-type:none;'> <a href='$lastPageUrl'>尾页</a> </li> </ul>";
            $subPageCssStr .= "<li style='list-style-type:none;'>";
            if($this->is_ajax){
                $subPageCssStr .= " <a javascript:void(0); url='$lastPageUrl' spage='".$this->pageNums."'>尾页</a> ";
            }else{
                $subPageCssStr .= " <a href='$lastPageUrl'>尾页</a> ";
            }
            $subPageCssStr .= "</li>";
            $subPageCssStr .= "</ul>";
        } else {
            $subPageCssStr.="<li class='disabled' style='list-style-type:none;'> <a>»</a></li>";
            $subPageCssStr.="<li class='disabled' style='list-style-type:none;'> <a>尾页</a> </li> </ul>";
        }
        $this->subPageCssStr = $subPageCssStr;
        return $subPageCssStr;
    }

}
