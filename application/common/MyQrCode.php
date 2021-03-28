<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-22
// |Description : 
// +-------------------------------------------------------------
namespace app\common;

use Endroid\QrCode\QrCode;

class MyQrCode {
    private $str;
    private $filename;

    function __construct($str, $filename) {
        $this->str = $str;
        $this->filename = $filename;
    }

    // 生成二维码，并返回保存的图片文件路径
    function qrcodePath() {
        if (empty($this->str) || empty($this->filename)){
            return '';
        }
        // 生成二维码
        $qrCode = new QrCode($this->str);
        // 设置二维码标签说明
        $qrCode->setLabel('请用支付宝扫码支付！');
        $qrCode->setSize(200, 200);
        // 保存为图片文件
        $path = './upload/qrcode/'.$this->filename.'.png';
        $qrCode->writeFile($path);
        // 输出图片路径
        return mb_substr($path, 1);
    }
}



