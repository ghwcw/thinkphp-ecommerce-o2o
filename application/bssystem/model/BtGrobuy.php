<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-02
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\model;

use think\Db;
use think\db\Where;
use think\Model;

class BtGrobuy extends Model {

    /**
     * 根据大类和城市获取商品数据
     * @param int $cateId 大类，默认0查所有
     * @param int $cityId 城市，默认7深圳
     * @param int $limit 返回条目数
     * @return BtGrobuy[]|\think\Collection
     */
    function getGrobuyByCatCity($cateId=0, $cityId=7, $limit=100){
        $where = new Where();
        if ($cateId==0){
            $where['se_city_id'] = $cityId;
            $where['status'] ='Y';

        }else{
            $where['category_id'] = $cateId;
            $where['se_city_id'] = $cityId;
            $where['status'] = 'Y';

        }
        //end_time结束时间必须大于当前
        // return $this->where($where)->whereTime('end_time', '>', date('Y-m-d H:i:s'))->order('listorder','asc')->limit($limit)->select();

        return $this->where($where)->order('listorder','asc')->limit($limit)->paginate();
    }


    //根据城市id获取大类
    function getCateByCityId($cityId){
        return $this->where('se_city_id',$cityId)->field('category_id')->distinct('category_id')->select();

    }

    /**
     * 根据城市，大类，子类获取商品数据
     * @param $seCity
     * @param $cate
     * @param $subCate
     * @return BtGrobuy|\think\Paginator
     */
    function getGrobuyByCityCateSubcate($seCity, $cate, $subCate){
        $where = new Where();
        $where['status'] ='Y';
        if (!empty($seCity)){
            $where['se_city_id'] = $seCity;
        }
        if (!empty($cate)){
            $where['category_id'] = $cate;
        }
        if (!empty($subCate)){
            return $this->where($where)->where("find_in_set($subCate, se_category_id)");
        }

        $data = $this->where($where);
        // dump($seCity);
        // halt(Db::getLastSql());
        return $data;
    }

}


