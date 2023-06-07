<?php
namespace app\common\model;
use catetree\Catetree;
use  think\Model;

class CategoryAd extends Model
{
	//获取首页顶级栏目广告推荐位置的左侧图片
	public function getCatetCategoryAd($id){//$id 意思是传的是当前顶级栏目的id
		//查询到所有位置的图片
		$_data = db('CategoryAd')->where('category_id','=',$id)->select();
		//在对所有位置分组
		$data = array();
		foreach ($_data as $k=>$v) {
			$data[$v['position']][]=$v;
		}
		return $data;
	}
}
