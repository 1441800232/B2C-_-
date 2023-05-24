<?php
namespace app\index\model;
use catetree\Catetree;
use  think\Model;

class Category extends Model
{
	//获取顶级分类 和 二级分类获取
	public function getCates(){
		//第一获取顶级分类
		$cateRes = $this->where(array('pid'=>0))->order('sort ASC')->select();
		//每次把一个分类($cateRe)给$v,然后查找当前下面的主分类下面的子分类，查找到这个子分类
		//在在这个子分类放到当前分类的下方
		//使用 $v['id'] 作为父ID，从数据库中检索所有子元素的记录。
		//将检索到的子元素的记录集合赋值给 $cateRes[$k]['chilrend']，其中 $k 是当前循环元素的索引。
		foreach ($cateRes as $k => $v){
			//在 $cateRes 数组的每个元素中添加一个新的键 'chilrend'，它包含当前类别的所有子类别。
			$cateRes[$k]['chilrend'] = $this->where(array('pid'=>$v['id']))->select();
		}
		return $cateRes;
	}


	//通过顶级分类的id获取二级和三级子分类
	public function getSonCates($id){//接收顶级分类的id
		//获取二级分类
		$cateRes = $this->where(array('pid'=>$id))->select();
		//遍历循环二级分类 找到他的三级分类,再放到当前分类下面
		foreach ($cateRes as $k => $v){//$v['id'] 意思是当前分类的id（二级分类）
			$cateRes[$k]['children'] = $this->where(array('pid'=>$v['id']))->select(); //获取三级分类
		}
		return $cateRes;
	}

	//通过顶级分类获取相关的搜索词
	public function getCategoryWords($id){
		//条件category_id的id等于当前主栏目的id
		$cwRes = db('categoryWords')->where('category_id','=',$id)->select();
		//等到的就是一个二位数组
		return $cwRes;
	}

	//获取当前栏目关联品牌及推出信息(包含推广图)
	public  function getCategoryBrands($id){
		$data = array();
		$brand = db('brand');
		$categoryBrands = db('categoryBrands')->where(array('category_id'=>$id))->find();
		//目前获取的CategoryBrands表目前是英文分隔状态的字符串，所有我们要把他打散成数组，再去获取数据，最后返回界面成（控制器）
		$brandsIdArr = explode(',', $categoryBrands['brands_id']);
		foreach ($brandsIdArr as $k =>$v){
			//接收brand表的数据放到新建字段brands里面,这将在数据库中查找db('brand')->find($v) ID 为 $v 的品牌记录find() 方法查找 $v 变量对应的品牌记录。
			$data['brands'][]=$brand->find($v); //存进去就是一个二维数组
		}
		//推广信息
		$data['promotion']['pro_img'] =$categoryBrands['pro_img'];
		$data['promotion']['pro_url'] =$categoryBrands['pro_url'];
//		dump($data);
//		print_r($brandsIdArr);die();
		return $data;

	}
	//首页推荐分类获取
	public function  getRecCategorys($recposId,$pid=0){ //根据推荐位的id,当前查询的是顶级或推荐
		$_cateRes = db('rec_item')->where(array('recpos_id'=>$recposId,'value_type'=>2))->select();//获取到当前推荐到首页的分类的信息(目前是id)
		//只考虑顶级分类发方式
		$cateRes=array();
		foreach ($_cateRes as $k => $v){
			//每次只查询一条数据所以用find
			$catesArr=db('category')->where(array('id'=>$v['value_id'],'pid'=>$pid))->find();
			if($catesArr){
				$cateRes[]=$catesArr;
			}

		}
		return $cateRes;
	}

}
