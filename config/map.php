<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-17
// |Description : 
// +-------------------------------------------------------------
header('content-type:text/html; charset=utf-8');

/**
 * 百度地图相关配置
 */
return[
    'map_host' => 'http://api.map.baidu.com/',
    'geocoding' => 'geocoding/v3/',                 //获取经纬度
    'ak' => 'WolZs88IPbFinNW0fb1MuoTvu0tH47SV',
    'staticimage' => 'staticimage/v2',              //获取地图图片
    'width' => 600,                                 //图片宽度
    'height' => 500,                                //图片高度
    'zoom' => 11,                                   //图片高清度
];


