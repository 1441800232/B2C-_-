<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class GoodsAttr  extends Common //继承 控制类
{   //商品类型列表

 //异步获取 指定类型下的属性
    public  function ajaxdelga(){
        $del=db('goods_attr')->delete(input('gaid'));
        if($del){
            echo 1;//删除成功
        }else{
            echo 2; //删除失败
        }
    }




}
