<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-21
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\model;

use app\admin\model\BsBusi;
use think\Model;

class BsBusiAccount extends Model {
    function toBsBusi(){
        return $this->belongsTo(BsBusi::class, 'busi_id', 'id');
    }
}

