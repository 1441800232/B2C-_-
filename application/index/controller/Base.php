<?php
namespace app\index\controller;
use  think\Controller;
class Base extends Controller
{
	public $config;//配置项数组
	// 直接model 方法
    public function _initialize(){
		$this->_getFooterArts();//获取并分配低部帮助信息
		$this->_getNav();//获取并分配导航栏
		$this->_getConfs();//获取并分配配置项，config赋值
		$this->_getCates();//顶级分类 和 二级分类获取
	}

	//只在当前的控制器类里面使用
	//获取文章和cate类的信息配置
	private function _getFooterArts(){
		$mArticle=model('Article');
		//获取article模型里面的getFooterArts方法
		$helpCateRes=$mArticle->getFooterArts();//低部帮助信息
		$shopInfoRes=$mArticle->getShopInfo();//低部网店信息
		//分配模板中
		$this->assign([
			'helpCateRes' => $helpCateRes,
			'shopInfoRes' => $shopInfoRes,
		]);

	}
	//导航栏目
	private function  _getNav(){
		$_navRes=db('nav')->order('sort DESC')->select();//_取别名
		$navRes=array();
		//对navRes数组改写，把查询出来的数据分成两组数组
		foreach ($_navRes as $k => $v){
			$navRes[$v['pos']][]=$v;
		}
		$this->assign([
			'navRes'=>$navRes,
		]);
	}
	//配置项目
	private function _getConfs() {
		$confRes = model('Conf')->getConfs();
		$this->config=$confRes;
		$this->assign([
				'configs'=>$confRes
			]);
}
	//配置顶级分类和二级分类
	private function _getCates(){
		$cateRes = model('Category')->getCates();
//		dump($cateRes);die();
		$this->assign([
			'cateRes'=>$cateRes,
		]);
	}
   //低部网店信息
//	private	function _getShopInfo() {
//		$shopInfoRes = model('Article')->getShopInfo();
//	}
}
