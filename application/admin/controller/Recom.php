<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-03-04
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\BsRecom;
use think\Controller;
use think\facade\Config;
use think\facade\Request;

class Recom extends Controller {

    /**
     * 推荐位列表
     */
    function index(){
        $recomPos = Config::get('recom.Recom');
        $this->assign('recomPos', $recomPos);

        $recomList = BsRecom::paginate();
        $this->assign('recomList',$recomList);

        $searchType = input('get.type', '0');
        if ($searchType != '0'){
            $recomList = BsRecom::where('type', $searchType)->paginate();
            $this->assign('recomList',$recomList);
            $this->assign('searchType',$searchType);
            return $this->fetch('index');
        }

        $this->assign('searchType',$searchType);
        return $this->fetch('index');
    }

    /**
     * 推荐位添加
     */
    function add(){
        if (Request::isPost()){
            $postData = input('post.');
            $res = BsRecom::create($postData);
            if ($res){
                $this->result(null, 1, '添加成功');
            }else{
                $this->result(null, -1, '添加失败');
            }

        }
        // halt(Request::module());
        $recomPos = Config::get('recom.Recom');
        $this->assign('recomPos', $recomPos);

        return $this->fetch('add');

    }
}



