<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-19
// |Description : 
// +-------------------------------------------------------------
namespace app\bssystem\controller;

use app\admin\model\BsBusi;
use app\bssystem\model\BsBusiAccount;
use app\bssystem\model\BsBusiLocation;
use app\bssystem\validate\BsAppVali;
use BaiduMap;
use think\Controller;
use app\bssystem\model\BtCity;
use app\admin\model\BtCategory;
use think\facade\Request;

class Register extends Controller {
    function index(){
        //获取省级
        $data = model('BtCity')->getProvincOrCity();
        $this->assign('data', $data);
        // dump($data);

        //获取一级服务分类
        $cate = model('admin/BtCategory')->getUpLevelCateList();
        $this->assign('cate',$cate);

        return $this->fetch('index');
    }

    /**
     * 获取省所属城市
     */
    function getCityOfProv($provId){
        $city = model('BtCity')->getProvincOrCity($provId);
        $this->result($city);
    }

    /**
     * 获取服务子分类
     */
    function getSubCategory($parent_id){
        $sub_cate = model('admin/BtCategory')->getCateList($parent_id);
        $this->result($sub_cate);
    }

    /**
     * 申请注册
     */
    function appRegister(){
        $data = input('post.');
        $vali = new BsAppVali();
        if(!$vali->batch()->check($data)){
            $this->error(dump($vali->getError()));
        }
        //取经纬度
        $address = $data['address'];
        $long_lat = BaiduMap::getLongLat($address);
        // halt($data);
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
            'licence_logo' => $data['licence_logo'],
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
            'email' => $data['email'],
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
            'is_main' => 'Y',
        ];

        //要提交的bs_busi数据
        $bs_busi_data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'desc' => empty($data['description']) ?'':$data['description'],
            'city_id' => $city_id,
            'city_path' => $city_id.','.$se_city_id,
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
        ];

        //要提交的bs_busi_account数据
        //密码md5加盐
        $code = (string)mt_rand(1000, 9999);
        $bs_busi_account_data = [
            'username' => $data['username'],
            'code' => $code,
            'password' => md5($data['password'].$code),
            'is_main' => 'Y',
        ];
        //判断用户名是否存在
        $username = $data['username'];
        $user_obj = BsBusiAccount::where('username',$username)->find();     //value('id');
        if(!empty($user_obj)){
            $this->error('用户已注册！');
        }
        $bs_obj = BsBusi::create($bs_busi_data);
        $busi_id = $bs_obj->id;
        $bs_busi_location_data = array_merge($bs_busi_location_data, ['busi_id'=>$busi_id]);
        $bs_busi_account_data = array_merge($bs_busi_account_data, ['busi_id'=>$busi_id]);
        $bl_obj = BsBusiLocation::create($bs_busi_location_data);
        $ba_obj = BsBusiAccount::create($bs_busi_account_data);

        if ($bl_obj && $ba_obj &&$bs_obj){
            //发送邮件
            $url = Request::domain().url('bssystem/Register/activate',['account_id'=>$ba_obj->id]);
            $email_addr = $data['email'];
            $subj = 'o2o入驻账户申请激活通知';
            $body = '您提交的入驻申请需要等待平台审核，您可以点击下方链接查看审核状态。<br><a href="'.$url.'" target="_blank">查看审核状态</a>';
            sendEmail([$email_addr,explode('@',$email_addr)[0]], $subj, $body);
            $this->success('申请成功，已发送激活邮件');
        }else{
            $this->error('申请失败');
        }

    }

    /**
     * 邮件激活
     */
    function activate($account_id=''){
        if (empty($account_id)){
            $this->error('账户ID: '.$account_id.'不存在');
        }
        //获取记录详情
        $account_obj = BsBusiAccount::get($account_id);
        $this->assign('account_obj',$account_obj);
        return $this->fetch('activate');

    }


}

