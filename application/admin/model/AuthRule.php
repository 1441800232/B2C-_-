<?php
namespace app\admin\model;
//引入系统模型类

use think\File;
use think\Model;
use think\Session;

class AuthRule  extends Model//extends继承 控制类

{


	public function ruletree($ruleRes){
		return $this->sort($ruleRes);
	}
	public function sort($ruleRes,$pid=0,$level=0){

		static $arr=array();
		foreach($ruleRes as $k =>$v){
			if($v['pid']==$pid){
				$v['level']=$level;
				$arr[]=$v;
				$this->sort($ruleRes,$v['id'],$level+1);
			}

		}
		return $arr;
	}


	//获取子栏目id
	public function childrenids($ruleid){
		// 从数据库中查询 id 和 pid 字段，存储到 $data 数组中
		$data=$this->field('id,pid')->select();
		// 返回调用 _childrenids 函数的结果，传递三个参数：$data 表示所有分类数据，$ruleid 表示当前分类 ID，TRUE 表示是否清空数组
		return $this->_childrenids($data,$ruleid,TRUE);//TRUE 意思是是否清空
	}
	private function _childrenids($data,$ruleid,$clear=FALSE){  // 返回调用 _childrenids 函数的结果，传递三个参数：$data 表示所有分类数据，$ruleid 表示当前分类 ID，TRUE 表示是否清空数组
		// 定义一个静态变量 $arr，用于存储所有子分类 ID
		static $arr=array();
		// 如果 $clear 参数为 TRUE，清空 $arr 数组
		if ($clear){
			$arr=array();
		}
		// 如果 $clear 参数为 TRUE，清空 $arr 数组
		foreach($data as $k =>$v){
			if($v['pid']==$ruleid){
				$arr[]=$v['id'];
				$this->_childrenids($data,$v['id']);

			}
		}
		return $arr;
	}

//处理栏目排序
	public function ruleSort($data,$obj)
	{ //k=栏目的id  v就是要把他修改成多少
		foreach ($data as $k=>$v){
			$obj->update(['id'=>$k,'sort'=>$v]);
		}
	}

}