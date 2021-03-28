<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-13
// |Description : 
// +-------------------------------------------------------------

// $data = '';
//
// echo $data ? '非空':'空';

//
// $where['name'] = ['eq',100];
// print_r($where);

//
// function has($val){
//     if (!isset($val)){
//         return false;
//     }else{
//         if ($val===0 || $val==='0'){
//             return true;
//         }elseif (empty($val)){
//             return false;
//         }
//
//     }
//     return true;
// }
//
// $a[]=1;
// $a[]=2;
// print_r($a);

// $a=0;
// echo $a ?:'No';

// $where = array();
// $where = [
//     'name' => 'IIII',
//     null => ['exp', 'find_in_set']
// ];
// $where[]=['exp', 'find_in_set'];
//
// print_r($where);

// print_r(date_create(date('Y-m-d H:i:s',time())));


// $order = [];
// $order = ['buy_count'=>'desc'];
// // $order += ['create_time'=>'desc'];
// $order = array_merge($order,['create_time'=>'desc']);
// print_r($order);

// echo preg_replace('/\./','',microtime(true));  echo '   ';
// echo str_replace('.','',strval(microtime(true)));

// function setOrderNo(){
//     //返回当前时间
//     $Sec = date('YmdHis');
//     $mic = explode('.', microtime(true))[1];    //毫秒部分
//     $micSec = $Sec.$mic;
//
//     //获取6位随机数
//     $rand = strval(mt_rand(0, 999999));
//     if (mb_strlen($rand)<6){
//         $rand = str_pad($rand, 6, '0', STR_PAD_LEFT);
//     }
//
//     return $micSec.$rand;
// }
//
// echo setOrderNo();

// echo uniqid(date('YmdHis'));

// echo md5('admin2703');







