<?php
namespace app\common\model;
use catetree\Catetree;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class AlternateImg extends Model
{
	//获取所有的配置项
	public function getAlterImg(){
		//只需要对表查询两个值 一个是英文名字一个是默认值
		$AlternateImg = $this->where('status','=',1)->order('sort DESC')->select();
		return $AlternateImg;

	}
}
