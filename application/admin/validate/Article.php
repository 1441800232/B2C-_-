<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Article  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'title' => 'require|unique:cate',//require意思是必填  unique:表名  是验证他的唯一性
      'cate_id' => 'require',
      'email'=>'email',
      'link_url'=>'url',

      ];
      //错误提示信息
      protected $message = [  
      'title.require' => '标题必须',
      'title.unique' => '标题名称不能重复',
      'cate_id.require'=>'所属栏目不能为空',
      ];

}
