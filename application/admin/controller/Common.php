<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------

/**
 * @Name
 * @Description
 * @Auther 西安咪乐多软件
 * @Date 2023/10/12 14:02
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
//权限控制器
class Common extends Controller
{
	public  $config;

	public function _initialize()
	{
		if (!session('uname')){
			$this->error('请先登录系统','Login/index');
		}
		$request = Request::instance();
		$con = $request->controller();
		$action = $request->action();
		$this->assign('con',$con);
		$this->getConf();
	}

	public function getConf(){
		$confRes=array();
		$_confRes=db('conf')->field('ename,value')->select();
		foreach ($_confRes as $v){
			$confRes[$v['ename']]=$v['value'];
		}
		$this->cofig=$confRes;
	}


}