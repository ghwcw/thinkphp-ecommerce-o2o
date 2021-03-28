<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-12
// |Description : 
// +-------------------------------------------------------------
namespace app\behavior;

class ClearTplCache {
    function run(){
        // echo PHP_OS;
        system('rd /s/q ..\runtime\temp');
    }
}

