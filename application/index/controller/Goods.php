<?php
namespace app\index\controller;

class Goods extends Base
{

    public function index($id)
    {
		$goodsInfo= db('goods')->find($id);//传递商品的id获取商品的基本信息
		//商品主图信息数组
		$goodsThumbArray= array();
		if ($goodsInfo['og_thumb']){
			$goodsThumbArray['sm_photo']=$goodsInfo['sm_thumb'];
			$goodsThumbArray['mid_photo']=$goodsInfo['mid_thumb'];
			$goodsThumbArray['big_photo']=$goodsInfo['big_thumb'];
			$goodsThumbArray['og_photo']=$goodsInfo['og_thumb'];
		}
		//获取当前商品相册信息,field是给限定条件
		$goodsPhotoRes=db('goods_photo')->field('sm_photo,mid_photo,big_photo,og_photo')->where(array('goods_id'=>$id))->select();
		//array_unshift是指 把新得到的数组放进另外一个数组里面（把$goodsThumbArray数组放到$goodsPhotoRes数组里面）
		//将商品主图放置在最前面
		array_unshift($goodsPhotoRes,$goodsThumbArray);
		//获取并处理商品属性信息
		$gaArr=db('goods_attr')->alias('g_a')->field('g_a.*,a.attr_name,a.attr_type')->join('attr a',"g_a.attr_id = a.id")->where(array('g_a.goods_id'=>$id))->select();
		$radioAttrArr = array();//单选的属性
		$uniAttrArr = array();//唯一的属性
//		dump($gaArr);die();
		foreach ($gaArr as 	$k => $v) {
			if ($v['attr_type'] == 1){
				$radioAttrArr[$v['attr_id']][]=$v;
			}else{
				$uniAttrArr[]=$v;
			}
		}
//		dump($radioAttrArr);
//		echo '===============================<br>';
//		dump($uniAttrArr);die();
		$this->assign([
			'show_right'=>1,
			'goodsInfo'=>$goodsInfo,
			'goodsPhotoRes'=>$goodsPhotoRes,
			'uniAttrArr'=>$uniAttrArr,
			'radioAttrArr'=>$radioAttrArr,

		]);
        return view('goods');
    }

	public function ajaxGetMemberPrice($goods_id){
		$price = model('Goods')->getMemberPrice($goods_id);
		return json($price);
	}



}
