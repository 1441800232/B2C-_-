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
		//查询文章列表
		$artRes=db('article')->where($map)->select();
		//获取当栏目基本信息
		$cates=$cate->find($id);
		//获取普通左侧栏目分类
		$comCates=model('Cate')->getComCate();
		//帮助左侧栏目分类
		$helpCates=model('Cate')->shopHelpCates();
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
