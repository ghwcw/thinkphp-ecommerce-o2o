<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-14
// |Description : 
// +-------------------------------------------------------------
namespace app\index\controller;

use app\bssystem\model\BtGrobuy;
use app\common\MyQrCode;
use app\facade\Alipay;
use app\index\model\BsOrder;
use app\index\model\BtUser;
use think\Db;

class Pay extends HeadBase {
    /** 支付第一步：订单确认
     * @param $id: 商品id
     * @return mixed
     */
    function payStep1($id){
        //当前城市
        $cityId = input('get.cityId', null);
        //获取购买数量
        $counts = input('get.counts', null, 'intval');

        if (empty($id)){
            // $this->error('商品ID不合法');
            $this->result(null, -1, '商品ID不合法');
        }

        //判断登录状态
        if(empty($this->getUserSession())){
            // $this->error('您还未登录系统，请登录！');
            $this->result(null, -2, '您还未登录系统，请登录！','json');
        }
        //登录用户信息
        $userId = $this->getUserSession()['id'];
        $email = BtUser::get($userId)->value('email');

        $goodsData = BtGrobuy::get($id);
        if (empty($goodsData) || $goodsData->status!='Y'){
            $this->result(null, -3, '商品不存在或无效！');
        }

        $this->assign('title', '订单确认与支付');
        $this->assign('cityId', $cityId);
        $this->assign('goodsData', $goodsData);
        $this->assign('counts', $counts);
        $this->assign('email', $email);

        return $this->fetch('pay/pay_step');
    }

    /**
     * 支付第二步：订单支付
     * @param $id: 商品id
     * @return mixed
     */
    function payStep2($id){
        if (empty($id)){
            $this->result(null, -1, '商品ID不合法');
        }

        //判断登录状态
        if(empty($this->getUserSession())){
            $this->result(null, -2, '您还未登录系统，请登录！');
        }
        //登录用户信息
        $userId = $this->getUserSession()['id'];
        $userName = $this->getUserSession()['username'];
        $email = BtUser::get($userId)->value('email');

        //获取购买数量
        $counts = input('get.counts', 1, 'intval');
        $goodsData = BtGrobuy::get($id);
        if (empty($goodsData) || $goodsData->status!='Y'){
            $this->result(null, -3, '商品不存在或无效！');
        }

        //获取单价与实际支付额
        $price = input('get.price', 0.00, 'floatval');
        $payAmount = input('get.payAmount', 0.00, 'floatval');

        //订单表数据
        $orderData = [
            'order_no' => setOrderNo(),     //订单编号
            'transaction_no' => null,       //微信交易号
            'user_id' => $userId,
            'user_name' => $userName,
            'pay_time' => date('Y-m-d H:i:s'),      //微信支付时间
            'pay_mode' => 'WX',     //微信支付
            'grobuy_id' => $id,
            'grobuy_count' => $counts,
            'pay_status' => 'P',    //P已支付，E支付失败，W待支付
            'total_amount' => $price * $counts,
            'pay_amount' => $payAmount,
            'refer_url' => $_SERVER['HTTP_REFERER'],
        ];

        ////////测试////////
        // $this->result(['html'=>'<img style="width:100%;" src="/public/'.$goodsData->image.'">'], 0, '扫码支付');

        $payReturn = Alipay::pay([
            'out_trade_no' => $orderData['order_no'],           //订单号
            'total_amount' => $orderData['pay_amount'],         //订单总金额
            'subject'      => $goodsData->name,                 //订单标题
        ]);
        $qrCodeUrl = null;
        try {
            $qrCodeUrl = $payReturn->alipay_trade_precreate_response->qr_code;
        }catch (\Exception $e){
            $qrCodeUrl = '';
        }
        // 生成二维码并返回图片路径
        $qrCode = new MyQrCode($qrCodeUrl, $orderData['order_no']);
        $qrcodePath = $qrCode->qrcodePath();


        //开启事务
        Db::startTrans();
        try {
            $ret1 = BsOrder::create($orderData);
            //减库存
            $ret2 = BtGrobuy::update(['buy_count'=>['inc',$counts], 'total_count'=>['dec',$counts]], ['id'=>$id]);
            Db::commit();   //事务提交
        }catch (\Exception $e){
            Db::rollback(); //事务回滚
            $this->result(null, -4, '订单支付数据处理失败！'.$e->getMessage());
        }
        if ($ret1 && $ret2){
            $this->result(null, 1, $qrcodePath);
            // $this->result(null, 1, '恭喜，支付成功！');
        }else{
            $this->result(null, -5, '支付失败！');
        }

    }


}

