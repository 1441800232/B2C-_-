<?php

namespace app\member\controller;
use app\index\controller\Base;
use think\Controller;
//Base是继承和头部低部类
class User extends Base
{
	public function index(){
		$this->assign([
			'show_right' =>1,
		]);
		return view();
	}
	public function loginOut(){
		model('User')->loginout();
		$this->success('退出成功','member/Account/login');
	}


}
