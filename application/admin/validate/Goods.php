<?php
namespace app\admin\validate;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Validate;

class Goods  extends Validate //继承 控制类
{   
    //验证规则
    protected $rule = [
      'goods_name' => 'require|unique:goods',//require意思是必填  unique:表名  是验证他的唯一性
      'category_id' => 'require',
      'markte_price' => 'require',// mun:意思是必须是数字
      'shop_price' => 'require',
      'goods_weight' => 'require',

      ];
      //错误提示信息
      protected $message = [  
      'goods_name.require' => '商品名称不能为空!',
      'goods_name.unique' => '商品名称不能重复',
      'category_idfd.require' => '商品所属栏目不能为空!',
      'markte_price.require' => '商品市场价格不能为空!',
      'shop_price.require' => '商品本店价格不能为空 !',
      'shop_price.num' => '商品本店价格必须是数字!',
      'goods_weight.require' => '商品重量不能为空!',
      'goods_weight.num' => '商品重量必须是数字!',
      ];

}
