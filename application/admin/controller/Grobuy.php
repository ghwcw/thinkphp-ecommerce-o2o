<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-03
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\controller;

use app\bssystem\model\BtGrobuy;
use think\Controller;
use think\Db;
use think\db\Where;

class Grobuy extends Controller {

    /**
     * 团购商品列表，含搜索功能
     */
    function index(){

        //列出团购商品
        $groBuyList = BtGrobuy::paginate();
        $this->assign('groBuyList', $groBuyList);

        //获取省级
        $citys = model('bssystem/BtCity')->getProvincOrCity();
        $this->assign('citys', $citys);

        //获取一级服务分类
        $categorys = model('admin/BtCategory')->getUpLevelCateList();
        $this->assign('categorys',$categorys);

        $getData = input('get.');
        $category_id=$city_id=$start_time=$end_time=$name=null;
        if ($getData){
            $category_id = empty($getData['category_id']) ? null:$getData['category_id'];
            $city_id = empty($getData['city_id']) ? null:$getData['city_id'];
            if(!empty($getData['start_time'])) $start_time = date_format(date_create($getData['start_time']),'Y-m-d H:i:s');
            if(!empty($getData['end_time'])) $end_time = date_format(date_create($getData['end_time']),'Y-m-d H:i:s');
            $name = empty($getData['name']) ? null:trim($getData['name']);

            $where = new Where();
            if ((int)$category_id > 0) $where['category_id'] = $category_id;
            if ((int)$city_id > 0) $where['city_id'] = $city_id;
            if ($start_time && $end_time) $where['create_time'] = [ ['>=', $start_time], ['<=', $end_time] ];
            $where['name'] = ['like', '%'.$name.'%'];
            $groBuyList = BtGrobuy::where($where)->paginate();
            // exit(Db::getLastSql());

            $this->assign('groBuyList', $groBuyList);
            $this->assign('category_id', $category_id);
            $this->assign('city_id', $city_id);
            $this->assign('start_time', $start_time);
            $this->assign('end_time', $end_time);
            $this->assign('name', $name);

            return $this->fetch('index');
        }
        $this->assign('category_id', $category_id);
        $this->assign('city_id', $city_id);
        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $this->assign('name', $name);

        return $this->fetch('index');
    }
}



