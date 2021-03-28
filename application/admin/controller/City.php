<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-24
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\BtCity;
use think\Controller;

class City extends Controller {
    function index(){
        $cityList = BtCity::paginate(5);
        $this->assign('cityList', $cityList);
        return $this->fetch('city');
    }
}

