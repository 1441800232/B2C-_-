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

}
