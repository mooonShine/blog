<?php

/**
 * 分页类[模范百度分页]
 * Created by PhpStorm.
 * User: zb
 * Date: 14-6-6
 * Time: 上午9:17
 */
class Component_Page
{

    private $total = 0; //总记录数
    private $page = 1;  //第几页
    private $size = 10;  //每页多少条
    private $is_ajax = false; //是否ajax
    private $showCount = 10; //显示的条数

    /**
     * 初始化
     * @param $page  第几页
     * @param $total 共几条
     * @param $url   跳转的地址
     * @param int $size 每页条数
     * @pagam $is_ajax 是否ajax
     * @param $shocount 显示的页数
     */
    public function __construct( $page = 0, $total=0, $url='', $size = 10, $is_ajax = false,$showCount=10 )
    {
        if ($page == 0 || !is_numeric( $page ))
        {
            $page = 1;
        }
        $this->page = $page;
        $this->total = $total;
        $this->url = $url;
        $this->size = $size;
        $this->is_ajax = $is_ajax;
        $this->showCount = $showCount;
    }

    // public function display()
    // {
    //     $count = ceil( $this->total / $this->size );

    //     if($count<$this->size)
    //     {
    //         $this->size =$count;
    //     }

    //     $html = "";
    //     $tempurl = "";
    //     //处理url
    //     foreach ($_GET as $key => $value)
    //     {
    //         if ($key != "p" && $key != "_url")
    //         {
    //             $tempurl .= "&" . $key . '=' . $value;
    //         }
    //     }
    //     $tempurl = substr( $tempurl, 1, strlen( $tempurl ) );
    //     $this->url .= empty( $tempurl ) ? "?" : "?" . $tempurl . "&";

    //     $html .= '<div class="page" id="_page_content">';

    //     //显示上一页
    //     $html.=$this->previou_page();

    //     //页码
    //     if ($this->showCount >= $count)
    //     {
    //         $this->showCount = $count;
    //     }

    //     $nnum = (floor($this->showCount / 2));
    //     $nnum = $nnum < 0 ? 0 : $nnum;
    //     $pnum = $this->showCount - $nnum;
    //     $beginPage = $endPage = 0;

    //     $beginPage = $this->page - $pnum < 0 ? 0 :
    //         ($this->page + $nnum >= $count ? $count - $this->showCount : $this->page - $pnum);
    //     $endPage = $this->page + $nnum > $count ? $count :
    //         ($this->page + $nnum < $this->showCount ? $this->showCount : $this->page + $nnum);

    //     for ($i = $beginPage; $i < $endPage && $endPage != 1; $i++)
    //     {
    //         if ($i + 1 != $this->page)
    //         {
    //             if ($this->is_ajax)
    //             {
    //                 $html .= sprintf( '<a href="javascript:void(0);" spage="%d">%d</a>', ($i + 1 ), $i + 1 );
    //             } else
    //             {
    //                 $html .= sprintf( '<a href="%s">%s</a>', $this->url . 'p=' . ($i + 1), $i + 1 );
    //             }
    //         } else
    //         {
    //             $html .= sprintf( '<span class="s">%s</span>', $this->page );

    //         }
    //     }

    //     //显示下一页
    //     $html.= $this->next_page( $count );

    //     $html .= '</div>';

    //     return $html;
    // }

    public function display()
    {
        $count = ceil( $this->total / $this->size );

        if($count<$this->size)
        {
            $this->size =$count;
        }

        $html = "";
        $tempurl = "";
        //处理url
        foreach ($_GET as $key => $value)
        {
            if ($key != "p" && $key != "_url")
            {
                $tempurl .= "&" . $key . '=' . $value;
            }
        }

        $tempurl = substr( $tempurl, 1, strlen( $tempurl ) );
        $this->url .= empty( $tempurl ) ? "?" : "?" . $tempurl . "&";

        $html .= '<div class="text-right" id="_page_content"><ul class="pagination" style="margin:0px;">';

        //显示上一页
        $html.=$this->previou_page();

        //页码
        if ($this->showCount >= $count)
        {
            $this->showCount = $count;
        }

        $nnum = (floor($this->showCount / 2));
        $nnum = $nnum < 0 ? 0 : $nnum;
        $pnum = $this->showCount - $nnum;
        $beginPage = $endPage = 0;

        $beginPage = $this->page - $pnum < 0 ? 0 :
            ($this->page + $nnum >= $count ? $count - $this->showCount : $this->page - $pnum);
        $endPage = $this->page + $nnum > $count ? $count :
            ($this->page + $nnum < $this->showCount ? $this->showCount : $this->page + $nnum);

        for ($i = $beginPage; $i < $endPage && $endPage != 1; $i++)
        {
            if ($i + 1 != $this->page)
            {
                if ($this->is_ajax)
                {
                    $html .= sprintf( '<li><a href="javascript:void(0);" url="%s" spage="%d">%d</a></li>', $this->url,($i + 1 ), $i + 1 );
                } else
                {
                    $html .= sprintf( '<li><a href="%s">%s</a></li>', $this->url . 'p=' . ($i + 1), $i + 1 );
                }
            } else
            {
                $html .= sprintf( '<li class="active"><span class="s">%s</span></li>', $this->page );

            }
        }

        //显示下一页
        $html.= $this->next_page( $count );

        $html .= '</ul></div>';

        return $html;
    }

    //下一页
    private function next_page( $count )
    {
        $_h = '';
        if ($this->page < $count)
        {
            if ($this->is_ajax)
            { 
                $_h = sprintf( '<li><a href="javascript:void(0);" url="%s" spage="%d">→</a></li>',$this->url, $this->page + 1 );
            } else
            {
                $_h = sprintf( '<li><a href="%s">→</a></li>', $this->url . 'p=' . ($this->page + 1) );
            }
        }
        return $_h;
    }

    //上一页
    private function previou_page()
    {
        $_h = '';
        if ($this->page != 1)
        {
            if ($this->is_ajax)
            {
                $_h = sprintf( '<li><a href="javascript:void(0);" url="%s" spage="%d">←</a></li>',  $this->url ,$this->page - 1 );
            } else
            {
                $_h = sprintf( '<li><a href="%s">←</a></li>', $this->url . 'p=' . ($this->page - 1) );
            }
        }
        return $_h;
    }

}