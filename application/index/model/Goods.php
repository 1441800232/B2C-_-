<?php
namespace app\index\model;
use catetree\Catetree;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class Goods extends Model
{
	//获取指定推荐位里面的商品
	public function getRecposGoods($recposId,$limit=''){//$recposId获取推荐商品的id
		//热门商品id：5
		$_hotIds =db('rec_item')->where(array('value_type'=>1,'recpos_id'=>$recposId))->select();
		$hotIds = array();
		foreach ($_hotIds as $k => $v)
		{
			$hotIds[] = $v['value_id'];
		}
		$map['id'] = array('IN',$hotIds);//thinkphp中批量查找数据
		//field是限定获取的字段
		$recRes=$this->field('id,mid_thumb,goods_name,shop_price,markte_price')->where($map)->limit($limit)->select();//limit主要用于指定查询和操作的数量
		return $recRes;
	}

	//获取首页一、二级分类下的所有的推荐的商品(对应首页的商品推荐的栏目)
	public function getIndexRecposGoods($cateId,$recposId){//$cateId是传递当前栏目的id,$recposId推荐位的id
		//1、获取当前主分类下面所有的子分类的id
		$cateTree = new  Catetree();
		//$v就是当前主栏目的id
		$sonIds = $cateTree->childrenids($cateId,db('category'));//获取这个商品分类也就是大类
		$sonIds[]=$cateId;//通过大类获取所有的子类
		//2、获取新品推荐位符合条件的商品信息
		$_recGoods = db('rec_item')->where(array('value_type'=>1,'recpos_id'=>$recposId))->select();
		$recGoods = array();
//			dump($_recGoods);
		foreach($_recGoods as $kk => $vv) {
			$recGoods[]=$vv['value_id'];
		}
		//$map是限制条件(对应的商品设置了新品推荐的条件)
		$map['category_id'] = array('IN',$sonIds);//符合条件的栏目的id
		$map['id'] = array('IN',$recGoods);//符合条件的商品id
		//limit 用于限制查询结果数量
		$goodsRes= db('goods')->where($map)->limit(6)->order('id DESC')->select();
		return $goodsRes;
	}

	//获取商品会员价格
	public function getMemberPrice($goods_id){
		$levelId = session('level_id');//获取等级id
		$levelRate= session('level_rate');//获取等级折扣率
		$goodsInfo= $this->find($goods_id);//读取商品信息
		// 检查是否存在会员折扣率
		if (session('level_rate')){
			// 获取会员价格记录，根据会员等级和商品ID
			$memberPrice = db('member_price')->where(array('mlevel_id'=>$levelId,'goods_id'=>$goods_id))->find();
			if ($memberPrice){
				// 如果找到了会员价格，使用会员价格作为最终价格
				//设定会员价格
				$price=$memberPrice['mprice'];
			}else{
				// 如果没有会员价格记录，计算折扣率价格
				//折扣率价格
				$levelRate = $levelRate/100;//折扣率
				$price = $goodsInfo['shop_price']*$levelRate;
			}
		}else{
			// 如果没有会员折扣率，使用商品的原始价格作为最终价格
			$price = $goodsInfo['shop_price'];
		}
		return $price;//最终会员价格
	}


	public function getShopPrice($goods_id){
		$goodsInfo = db('goods')->field('shop_price')->find($goods_id);//本店价格
		return	$goodsInfo['shop_price'];
	}


}
