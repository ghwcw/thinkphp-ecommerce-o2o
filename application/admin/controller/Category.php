<?php
// +-------------------------------------------------------------
// |    Creator : Wang Chunwang
// |       Date : 2021-02-12
// |Description : 
// +-------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\BtCategory;
use app\admin\validate\CategoryVali;
use BaiduMap;
use think\Controller;
use think\facade\Request;

class Category extends Controller {

    /**
     * 生活服务分类首页
     */
    function index($parentId=0){
        // $parentId = input('get.parent_id',0);
        $CateList = model('BtCategory')->getCateList($parentId);    //助手函数model()
        $this->assign('CateList',$CateList);
        return $this->fetch('index');
    }

    /**
     * 添加生活服务分类
     */
    function add(){
        $UpLevelCateList = model('BtCategory')->getUpLevelCateList();
        $this->assign('UpLevelCateList',$UpLevelCateList);
        return $this->fetch('add');
    }

    /**
     * 保存/更新生活服务分类
     */
    function save(){
        // dump($this->request->param());

        if(!Request::isPost()){
            $this->error('请求错误！');
        }

        $data = input('post.');
        $vali = new CategoryVali();
        if(!$vali->scene('add')->batch()->check($data)){
            $this->error(dump($vali->getError()));
        }

        // $ret = new BtCategory();
        // $ret->save($data);

        // 存在id，属于更新操作
        $id = input('id');
        if($id){
            $ret = BtCategory::update($data, ['id'=>$id]);
            if($ret){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }
        }

        // 新增保存
        $ret = model('BtCategory')->save($data);
        if($ret){
            $this->success('保存成功');
        }else{
            $this->error('保存失败');
        }
    }

    /**
     * 点击编辑
     */
    function edit($id){
        if((int)$id<1){
            $this->error("参数id=".$id."不存在");
        }
        // 获取这个id的分类
        $obj = BtCategory::get($id);
        $this->assign('obj', $obj);

        // 获取上级分类目录
        $UpLevelCateList = model('BtCategory')->getUpLevelCateList();
        $this->assign('UpLevelCateList',$UpLevelCateList);

        return $this->fetch();

    }

    /**
     * 用户输入排序值
     */
    function listOrder($id, $listorder){
        $ret = BtCategory::update(['listorder'=>$listorder], ['id'=>$id]);
        if ($ret){
            $this->result($_SERVER['HTTP_REFERER'], 1, '成功');   //使用系统result()函数，返回标准的消息
        }else{
            $this->result($_SERVER['HTTP_REFERER'], 0, '失败');
        }
    }

    /**
     * 删除分类
     */
    function delete($id){
        // dump($id);
        BtCategory::destroy([$id]);
        exit("<script>alert('删除成功'); location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
    }


}

