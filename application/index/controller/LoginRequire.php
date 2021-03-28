<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-01
// |Description : 
// +-------------------------------------------------------------
namespace app\index\controller;

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
            $this->error('您还未登录系统，请先登录！');     //Url::build('index/User/login')
        }
    }

    private function isLogin() {
        $userObj = Session::get('o2oUser', 'o2o');
        if($userObj && !empty($userObj['id'])){
            return true;
        }
        return false;
    }

    //返回登录账户信息
    function getLoginUser(){
        return Session::get('o2oUser', 'o2o');
    }


}

