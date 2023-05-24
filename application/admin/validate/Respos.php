<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Respos  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'rec_name' =>'require|unique:require' ,

//      'attr_describe' => 'min:6',// min:意思是最少6个字符
      ];
      //错误提示信息
      protected $message = [
      'rec_name.require' => '推荐位名称必须存在',
      'rec_name.unique' => '推荐位名称不能重复',

      ];

}
