<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Brand  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'brand_name' => 'require|unique:brand',//require意思是必填  unique:表名  是验证他的唯一性
      'brand_url' => 'url',
      'brand_describe' => 'min:6',// min:意思是最少6个字符
      ];
      //错误提示信息
      protected $message = [  
      'brand_name.require' => '品牌名称必须有',
      'brand_name.unique' => '品牌名字不能重复',
      'brand_url.url' => 'url格式不正确',
      'brand_describe.min' => '描述最少6个字符',
      ];

}
