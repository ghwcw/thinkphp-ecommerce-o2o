<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-24
// |Description : 
// +-------------------------------------------------------------
header('content-type:text/html; charset=utf-8');


function getUpLevelCity($value){
    return \app\admin\model\BtCity::get($value)->name;
}

