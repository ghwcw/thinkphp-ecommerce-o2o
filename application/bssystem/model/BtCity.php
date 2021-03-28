<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-19
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\model;

use think\Model;

class BtCity extends Model {
    /**
     * 获取省级或所属城市
     * $parent_id为0是省级
     */
    function getProvincOrCity($parentId=0){
        $cond = [
            'parent_id' => $parentId,
            'status' => 'Y',
        ];
        $order = [
            'listorder' => 'asc'
        ];
        $prov_or_city = $this->where($cond)->order($order)->select();
        return $prov_or_city;
    }


}

