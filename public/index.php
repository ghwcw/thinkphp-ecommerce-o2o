<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

//检查数据库服务
use PDO;
use PDOException;

$dbconfig = include('../config/database.php');
$type = $dbconfig['type'];
$hostname = $dbconfig['hostname'];
$database = $dbconfig['database'];
$username = $dbconfig['username'];
$password = $dbconfig['password'];
try {
    $db = new PDO("$type:host=$hostname;dbname=$database", $username, $password);
}catch (PDOException $e){
    header('content-type:text/html; charset=utf-8');
    exit('<h1 style="text-align:center; margin-top:300px">〒▽〒 数据库连接失败！请检查数据库服务是否正常。</h1>');
}

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象
\think\facade\View::share('val',5);     //模板中引用

// 执行应用并响应
Container::get('app')->run()->send();
