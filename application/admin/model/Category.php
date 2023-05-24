<?php

namespace app\admin\model;
//引入系统模型类

use think\File;
use think\Model;
use think\Session;

class Category extends Model //extends继承 控制类
{
    //制作得一个配置项 功能 把不存在的字段忽略掉
    protected $field = true;
    //手册里面模型方法
    //可以在模型类的init（就是不管是前还是后之类都可以方在这个方法里面起始载入程式）方法里面统一注册模型事件，例如：
    protected static function init()
    {

        //修改商品之前 的操作 （修改）
        category::beforeUpdate(function ($category) {  //category当前类实例
            $categoryID = $category->id;
//            处理新增商品属性
            $categoryDate = input('post.');
			//处理商品推荐位， 先把原来的删除掉再添加新的
			db('rec_item')->where(array('value_type'=>2,'value_id'=>$categoryID))->delete();

			if(isset($categoryDate['recpos'])){
				foreach ($categoryDate['recpos'] as $k => $v){
					db('rec_item')->insert(['recpos_id' => $v, 'value_id' => $categoryID,'value_type' => 2]);
				}
			}
        });

        category::afterInsert(function ($category) {
			$categoryDate = input('post.');//接收表单数据
			$categoryID = $category->id;
			//处理商品推荐位
			if(isset($categoryDate['recpos'])){
				foreach ($categoryDate['recpos'] as $k => $v){
					db('rec_item')->insert(['recpos_id' => $v, 'value_id' => $categoryID,'value_type' => 2]);
				}
			}

        });

        //删除有商品及后面该所有数据
        category::beforeDelete(function ($category) {
            $categoryID = $category->id;

            //删除主图及其缩略图
            //使用数组的方式 使用循环删除
            // 判断是否有值 ，有图
            if ($category->og_thumb) {//有值 进行的操作
                $thumb = [];
                $thumb[] = IMG_UPLOAD . $category->og_thumb;
                $thumb[] = IMG_UPLOAD . $category->big_thumb;
                $thumb[] = IMG_UPLOAD . $category->mid_thumb;
                $thumb[] = IMG_UPLOAD . $category->sm_thumb;
                //循环这个数组一次行把这个删除
                foreach ($thumb as $k => $v) { //v就是要删除的路径 把路径赋值给了k = 给了 v
                    if (file_exists($v)) { //file_exists — 检查文件或目录是否存在 $v 是路径
                        @unlink($v);
                    }
                }
            }


            //删除关联的会员价格  用的是db方法删除
            db('member_price')->where('category_id', '=', $categoryID)->delete();
//            //删除关联的商品属性
            db('category_attr')->where('category_id', '=', $categoryID)->delete();
            //删除关联的商品相册 ，使用模型文件删除
            //实例化categoryPhoto这个模型， where 是里面是条件
            $categoryPhotoRes = model('categoryPhoto')->where('category_id', '=', $categoryID)->select();
            if (!empty($categoryPhotoRes)) {//如果他不为空
                foreach ($categoryPhotoRes as $k => $v) {
                    //使用数组的方式 使用循环删除
                    // 判断是否有值 ，有图
                    if ($v->og_photo) {//有值 进行的操作
                        $photo = [];
                        $photo[] = IMG_UPLOAD . $v->og_photo;
                        $photo[] = IMG_UPLOAD . $v->big_photo;
                        $photo[] = IMG_UPLOAD . $v->mid_photo;
                        $photo[] = IMG_UPLOAD . $v->sm_photo;
                        //循环这个数组一次行把这个删除
                        //k1和v1就代表具体的一条记录里面的对应的几个缩略图和原图的地址
                        foreach ($photo as $k1 => $v1) { //v就是要删除的路径 把路径赋值给了k1 = 给了 v1
                            if (file_exists($v1)) { //file_exists — 检查文件或目录是否存在 $v 是路径
                                @unlink($v1);
                            }
                        }
                    }

                }
            }
            //把数据库记录删除
            model('categoryPhoto')->where('category_id', '=', $categoryID)->delete();
//            dump($goosPhotoRes);die();

        });

    }



}
