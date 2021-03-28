<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-12
// |Description : 
// +-------------------------------------------------------------
namespace app\index\controller;

use app\index\model\BtUser;
use think\Controller;
use think\facade\Request;
use think\facade\Session;
use think\facade\Validate;

class User extends Controller {

    /**
     * o2o团购网用户登录
     */
    function login(){
        if (Request::isPost()){
            $username = input('post.userName', null);
            $password = input('post.password', null);
            $userObj = BtUser::where(['username'=>$username, 'status'=>'Y'])->find();
            if (empty($userObj)){
                $this->result(null, -1, '用户名不存在或未激活。');
            }
            $code = $userObj->code;
            $passwordOri = $userObj->password;
            $passwordMD5 = md5($password.$code);
            if ($passwordMD5!=$passwordOri){
                $this->result(null, -2, '密码错误。');
            }

            //记录登录IP和时间
            $userObj->save([
                'last_login_ip' => $_SERVER['REMOTE_ADDR'],
                'last_login_time' => date('Y-m-d H:i:s', time())
            ]);
            //记录session
            Session::set('o2oUser', [
                'username' => $username,
                'password' => $password,
                'last_login_time' => date('Y-m-d H:i:s', time()),
                'id' => $userObj->id
            ], 'o2o');
            $this->result(null, 1, '登录成功。');
        }

        return $this->fetch('login');
    }

    /**
     * o2o团购网用户退出
     */
    function logout(){
        Session::delete('o2oUser','o2o');
        // $this->redirect(Url::build('index/User/login'));
        $this->result(null, 1 , '退出系统');
    }

    /**
     * o2o团购网用户注册
     * @return mixed
     */
    function register(){
        if (Request::isPost()){
            $userName = input('post.userName', null);
            $email = input('post.email', null);
            $password1 = input('post.password1', null);
            $password2 = input('post.password2', null);
            $captcha = input('post.verifyCode', null);

            //判断用户名是否存在
            $usernameObj = BtUser::where('username',$userName)->find();
            if (!empty($usernameObj)){
                $this->result(null, -1, '用户名已注册，请更换。');
            }
            /*//判断邮箱是否已存在
            $emailObj = BtUser::where('email',$email)->find();
            if (!empty($emailObj)){
                $this->result(null, -2, '邮箱已占用，请更换。');
            }*/
            //判断两次密码是否一致
            if ($password1!=$password2){
                $this->result(null, -3, '两次输入的密码不一致。');
            }
            //验证邮箱格式
            if(!Validate::checkRule($email, 'require|email')){
                $this->result(null, -4, '邮箱格式非法。');
            }
            //验证验证码
            if (!captcha_check($captcha)){
                $this->result(null, -5, '验证码不正确。');
            }

            //密码加密
            //加盐
            $code = (string)mt_rand(1000, 9999);
            $password = md5($password1.$code);

            //插入数据
            $ret = BtUser::create([
                'username' => $userName,
                'code' => $code,
                'password' => $password,
                'email' => $email,
                'status' => 'Y',
            ]);
            if (!empty($ret)){
                $ret = sendEmail($email, 'o2o用户注册通知', '恭喜，注册成功。');  //发送邮件通知
                $this->result(null, 1, '注册成功。'.$ret);
            }

        }

        return $this->fetch('register');
    }
}

