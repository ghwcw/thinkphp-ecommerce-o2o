<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-21
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\validate;

use think\Validate;

class BsAppVali extends Validate {
    //规则
    protected $rule = [
        'name|名称' => 'require',
        'city_id|所属城市' => 'require',
        'email|邮箱' => 'require|email',
        'category_id|所属分类' => 'require',
        'address|地址' => 'require',
        'open_time' => 'date',
        'username|用户名' => 'require',
        'password|密码' => 'require',
    ];

    //场景
    protected function sceneUpdate(){
        return $this->remove(['username','password'],'require');
    }

    //添加分店
    protected function sceneSubLoc(){
        return $this->only(['name']);
    }

}