<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-19
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use app\bssystem\model\BsBusiAccount;
use think\Controller;
use think\facade\Request;
use think\facade\Session;
use think\facade\Url;
use think\facade\Validate;

class Login extends Controller {

    /**
     * 登录
     * @return mixed
     */
    function login(){
        if(!Request::isPost()){
            $userData = Session::get('loginUser', 'bssystem');
            $this->assign('userData',$userData);
            return $this->fetch('login');
        }

        $postData = input('post.');
        $username = $postData['username'];
        $password = $postData['password'];

        //判断用户的存在性和激活性
        try {
            $userObj = BsBusiAccount::where('username', $username)->where('status','Y')->find();
        }catch (\Exception $e){
            $this->result([], -40, '数据库服务异常。');
            exit();
        }

        // halt($userObj);
        if(!empty($username) && empty($userObj)){
            $this->result([], -10, '用户不存在或未激活。');
        }
        //校验用户、密码登录
        if(!Validate::checkRule($username, 'require')){
            $this->result([], -20, '用户名不能为空。');
        }
        $pwdCode = $userObj->code;
        $pwd = $userObj->password;
        if(md5($password.$pwdCode)!=$pwd){
            $this->result([], -30, '密码错误。');
        }

        //保存登录用户信息
        Session::set('loginUser', $userObj, 'bssystem');

        //更新最后一次登录时间、客户端IP
        BsBusiAccount::update(['last_login_time'=>date('Y-m-d H:i:s',time()), 'last_login_ip'=>$_SERVER['REMOTE_ADDR']],['id'=>$userObj->id]);

        $this->result([], 1 ,'登录成功。');

    }

    /**
     * 退出系统
     */
    function logout(){
        //清除session
        Session::clear('bssystem');
        $this->redirect(Url::build('bssystem/Login/login'));
    }

}

