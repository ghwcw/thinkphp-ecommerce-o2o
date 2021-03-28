<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-13
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\model;

use think\facade\Config;
use think\Model;

class BtCategory extends Model {
    protected $table = 'bt_category';

    // 获取顶级服务分类
    function getUpLevelCateList(){
        return $this->where(['status'=>'Y', 'parent_id'=>0])->order(['id'=>'desc'])->select();
    }

    // 获取前几位服务分类
    function getCateListLimit($parentId=0, $limit=0){
        $where = [
            'parent_id' => $parentId,
            'status' => 'Y'
        ];
        if ($limit==0){
            return $this->where($where)->order('listorder', 'asc')->select();
        }else{
            return $this->where($where)->order('listorder', 'asc')->limit($limit)->select();
        }
    }

    // 根据parent_id获取服务子分类
    function getCateList($parentId=0){
        return $this->where('parent_id',$parentId)->order(['listorder'=>'asc'])->paginate();     //->select();
    }

    //获取所有子类
    function getAllSubCate(){
        return $this->where('parent_id','>',0)->order(['listorder'=>'asc'])->select();
    }


}

