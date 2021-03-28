<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-01
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use think\Controller;
use think\facade\Session;
use think\facade\Url;

/**
 * 需要登录
 */
class LoginRequire extends Controller {
    function initialize(){
        // 判断用户是否已登录，如果未登录则跳转到登录页
        $isLogin = $this->isLogin();
        if(!$isLogin){
            $this->redirect(Url::build('bssystem/Login/login'));
        }
    }

    private function isLogin() {
        $userObj = Session::get('loginUser', 'bssystem');
        if($userObj && $userObj->id){
            return true;
        }
        return false;
    }

    //返回登录账户信息
    function getLoginUser(){
        return Session::get('loginUser', 'bssystem');
    }


}

