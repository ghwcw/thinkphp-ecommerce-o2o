<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-13
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\validate;

use think\Validate;

class CategoryVali extends Validate {
    // 规则
    protected $rule = [
        'code|分类编码' => 'require|max:20',
        'name|分类名称' => 'token|require|max:50',
        'parent_id|分类栏目' => 'number|max:10',
        'id|分类ID' => 'number',
        'status|分类状态' => 'in:Y,N,D',
        'listorder|分类排序号' => 'number',
    ];

    // 场景设置
    protected $scene = [
        'add' => ['code', 'name', 'parent_id', 'id', 'status', 'listorder'], // 添加/更新
        'listorder' => ['id', 'listorder'], // 排序
    ];


}