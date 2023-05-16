<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Nav  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'nav_name' => 'require|unique:nav',//require意思是必填  unique:表名  是验证他的唯一性
      'nav_url' => 'url',
      'pos' => 'require',// 必填
      ];
      //错误提示信息
      protected $message = [  
      'nav_name.require' => '导航名称未填写',
      'nav_name.unique' => '导航名字不能重复',
      'nav_url.url' => 'url格式不正确',
      'pos.require' => '导航位置未填写',
      ];

}
