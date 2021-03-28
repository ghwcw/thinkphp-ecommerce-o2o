<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-23
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\BtCategory;
use app\admin\model\BtCity;
use app\bssystem\model\BsBusiAccount;
use app\bssystem\model\BsBusiLocation;
use app\bssystem\validate\BsAppVali;
use BaiduMap;
use think\Controller;
use app\admin\model\BsBusi;
use think\facade\Request;

class BsSys extends Controller {
    /**
     * 获取商户列表
     */
    function showBusiList(){
        $bsAccList = model('BsBusi')->getBusiList();
        $this->assign('bsAccList',$bsAccList);
        return $this->fetch('index');
    }

    /**
     * 商户申请列表
     */
    function applyBusi(){
        $bsAppList = model('BsBusi')->getBusiList();
        $this->assign('bsAppList',$bsAppList);

        return $this->fetch('apply');
    }

    /**
     * 商户入驻详情编辑
     * $id: bs_busi_location表id
     */
    function detail($id){

        //获取省级
        $data = model('bssystem/BtCity')->getProvincOrCity();
        $this->assign('data', $data);
        // dump($data);

        //获取一级服务分类
        $cate = model('admin/BtCategory')->getUpLevelCateList();
        $this->assign('cate',$cate);

        //获取商户相关信息
        $busiObj = BsBusi::get($id);
        $busiLocObj = BsBusiLocation::where('busi_id',$id)->find();
        $cityObj = $busiLocObj->toBtCity;
        $cateObj = $busiLocObj->toBtCategory;
        $accoObj = BsBusiAccount::get(['busi_id'=>$id]);

        //二级城市
        $cityPath = trim($busiObj->city_path, ',');
        if(preg_match('/,/',$cityPath)){
            $cityPath = explode(',',$cityPath)[1];
        }
        $cityPathObj = BtCity::get($cityPath);

        //服务子分类
        $catePath = $busiLocObj->category_path;
        if(preg_match('/,/',$catePath)){
            $catePath = explode(',',$catePath);
        }
        $catePath = BtCategory::where(['id'=>$catePath])->select();

        // halt($cityPath);

        $this->assign('busiObj',$busiObj);
        $this->assign('busiLocObj',$busiLocObj);
        $this->assign('cityObj',$cityObj);
        $this->assign('cateObj',$cateObj);
        $this->assign('accoObj',$accoObj);
        $this->assign('cityPathObj',$cityPathObj);
        $this->assign('catePath',$catePath);
        $this->assign('currUrl',url());

        return $this->fetch('detail');
    }

    /**
     * 更新商户注册信息
     */
    function updateRegister(){
        $data = input('post.');
        // halt($data);
        $vali = new BsAppVali();
        if(!$vali->batch()->scene('update')->check($data)){
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

        //要提交的bs_busi_account数据
        $city_id = $data['city_id']=='-1' ? '':$data['city_id'];
        $se_city_id = $data['se_city_id']=='-1' ? '':$data['se_city_id'];
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
            'category_id' => $data['category_id']=='-1' ? '':$data['category_id'],
            'category_path' => implode(',', $sub_cate),
            'address' => $data['address'],
            'open_time' => date_format(date_create($data['open_time']),'Y-m-d H:i:s'),
            'xpoint' => $long,
            'ypoint' => $lat,
            'content' => empty($data['content']) ?'':$data['content'],
            'description' => empty($data['description']) ?'':$data['description'],
            'is_main' => 'Y',
            'status' => empty($data['status'])?'N':'Y',
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
            'status' => empty($data['status'])?'N':'Y',
        ];

        //要提交的bs_busi_account数据
        //密码md5加盐
        // $code = (string)mt_rand(1000, 9999);
        // $bs_busi_account_data = [
        //     'username' => $data['username'],
        //     'code' => $code,
        //     'password' => md5($data['password'].$code),
        //     'is_main' => 'Y',
        // ];

        //更新
        $busi_id = $data['busi_id'];
        $busi_loc_id = $data['busi_loc_id'];
        $bs_obj = BsBusi::update($bs_busi_data, ['id'=>$busi_id]);
        $bl_obj = BsBusiLocation::update($bs_busi_location_data, ['id'=>$busi_loc_id]);

        if ($bl_obj && $bs_obj){
            //发送邮件
            $email_addr = $data['email'];
            $subj = 'o2o入驻账户信息更新通知';
            $body = '<h2>数据更新成功</h2>';
            sendEmail([$email_addr,explode('@',$email_addr)[0]], $subj, $body);
            $this->success('数据更新成功，已发送邮件通知');
            
        }else{
            $this->error('更新失败');
        }
    }

    /**
     * 删除商户申请
     */
    function deleteBusi($id){
        $res = BsBusi::where('id',$id)->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}


