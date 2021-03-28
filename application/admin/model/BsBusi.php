<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-23
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\model;

use app\bssystem\model\BsBusiLocation;
use think\facade\Config;
use think\Model;

class BsBusi extends Model {
    /**
     * 获取商户列表
     * @param string $status
     * @return BsBusi|\think\Paginator
     */
    function getBusiList($status=''){
        $order = ['listorder'=>'asc'];
        $cond = ['status'=>$status];
        $res = $this->order($order)->paginate();
        if($status!=''){
            $res = $this->where($cond)->order($order)->paginate();

        }
        return $res;
    }

    function hasBusiLocation(){
        return $this->hasMany(BsBusiLocation::class, 'busi_id', 'id')->where('status','Y');
    }
}

