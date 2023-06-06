<?php
namespace app\index\controller;
use catetree\Catetree;
class Cate extends Base
{
    public function index($id)
    {
		$cate=db('cate');
		//获取当前栏目级其子栏目id，返回数组
		$cateTree = new Catetree;
		$ids=$cateTree->childrenids($id,$cate);
		$ids[]=$id;
		$map['cate_id']=array('IN',$ids);
		//查询文章列表(并且缓存)
		$cacheArtResName = $id.'_artRes';
		if (cache($cacheArtResName)){
			$artRes=cache($cacheArtResName);
		}else{
			$artRes=db('article')->where($map)->select();
			cache($cacheArtResName,$artRes,3600);
		}
		//获取当栏目基本信息
		$cates=$cate->find($id);
		//获取普通左侧栏目分类
		if (cache('comCates')){
			$comCates=cache('comCates');
		}else{
			$comCates=model('Cate')->getComCate();
			cache('comCates',$comCates,3600);
		}

		//帮助左侧栏目分类
		if (cache('helpCates')){
			$helpCates=cache('helpCates');
		}else{
			$helpCates=model('Cate')->shopHelpCates();
			cache('helpCates',$helpCates,3600);
		}
		//因为继承了Base类的方法，就可以直接声明变量
		$this->assign([//声明一个变量分配到模板中去
			'show_right'=>1,//文章列表和商品列表头部偏移类判断
			'comCates'=>$comCates,
			'helpCates'=>$helpCates,
			'artRes'=>$artRes,
			'cates'=>$cates,//当前栏目基本信息
		]);
        return view('cate');
    }
}
