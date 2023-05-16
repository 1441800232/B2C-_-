<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Cate  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'cate_name' => 'require|unique:cate|min:2',//require意思是必填  unique:表名  是验证他的唯一性

      ];
      //错误提示信息
      protected $message = [  
      'cate_name.require' => '分类名称必须有',
      'cate_name.unique' => '分类名称不能重复',
      'cate_name.min'=>'分类名字不能过短'
      ,
      ];

}
