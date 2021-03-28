<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-01
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use app\bssystem\model\BsBusiAccount;
use app\bssystem\model\BsBusiLocation;
use app\bssystem\validate\BsAppVali;
use BaiduMap;
use think\facade\Session;

class Location extends LoginRequire {

    /**
     * 商户门店列表
     */
    function index(){
        $busiLocList = BsBusiLocation::paginate();
        $this->assign('busiLocList',$busiLocList);

        return $this->fetch('index');

    }

    /**
     * 显示新增门店页面
     */
    function add(){
        //获取当前账户ID
        $loginUserId = $this->getLoginUser()->id;
        //获取当前商户ID
        $busiObj = BsBusiAccount::get($loginUserId)->toBsBusi;
        $busiId = $busiObj->id;
        $busiName = $busiObj->name;
        $this->assign('busiId', $busiId);
        $this->assign('busiName', $busiName);

        //获取省级
        $citys = model('BtCity')->getProvincOrCity();
        $this->assign('citys', $citys);
        // dump($data);

        //获取一级服务分类
        $categorys = model('admin/BtCategory')->getUpLevelCateList();
        $this->assign('categorys',$categorys);

        return $this->fetch('add');
    }

    /**
     * 保存新增门店数据
     */
    function saveBusiLoc(){
        $data = input('post.');
        // halt($data);
        $vali = new BsAppVali();
        if(!$vali->scene('SubLoc')->batch()->check($data)){
            $this->result($vali->getError(), -1, '数据检验失败！');
        }
        //取经纬度
        $address = $data['address'];
        $long_lat = BaiduMap::getLongLat($address);
        $long = $lat = '';
        if(!empty($long_lat->result->location)){
            $long = $long_lat->result->location->lng;
            $lat = $long_lat->result->location->lat;
        }

        //要提交的bs_busi_location数据
        $city_id = $data['city_id']=='-1' ? null:$data['city_id'];
        $se_city_id = $data['se_city_id']=='-1' ? null:$data['se_city_id'];
        $sub_cate = empty($data['sub-cate']) ? []:$data['sub-cate'];
        $bs_busi_location_data = [
            'name' => $data['name'],
            'city_id' => $city_id,
            'city_path' => $city_id.','.$se_city_id,
            'logo' => $data['logo'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id']=='-1' ? null:$data['category_id'],
            'category_path' => implode(',', $sub_cate),
            'address' => $data['address'],
            'open_time' => date_format(date_create($data['open_time']),'Y-m-d H:i:s'),
            'xpoint' => $long,
            'ypoint' => $lat,
            'content' => empty($data['content']) ? null:$data['content'],
            'description' => empty($data['description']) ? null:$data['description'],
            'is_main' => 'N',
            'busi_id' => $data['busi_id'],
        ];
        $res = BsBusiLocation::create($bs_busi_location_data);
        if ($res){
            $this->result([], 1, '申请成功！');
        }else{
            $this->result([], -2, '保存失败！');
        }

    }






}

