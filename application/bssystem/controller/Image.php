<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-21
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use think\Controller;
use think\facade\Request;

class Image extends Controller {
    /**
     * 处理上传图片
     */
    function upload(){
        $file = Request::file('file');
        $info = $file->move('upload');
        if(!empty($info) && !empty($info->getPathName())){
            $this->result($info->getPathName(), 1, '成功');
        }else{
            $this->result('', 0, '失败');
        }

    }
}


