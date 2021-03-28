<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-11
// |Description : 
// +-------------------------------------------------------------
namespace app\index\controller;

use app\admin\model\BsBusi;
use app\bssystem\model\BsBusiLocation;
use app\bssystem\model\BtGrobuy;
use think\Controller;

class Detail extends HeadBase {

    /**
     * 商品详情页
     * @param int $id : 商品id
     * @return mixed
     */
    function detail($id=0){
        if (!$id){
            $this->error('传入的商品ID不合法！');
        }

        //通过id获取商品数据
        $goodsData = BtGrobuy::get($id);
        $title = $goodsData->name;
        $endTime = $goodsData->end_time;
        $surplusDays = date_diff(date_create($endTime), date_create(date('Y-m-d H:i:s',time())));
        $surplusDays = date_interval_format($surplusDays,"%a天%h小时%i分%s秒");  //结束倒计时格式化
        $cityId = $goodsData->se_city_id;

        //通过商户id获取关联的店铺信息
        $busiObj = BsBusi::get($goodsData->busi_id);
        // $busiLoc = $busiObj->hasBusiLocation;
        $busiLoc = $busiObj->hasMany(BsBusiLocation::class, 'busi_id', 'id')->where('status','Y')->select();
        // halt($busiLoc);

        $this->assign('title', $title);
        $this->assign('goodsData', $goodsData);
        $this->assign('surplusDays', $surplusDays);
        $this->assign('cityId', $cityId);
        $this->assign('busiLoc', $busiLoc);

        return $this->fetch('detail');
    }

    /**
     * 获取地图
     * @param $center : 经纬度，“,”分隔
     * @return bool|string
     */
    function getMap($center){
        return \BaiduMap::getMapImg($center);
    }

}

