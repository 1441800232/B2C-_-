<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Attr  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'type_id' => 'require',//require意思是必填  unique:表名  是验证他的唯一性
      'attr_name' =>'require' ,

//      'attr_describe' => 'min:6',// min:意思是最少6个字符
      ];
      //错误提示信息
      protected $message = [
      'type_id.require' => '所属分类必须有',
      'attr_name.unique' => '属性名称必须有',

      ];

}
