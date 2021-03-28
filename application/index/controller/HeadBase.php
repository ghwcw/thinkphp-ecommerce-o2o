<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-07
// |Description : 
// +-------------------------------------------------------------
namespace app\index\controller;
use app\admin\model\BtCategory;
use app\bssystem\model\BtCity;
use think\Controller;
use think\facade\Session;

class HeadBase extends Controller {
    public $cityObj = null;
    function initialize(){
        //获取用户session
        $user = $this->getUserSession();
        $username = null;
        if ($user){
            $username = $user['username'];
        }

        //获取城市
        $cities = BtCity::where('parent_id', '>', 0)->where('status', 'Y')->select();

        //获取当前城市
        $this->cityObj = $this->getCity($cities);

        //获取首页分类
        $cateList = $this->getParentAndSubCate();

        $this->assign('username', $username);
        $this->assign('cities', $cities);
        $this->assign('cityObj', $this->cityObj);
        $this->assign('cateList', $cateList);

    }

    /**
     * 获取登录用户信息
     * @return mixed|null
     */
    function getUserSession(){
        return empty(Session::get('o2oUser', 'o2o')) ? null : Session::get('o2oUser', 'o2o');
    }

    /**
     * 获取当前城市
     * @param $cities
     * @return BtCity
     */
    function getCity($cities){
        // Session::delete('city', 'o2o');
        // halt(Session::get('city', 'o2o'));
        if (!input('city')){
            if (Session::has('city', 'o2o')){
                $city = Session::get('city', 'o2o');     //从session中获取当前城市
            }else {
                foreach ($cities as $city){
                    if ($city->is_default=='Y'){
                        $default = $city->id;
                        break;
                    }
                }
                $default = $default ? $default : '7';   //如果取不到默认城市，就默认7（深圳）
                $city = $default;
                //城市放入session
                Session::set('city', $city, 'o2o');
            }

        }else{
            $city = input('city');    //从点击url上获取当前城市
            //城市放入session
            Session::set('city', $city, 'o2o');
        }
        return BtCity::get($city);

    }

    //获取父类及其字类
    function getParentAndSubCate(){
        $parentCate = model(BtCategory::class)->getCateListLimit(0, 5)->toArray();
        foreach ($parentCate as $key => $pcat){
            $pid = $pcat['id'];
            $subCate = model(BtCategory::class)->getCateListLimit($pid)->toArray();
            $parentCate[$key]['subCate']=$subCate;
        }

        return $parentCate;

    }

}

