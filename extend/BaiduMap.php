<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-17
// |Description : 
// +-------------------------------------------------------------

use think\facade\Config;

class BaiduMap {
    /**
     * 调用百度地图API，获取经纬度
     * @param $address
     * @return bool|string
     */
    static function getLongLat($address){
        // http://api.map.baidu.com/geocoding/v3/?address=北京市海淀区上地十街10号&output=json&ak=您的ak
        // url查询参数部分
        $query_data = [
            'address' => $address,
            'output' => 'json',
            'ak' => Config::get('map.ak'),
        ];
        // 构建完整的地图url
        $url = Config::get('map.map_host').Config::get('map.geocoding').'?'.http_build_query($query_data);
        // halt($url);
        // 直接使用file_get_contents获取网页结果
        // return file_get_contents($url);

        // 使用curl获取网页结果
        $ret = doCURL($url);
        if ($ret){
            return json_decode($ret);
        }else{
            return '';
        }
    }

    /**
     * 调用百度地图API，根据经纬度获取地图图片
     * @param $center
     */
    static function getMapImg($center){
        // http://api.map.baidu.com/staticimage/v2?center=116.403874,39.914889&ak=您的ak&width=280&height=140&zoom=11
        // url查询参数部分
        $query_data = [
            'center' => $center,
            'ak' => Config::get('map.ak'),
            'width' => Config::get('map.width'),
            'height' => Config::get('map.height'),
            'zoom' => Config::get('map.zoom'),
        ];
        // 构建完整的地图url
        $url = Config::get('map.map_host').Config::get('map.staticimage').'?'.http_build_query($query_data);

        // 使用curl获取网页结果
        return doCURL($url);
    }

}




