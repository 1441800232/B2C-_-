<?php
namespace app\index\model;
use think\Model;
//前台文章模型 获取文章 和栏目信息
class Article  extends	Model
{
	//获取帮助分类
	public function getFooterArts()
	{
		//获取所有的帮助低部分类
		//获取帮助分类
		$helpCateRes = model('Cate')->where(array('cate_type'=>3))->order('sort DESC')->select();
		//通过栏目的信息获取他栏目下的文章，
		//获取到的文章是一个二位数组
		foreach ($helpCateRes as $k => $v){
			//获取当前栏目id放到新的字段artslim
			$helpCateRes[$k]['arts']=$this->where(array('cate_id'=>$v['id']))->select();
		}
		return $helpCateRes;
	}

	//获取网店信息
	public function getShopInfo() {
		//取文章
		$artArray = $this->where('cate_id','=',68)->field('id,title')->select();
		return $artArray;
	}

	//获取首页公告栏目信息
	public  function getArts($id,$limit){ //一个是获取文章的id 一个是限制数量
		$arts = $this->where('cate_id','=',$id)->order('id DESC')->limit($limit)->select();
		return $arts;

	}
}
