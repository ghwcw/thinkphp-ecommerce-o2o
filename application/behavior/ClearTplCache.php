<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-12
// |Description : 
// +-------------------------------------------------------------
namespace app\behavior;

class ClearTplCache {
    //清除缓存
    function run(){
        // echo PHP_OS;
        system('rd /s/q ..\runtime\temp');
    }

}

