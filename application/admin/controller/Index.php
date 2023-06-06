<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;
class Index  extends Controller
{
    public function index()
    {


  return view();

//分配数据给页面
  
}

//清空缓存
	public function  clearCache(){
		if (cache(NULL)){
			$this->success('缓存清除成功');
		}else{
			$this->error('缓存清除失败');
		}
	}

}