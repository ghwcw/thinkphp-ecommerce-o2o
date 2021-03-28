<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-02
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use app\bssystem\model\BsBusiAccount;
use app\bssystem\model\BtGrobuy;
use app\bssystem\validate\BsAppVali;
use BaiduMap;
use think\facade\Request;
use think\facade\Session;

class Grobuy extends LoginRequire {

    /**
     * 团购列表
     * @return mixed
     */
    function index(){
        $groBuyList = BtGrobuy::paginate();
        $this->assign('groBuyList',$groBuyList);

        return $this->fetch('index');
    }

    /**
     * 添加团购
     * @return mixed
     */
    function add(){
        if(Request::isPost()){
            ////如果是post，则保存数据

            $data = input('post.');
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

            //要提交的$bt_grobuy_data数据
            $city_id = $data['city_id']=='-1' ? null:$data['city_id'];
            $se_city_id = $data['se_city_id']=='-1' ? null:$data['se_city_id'];
            $sub_cate = empty($data['sub-cate']) ? []:$data['sub-cate'];
            $location_ids = empty($data['location_ids']) ? []:$data['location_ids'];
            $loginUser = Session::get('loginUser.id', 'bssystem');
            $bt_grobuy_data = [
                'name' => $data['name'],
                'city_id' => $city_id,
                'se_city_id' => $se_city_id,
                'category_id' => $data['category_id']==-1 ? null:$data['category_id'],
                'se_category_id' => implode(',', $sub_cate),
                'location_ids' => implode(',', $location_ids),

                'image' => $data['logo'],
                'total_count' => $data['total_count'],
                'buy_count' => $data['buy_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],

                'address' => $data['address'],
                'start_time' => date_format(date_create($data['start_time']),'Y-m-d H:i:s'),
                'end_time' => date_format(date_create($data['end_time']),'Y-m-d H:i:s'),
                'coupons_begin_time' => date_format(date_create($data['coupons_begin_time']),'Y-m-d H:i:s'),
                'coupons_end_time' => date_format(date_create($data['coupons_end_time']),'Y-m-d H:i:s'),
                'xpoint' => $long,
                'ypoint' => $lat,
                'notes' => empty($data['notes']) ? null:$data['notes'],
                'desc' => empty($data['description']) ? null:$data['description'],
                'busi_account_id' => $loginUser,

                'busi_id' => $data['busi_id'],
            ];
            $res = BtGrobuy::create($bt_grobuy_data);
            if ($res){
                $this->result([], 1, '申请成功！');
            }else{
                $this->result([], -2, '保存失败！');
            }

        }else{
            ////否则，显示页面

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

            //获取一级服务分类
            $categorys = model('admin/BtCategory')->getUpLevelCateList();
            $this->assign('categorys',$categorys);

            return $this->fetch('add');

        }

    }

}

