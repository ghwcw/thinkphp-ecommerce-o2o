<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-13
// |Description : 
// +-------------------------------------------------------------
namespace app\index\controller;

use app\admin\model\BtCategory;
use app\bssystem\model\BtCity;
use app\bssystem\model\BtGrobuy;

class Lists extends HeadBase {
    function lists($cityId, $cateId='', $subCateId=''){
        //获取城市
        $cityObj = BtCity::get($cityId);
        //获取全部大类
        $cate = model(BtCategory::class)->getUpLevelCateList();

        //根据大类id获取子类
        /*if(empty($cateId)){
            $subCate = model(BtCategory::class)->getAllSubCate();   //全部子类
        }else{
            $subCate = model(BtCategory::class)->getCateList($cateId);
        }*/

        //获取销量、价格、发布时间排序(url查询参数)
        $sales = input('sales','');
        $price = input('price','');
        $issue = input('issue','');
        $order = []; $orderFlag = null;
        if(!empty($sales)){ $order['buy_count'] = 'desc'; $orderFlag = 'sales'; }
        if(!empty($price)){ $order['current_price'] = 'desc'; $orderFlag = 'price'; }
        if(!empty($issue)){ $order['create_time'] = 'desc'; $orderFlag = 'issue'; }

        if (count($order) > 0){
            //获取商品数据(携带url查询参数)
            $groBuyData = model(BtGrobuy::class)->getGrobuyByCityCateSubcate($cityId, $cateId, $subCateId)->order($order)->paginate(5,false,['query'=>input('get.')]);
        }else {
            //获取商品数据
            $groBuyData = model(BtGrobuy::class)->getGrobuyByCityCateSubcate($cityId, $cateId, $subCateId)->order('listorder')->paginate();
        }
        $count = model(BtGrobuy::class)->getGrobuyByCityCateSubcate($cityId, $cateId, $subCateId)->count();

        $this->assign('title', '全部分类列表');
        $this->assign('cate', $cate);
        $this->assign('cateId', $cateId);
        $this->assign('subCateId', $subCateId);
        $this->assign('cityObj', $cityObj);
        $this->assign('cityId', $cityId);
        $this->assign('groBuyData', $groBuyData);
        $this->assign('count', $count);
        $this->assign('orderFlag', $orderFlag);

        // halt(input('get.'));
        return $this->fetch('lists');
    }

}

