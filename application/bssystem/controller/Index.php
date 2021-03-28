<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-01
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use think\facade\Session;

class Index extends LoginRequire {
    /**
     * 登录成功后跳转商户中心首页
     * @return mixed
     */
    function index(){
        $userData = Session::get('loginUser', 'bssystem');
        // halt($userData);
        if (!empty($userData)){
            $this->assign('userData',$userData);
        }
        return $this->fetch('index');
    }
}

