<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Admin  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      	'uname' => 'require|unique:Admin',
      	'password' => 'unique|min:6',
		];
      //错误提示信息
      protected $message = [
      'uname.unique' => '名称不得为空',
      'uname.require' => '名称不可重复',
      'password.unique' => '密码不可为空',
      'password.min' => '密码不能低于六位',
      ];
	  //场景
	  protected $scene= [
		  'add'=>['uname','password'],
		  'edit'=>['uname','password'=>'min:6'], //可以不填，如果填写了就一定不能少于6位
		  ];


}
