<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;
/*
 * conf  add
 *
 *
 * */

class Conf  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'cname' => 'require|unique:conf',    //require意思是必填  unique:表名  是验证他的唯一性
      'ename' => 'require|unique:conf',
      ];
      //错误提示信息
      protected $message = [  
      'cname.require' => '配置必须中文名称',
      'cname.unique' => '配置中文名称不能重复',
      'ename.require'=>'配置必须英文名称',
      'ename.require'=>'配置英文名称不能重复',
      ];

}
