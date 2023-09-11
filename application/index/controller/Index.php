<?php
namespace app\index\controller;
use  catetree\Catetree;
//继承低部类
class Index extends Base
{
    public function index()
    {

		//加密cookie
		//调用公告及促销的文章(Notice:公告、Promotion:促销)给他们做缓存
		//如果这个公告的缓存已经存在缓存了，我们就在缓存里面获取，如果没有就再去查询数据库
		//公告
		//把公告 缓存 20秒

		if (cache('noticeRes')){
			$noticeRes=cache('noticeRes');
		}else{
			$noticeRes = model('Article')->getArts(62,3);
			if ($this->config['cache'] == '是') {
				cache('notice', $noticeRes,$noticeRes,$this->config['cache_time']);
			}

		}

		//促销
		if (cache('promotionRes')){
			$promotionRes=cache('promotionRes');
		}else{
			$promotionRes = model('Article')->getArts(63,3);
			if ($this->config['cache'] == '是') {
				cache('promotionRes',$promotionRes,$this->config['cache_time']);
			}
		}




		//获取首页大模块顶级分类数据开始
		if(cache('categoryRes')){
			$categoryRes = cache('categoryRes');
		}
		else{
			//首页推荐,推荐位的顶级分类(目前限定了id)
			$categoryRes=model('Category')->getRecCategorys(4,0);
			//外层循环是顶级大分类
			foreach ($categoryRes as $k => $v) {
				//获取顶级类目分类下面被设置成 首页推荐的二级分类
				$categoryRes[$k]['children']=model('Category')->getRecCategorys(4,$v['id']);
				//获取二级栏目及其子栏目下的精品推荐商品，用于首页显示
				foreach ($categoryRes[$k]['children'] as $k1=>$v1) {//一个大分类下面的所有的二级分类(被推荐到首页的二级分类)
					//获取精品推荐
					$categoryRes[$k]['children'][$k1]['bestGoods']  =  model('Goods')->getIndexRecposGoods($v1['id'],11);
				}
				//获取新品推荐
				$categoryRes[$k]['newRecGoods'] = model('Goods')->getIndexRecposGoods($v['id'],10);
				// 获取该顶级分类相关的品牌信息
				$categoryRes[$k]['brands'] = model('Category')->getCategoryBrands($v['id']);
				//获取当前广告位置的顶级栏目的左侧图片信息
				$categoryRes[$k]['leftImg'] = model('CategoryAd')->getCatetCategoryAd($v['id']);
			}
			//缓存时长
			if ($this->config['cache'] == '是') {
				cache('categoryRes', $categoryRes,$this->config['cache_time']);
			}

		}
		//获取首页大模块数据结束

		//调用首页轮播图数据图片
		if(cache('alternateImgRes')){
			$alternateImgRes=cache('alternateImgRes');
		}else{
			$alternateImgRes = model('AlternateImg')->getAlterImg();
			//缓存时长
			if ($this->config['cache'] == '是') {
				cache('alternateImgRes', $alternateImgRes,$this->config['cache_time']);
			}
		}

		//调用首页商品(推荐到首页下面的商品)
		if (cache('indexGoodsRes')){
			$indexGoodsRes=cache('indexGoodsRes');
		}else{
			$indexGoodsRes = model('Goods')->getRecposGoods(12,20);
			if ($this->config['cache'] == '是') {
				cache('indexGoodsRes', $indexGoodsRes,$this->config['cache_time']);
			}		}
		$this->assign([//声明一个变量分配到模板中去
			'show_right'=>1,//文章列表和商品列表头部偏移类判断
			'show_nav'=>1,//首页导航默认展开,其他页面默认收缩
			'categoryRes'=>$categoryRes,//首页大分类数据
			'indexGoodsRes'=>$indexGoodsRes,//首页商品
			'noticeRes'=>$noticeRes,//公告文章
			'promotionRes'=>$promotionRes,//促销文章
			'alternateImgRes'=>$alternateImgRes//首页轮播图
		]);
//		dump($categoryRes);die();

		return view();
    }


}
