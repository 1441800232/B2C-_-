<?php

namespace app\admin\model;
//引入系统模型类

use think\Model;

class Category extends Model //extends继承 控制类
{
    //制作得一个配置项 功能 把不存在的字段忽略掉
    protected $field = true;
    //手册里面模型方法
    //可以在模型类的init（就是不管是前还是后之类都可以方在这个方法里面起始载入程式）方法里面统一注册模型事件，例如：
    protected static function init()
    {


        //修改商品之前 的操作 （修改）
        Goods::beforeUpdate(function ($category) {  //goods当前类实例也是获取goods控制器
            //商品的id接收
            //两个数组 传递过来的值上传
            $categoryID = $category->id;
            $categoryDate = input('post.');
			//处理商品推荐位， 先把原来的删除掉再添加新的
			db('rec_item')->where(array('value_type'=>2,'value_id'=>$categoryID))->delete();
			if($categoryDate['recpos']){
				foreach ($categoryDate['recpos'] as $k => $v){
					db('rec_item')->insert(['recpos_id' => $v, 'value_id' => $categoryID,'value_type' => 2]);
				}
			}
//            dump($categoryDate);die();


        });

        Goods::afterInsert(function ($category) {
			$categoryDate = input('post.');//接收表单数据
			$categoryID = $category->id;
			//处理商品推荐位
			if($categoryDate['recpos']){
				foreach ($categoryDate['recpos'] as $k => $v){
					db('rec_item')->insert(['recpos_id' => $v, 'value_id' => $categoryID,'value_type' => 2]);
				}
			}
        });

    }

}
