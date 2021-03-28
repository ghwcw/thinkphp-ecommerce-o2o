<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-20
// |Description : 
// +-------------------------------------------------------------
namespace app\common;

use think\facade\Config;

require_once '../vendor/alipay/formal/aop/AopClient.php';
require_once '../vendor/alipay/formal/aop/request/AlipayTradePrecreateRequest.php';


class Alipay {

    /**
     * @param array $tradeData 订单交易数据
     * @return bool|mixed|\SimpleXMLElement
     */
    function pay(array $tradeData){
        //取支付宝配置
        $aop = new \AopClient();
        $aop->appId             = Config::get('alipay.appId');
        $aop->gatewayUrl        = Config::get('alipay.gatewayUrl');
        $aop->format            = Config::get('alipay.format');
        $aop->signType          = Config::get('alipay.signType');
        $aop->rsaPrivateKey     = Config::get('alipay.rsaPrivateKey');
        $aop->alipayrsaPublicKey= Config::get('alipay.alipayrsaPublicKey');

        //调支付宝支付请求
        $tradeData = json_encode($tradeData);
        //创建request
        $request = new \AlipayTradePrecreateRequest();
        //在request对象中设置returnUrl和notifyUrl
        $returnUrl = Config::get('alipay.returnUrl');
        $notifyUrl = Config::get('alipay.notifyUrl');
        $request->setReturnUrl($returnUrl);
        $request->setNotifyUrl($notifyUrl);
        //商品数据
        $request->setBizContent($tradeData);
        $result = $aop->execute( $request);    //执行支付请求
        return $result;

    }

}

