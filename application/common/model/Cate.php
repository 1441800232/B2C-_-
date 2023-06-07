<?php
namespace app\common\model;
use catetree\Catetree;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class Cate extends Model
{
	//普通分类
	public function  getComCate(){
		//获取普通分类的顶级分类
		$comCates = $this->where(array('cate_type'=>5,'pid'=>0))->select();
		// 有二级分类则查询
		foreach ($comCates as $k => $v){ //$v就是代表一个顶级字段
			//寻找他的子分类 他子分类的pid就等于当前分类的id
			$comCates[$k]['children'] = $this->where(array('pid'=>$v['id']))->select();
		}
		return $comCates;
	}
	//网店帮助分类
	public function shopHelpCates(){
		//获取网店帮助分类的顶级分类
		$helpCates = $this->where(array('cate_type'=>3,'pid'=>2))->select();
		return $helpCates;

	}
	//面包屑导航
	public function	 position($cateId){//传递栏目的id
		//获取所有栏目的信息
		$data = $this->field('id,pid,cate_name')->select();//fied是限定一下需要的条件有哪些
		//把当前栏目的id传递到私有里面
	  	 return $this->_position($data,$cateId);
	}
	//只提供当前的类使用
	private function _position($data,$cateId){//接收传递过来的参数
		//如果不是static 那么每次数组的循环就会被清空掉 倒置循环出现问题
		static $arr=array();//申明一个静态数组 可以每次把之前的数组保存起来
		$cates=$this->field('id,pid,cate_name')->find($cateId);//获取当前栏目
		//判断数组为空是第一次执行，如果是第一次执行就把当前栏目放进去
		if(empty($arr)){//empty 如果要判断是否为空，检查一个变量是否为空
			$arr[]=$cates;
		}
		foreach ($data as $k => $v){ //循环的$v就代表一个栏目
			 //如果当前栏目的pid = $v['id'],那么这个$v就是上级栏目
			if($v['id']==$cates['pid']){
				//就把当前栏目放到 静态数组里面
				$arr[] = $v;
				$this->_position($data,$v['id']);//再次找他的上级分类
			}
		}
		return array_reverse($arr);//查询最后得到的结果(array_reverse是反转数组顺序)
	}
}
