<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-04-08
// |Description : 
// +-------------------------------------------------------------
namespace app\behavior;

use think\Controller;
use think\Db;
use think\facade\Config;

class DbStat extends Controller {
    //判断数据库连接状态
    function run(){
        try {
            Db::connect(Config::get('database'));
        }catch (\Exception $e){
            $this->error('数据库连接失败！' . $e->getMessage());
        }

    }
}

