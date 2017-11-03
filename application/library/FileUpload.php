<?php

/*
 *	文件上传类
 *
 * eg:
 * $f = new FileUpload("name") //文件上传表单控件名称
 * $result = $f->run() //如果是数组代表有错误。不是成功
 */

class FileUpload
{
    private $max_size = 100000000;
    private $ext_arr = array();
    private $save_path = '';
    private $save_url = '';
    private $name = '';

    private function _init()
    {
        $this->ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'swf', 'flv', 'xls', 'pdf', 'xlsx'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        $this->save_path = BASE_PATH . DIRECTORY_SEPARATOR;
        $this->save_url = '/uploads/';
        $this->save_path = realpath($this->save_path) . '/public/uploads' . DIRECTORY_SEPARATOR;

        if (!file_exists($this->save_path)) {
            mkdir($this->save_path, 0777, true);
        }
    }

    public function __construct($name)
    {
        $this->_init();
        $this->name = $name;
    }

    public function alert($msg)
    {
        return array($msg);
    }

    private function _checkImageFileMime($tmp_name)
    {
        $imageMimes = array("image/jpeg", "image/gif", "image/png",
            "application/x-shockwave-flash", "application/pdf", "application/excel");
        $fileInfo = getimagesize($tmp_name);
        $width = $fileInfo[0]; //宽
        $height = $fileInfo[1]; //高

        if (!empty($_POST['width']) && !empty($_POST['height'])) {
            if ($width != intval($_POST['width']) && $height != intval($_POST['height'])) {
                return $this->alert("请上传符合尺寸的图片或flash");
            }
        }

        if ($fileInfo['mime'] && !in_array($fileInfo['mime'], $imageMimes)) {
            return $this->alert("上传的图片文件类型有问题");
        }

        return '';
    }

    public function run()
    {
        //PHP上传失败
        if (!empty($_FILES[$this->name]['error'])) {
            switch ($_FILES[$this->name]['error']) {
                case '1':
                    $error = '超过允许的大小';
                    break;
                case '2':
                    $error = '超过表单允许的大小';
                    break;
                case '3':
                    $error = '图片只有部分被上传';
                    break;
                case '4':
                    $error = '请选择图片';
                    break;
                case '6':
                    $error = '找不到临时目录';
                    break;
                case '7':
                    $error = '写文件到硬盘出错';
                    break;
                case '8':
                    $error = '缺少扩展，上传失败';
                    break;
                case '999':
                default:
                    $error = '未知错误';
            }
            return $this->alert($error);
        }
        // 上传图片检验
        $result = $this->_checkImageFileMime($_FILES[$this->name]['tmp_name']);
        if ($result != '') {
            return $result;
        }

        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $file_name = $_FILES[$this->name]['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES[$this->name]['tmp_name'];
            //文件大小
            $file_size = $_FILES[$this->name]['size'];
            //检查文件名
            if (!$file_name) {
                return $this->alert("请选择文件");
            }
            //检查目录
            if (@is_dir($this->save_path) === false) {
                return $this->alert("上传目录不存在");
            }
            //检查目录写权限
            if (@is_writable($this->save_path) === false) {
                return $this->alert("上传目录没有写权限");
            }
            //检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                return $this->alert("上传失败");
            }
            //检查文件大小
            if ($file_size > $this->max_size) {
                return $this->alert("上传文件大小超过限制");
            }
            //检查目录名
            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
            if (empty($this->ext_arr[$dir_name])) {
                return $this->alert("目录名不正确");
            }
            //获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            //检查扩展名
            if (in_array($file_ext, $this->ext_arr[$dir_name]) === false) {
                return $this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $this->ext_arr[$dir_name]) . "格式");
            }
            //创建文件夹
            if ($dir_name !== '') {
                $this->save_path .= $dir_name . DIRECTORY_SEPARATOR;
                $this->save_url .= $dir_name . '/';
                if (!file_exists($this->save_path)) {
                    mkdir($this->save_path);
                }
            }
            $ymd = date("Y") . "/" . date('m');
            $this->save_path .= $ymd . DIRECTORY_SEPARATOR;
            $this->save_url .= $ymd . '/';
//		if (!file_exists($this->save_path)) {
//			mkdir($this->save_path);
//		}

            if (!is_dir($this->save_path)) {
                mkdir($this->save_path, 0777, true);
            }

            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //移动文件
            $file_path = $this->save_path . $new_file_name;

            if (move_uploaded_file($tmp_name, $file_path) === false) {
                return $this->alert("上传文件失败");
            }
            @chmod($file_path, 0644);

            $file_url = $this->save_url . $new_file_name;
            return ($file_url);
        }
    }
}
