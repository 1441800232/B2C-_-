<?php
namespace app\index\controller;
//Base是继承和头部低部类
class Article extends Base
{

    public function index($id)
    {
		//访问当前文章内容 ,也是当前栏目id
		$cacheName=$id.'_arts';
		if (cache($cacheName)){
			$atrs=cache($cacheName);
		}else{
			$atrs=db('article')->find($id);
			if ($this->config['cache'] == '是') {
				cache($cacheName, $atrs,$this->config['cache_time']);
			}
		}
		//获取普通左侧栏目分类
		if (cache('comCates')){
			$comCates=cache('comCates');
		}else{
			$comCates=model('Cate')->getComCate();
			if ($this->config['cache'] == '是') {
				cache('comCates', $comCates,$this->config['cache_time']);
			}
		}

		//帮助左侧栏目分类
		if (cache('helpCatesx')){
			$helpCates=cache('helpCates');
		}else{
			$helpCates=model('Cate')->shopHelpCates();
			if ($this->config['cache'] == '是') {
				cache('helpCatesx', $helpCates,$this->config['cache_time']);
			}
		}

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
