<?php
namespace app\index\controller;
//Base是继承和头部低部类
class Article extends Base
{

    public function index($id)
    {
		//访问当前文章内容 ,也是当前栏目id
		$atrs=db('article')->find($id);
		//获取普通左侧栏目分类
		$comCates=model('Cate')->getComCate();
		//帮助左侧栏目分类
		$helpCates=model('Cate')->shopHelpCates();
		//面包屑导航
		$position=model('Cate')->position($atrs['cate_id']);
		//因为继承了Base类的方法，就可以直接声明变量
		$this->assign([//声明一个变量分配到模板中去
			'show_right'=>1,//文章列表和商品列表头部偏移类判断
			'comCates'=>$comCates,
			'helpCates'=>$helpCates,
			'atrs'=>$atrs,
			'position'=>$position,
		]);
        return view('Article');
    }
}
