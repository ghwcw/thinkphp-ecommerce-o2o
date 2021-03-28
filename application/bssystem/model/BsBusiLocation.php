<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-21
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\model;

use think\Model;
use app\admin\model\BsBusi;
use app\admin\model\BtCity;
use app\admin\model\BtCategory;

class BsBusiLocation extends Model {
    //外键关联查询方法
    /**
     * 查询主表 bs_busi
     */
    function toBsBusi(){
        return $this->belongsTo(BsBusi::class, 'busi_id', 'id');
    }

    /**
     * 查询主表 bt_city
     */
    function toBtCity(){
        return $this->belongsTo(BtCity::class, 'city_id', 'id');
    }

    /**
     * 查询主表 bt_category
     */
    function toBtCategory(){
        return $this->belongsTo(BtCategory::class, 'category_id', 'id');
    }



}