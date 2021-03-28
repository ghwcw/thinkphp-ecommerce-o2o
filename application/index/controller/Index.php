<?php
namespace app\index\controller;

use app\admin\model\BsRecom;
use app\bssystem\model\BtGrobuy;
use app\common\MyQrCode;
use app\facade\Alipay;
use Endroid\QrCode\QrCode;


class Index extends HeadBase {
    /**
     * o2o团购网首页
     * @return mixed
     */
    public function index()
    {
        //获取首页轮播图，取bs_recom表image
        $banner = BsRecom::where(['status'=>'Y', 'type'=>'F'])->order('listorder','asc')->limit(5)->select();
        $this->assign('banner', $banner);
        //获取右侧广告图，取bs_recom表image
        $right = BsRecom::where(['status'=>'Y', 'type'=>'R'])->order('listorder','asc')->find();
        // halt($right);
        $this->assign('right', $right);

        //获取团购商品
        $cate = input('cate', 0);
        $grobuyData = model(BtGrobuy::class)->getGrobuyByCatCity($cate, $this->cityObj->id);
        // halt($grobuyData);
        //获取右侧分类显示
        /*$noRepetCate = array();
        foreach ($grobuyData as $data){
            if (in_array($data->category_id, $noRepetCate)){ continue; }
            $noRepetCate[] = $data->category_id;
        }*/
        //获取分类（不重复）
        $noRepetCate = model(BtGrobuy::class)->getCateByCityId($this->cityObj->id);
        // halt($noRepetCate);
        $this->assign('grobuyData', $grobuyData);
        $this->assign('noRepetCate', $noRepetCate);
        $this->assign('cityId', $this->cityObj->id);
        $this->assign('title', '首页');

        return $this->fetch('index');   //继承了base.html
    }


    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }


    /**
     * 测试方法
     */
    function test($value=''){
        // echo sendEmail(['wongcw@foxmail.com','wongcw'],'测试','测试邮件内容');
        // echo '<script>alert("'.Request::domain().'")</script>';
        // $arr = ['a'=>1, 'b'=>2];
        // $arr = array_merge($arr,['c'=>3]);
        // dump($arr);

        // if($value==0){
        //     $value=1;
        // }
        // $ret = \app\admin\model\BtCity::get($value)->name;
        // return $ret;

        /*$result = Alipay::pay([
            'out_trade_no' => '2015032001010100108',      //订单号
            'total_amount' => '9.9',                      //订单总金额
            'subject' => '测试',                          //订单标题
        ]);
        // halt($result);
        // echo $result->alipay_trade_precreate_response->qr_code;

        // 生成二维码
        $qrCode= new MyQrCode($result->alipay_trade_precreate_response->qr_code, 2015032001010100108);
        echo $qrCode->qrcodePath();*/

        sendEmail('wongcw@foxmail.com','测试','测试');


    }

}


