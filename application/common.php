<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件（函数）

use PHPMailer\PHPMailer\PHPMailer;
use think\facade\Config;


/**
 * 门面类绑定
 */
\think\Facade::bind([
    app\facade\Alipay::class => app\common\Alipay::class,
]);

/// 门面别名
/*\think\Loader::addClassAlias([
    'Alipay' => app\facade\Alipay::class,
]);*/


/**
 * curl访问第三方网页数据
 * @param $url
 * @param string $method  http方法，默认GET
 * @param array $data  http post数据
 * @return bool|string
 */
function doCURL($url, $method='GET', $data=[]){
    //初始化
    $ch = curl_init();
    //设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //此设置作用：成功返回内容，失败返回false
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //POST方法处理
    if($method=='POST'){
        curl_setopt($ch, CURLOPT_PORT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //执行url
    $output = curl_exec($ch);   //成功返回内容，失败返回false
    //关闭句柄
    curl_close($ch);
    return $output;

}

/**
 * 发送邮件
 * @param string $addAddress 收件人
 * @param string $Subject 邮件标题
 * @param string $Body 邮件内容
 * @return string
 */
function sendEmail($addAddress, $Subject, $Body=''){
    $server = [
        'Host' => Config::get('email.Host'),                     //服务器
        'Port' => Config::get('email.Port'),                     //端口
        'Username' => Config::get('email.Username'),             //邮箱的用户名
        'Password' => Config::get('email.Password'),             //密码，部分邮箱是授权码(例如qq邮箱)
        'setFrom' => Config::get('email.setFrom'),               //发件人
        'addReplyTo' => Config::get('email.addReplyTo'),         //回复的时候回复给哪个邮箱 建议和发件人一致
        'addCC' => Config::get('email.addCC'),                   //抄送
        'addBCC' => Config::get('email.addBCC'),                 //密送
        'addAttachment' => Config::get('email.addAttachment'),   //添加附件
        'AltBody' => Config::get('email.AltBody'),               //如果邮件客户端不支持HTML则显示此内容
    ];
    $email = new PHPMailer(true);
    try {
        $email->isSMTP();               //使用SMTP协议
        $email->isHTML(true);           //是否以HTML文档格式发送
        $email->SMTPAuth = true;        //启用SMTP验证功能
        $email->SMTPSecure = "ssl";     //加密方式
        $email->CharSet ="UTF-8";       //设定邮件编码
        // $email->SMTPDebug = false;      //设置为 true 可以查看具体的发送日志

        //获取参数
        $email->Host = $server['Host'];
        $email->Port = $server['Port'];
        $email->Username = $server['Username'];
        $email->Password = $server['Password'];
        $email->setFrom($server['setFrom'][0],$server['setFrom'][1]);
        $email->addAddress((string)$addAddress, explode((string)$addAddress, '@')[0]);
        if(!empty($server['addReplyTo'])){ $email->addReplyTo($server['addReplyTo'][0],$server['addReplyTo'][1]); }
        if(!empty($server['addCC'])){ $email->addCC($server['addCC'][0],$server['addCC'][1]); }
        if(!empty($server['addBCC'])){ $email->addBCC($server['addBCC'][0],$server['addBCC'][1]); }
        if(!empty($server['addAttachment'])){ $email->addAttachment = $server['addAttachment']; }
        $email->Subject = $Subject;
        $email->Body = $Body;
        if(!empty($server['AltBody'])){ $email->AltBody = $server['AltBody']; }
        $res = $email->send();
        if ($res){
            return '1^邮件发送成功';
        }else{
            return '-1^邮件发送失败';
        }

    }catch (Exception $e){
        return '-1^邮件发送失败: '.$email->ErrorInfo;
    }

}

/**
 * 返回指定表字段的值
 * @param $id
 * @param $table
 * @param $field
 * @return mixed
 */
function shortDesc($id, $table, $field){
    return \think\Db::table($table)->where('id', $id)->value($field);
}


/**
 * ThinkPHP 获取当前页面完整的url
 * @return string
 */
function getUrl() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/**
 * 生成订单号
 * 当前时间 + 6位随机数
 * @return string
 */
function setOrderNo(){
    //返回当前时间
    $Sec = date('YmdHis');
    $mic = explode('.', microtime(true))[1];    //毫秒部分
    $micSec = $Sec.$mic;

    //获取6位随机数
    $rand = strval(mt_rand(0, 999999));
    if (mb_strlen($rand)<6){
        $rand = str_pad($rand, 6, '0', STR_PAD_LEFT);
    }

    return $micSec.$rand;
}





