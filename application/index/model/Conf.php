<?php
namespace app\index\model;
use catetree\Catetree;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class Conf extends Model
{
	//获取所有的配置项
	public function getConfs(){
		//只需要对表查询两个值 一个是英文名字一个是默认值
		$_confRes = $this->field('ename,value')->select();
		//获取的数据是一个二位数组，把他转换城一维数组
		$confRes=array();
		foreach ($_confRes as $k => $v){
			$confRes[$v['ename']] = $v['value'];
		}
		return $confRes;

	}
}
