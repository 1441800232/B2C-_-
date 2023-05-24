<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class CategoryWodes  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'category_id' => 'require',//require意思是必填  unique:表名  是验证他的唯一性
      'word'=> 'require|unique:category_words',//require

      ];
      //错误提示信息
      protected $message = [  
      'category_id.require' => '所属分类必须',
      'word.require' => '关联名称必须',
      'word.unique'=>'关联名称不能重复',
      ];

}
