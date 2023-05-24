<?php
namespace app\index\controller;

class Category extends Base
{

    public function index()
    {
        return view('Category');
    }
	public function getCateInfo($id){
		//实例化模板
		$mdCategory = model('Category');

		//获取二级和三级子分类
		$cateRes =$mdCategory->getSonCates($id);

		//获取关联词
		$cwRes = $mdCategory->getCategoryWords($id);

		//获取关联品牌及推出信息(包含推广图)
		$brands =$mdCategory->getCategoryBrands($id);

		//中部子菜单
		$data = array();
		$cat=''; //"$cat.="这个操作符实际上等同于 "$cat = $cat .
		foreach ($cateRes as $k => $v){
			$cat.= '<dl class="dl_fore1"><dt><a href="'.url('index/Category/index',['id'=>$v['id']]).'" target="_blank">'.$v['cate_name'].'</a> </dt><dd>';
				foreach ($v['children'] as $k1 => $v1)	{
					$cat.= '<a href="'.url('index/Category/index',['id'=>$v1['id']]).'" target="_blank">'.$v1['cate_name'].'</a>';
				}
			$cat.='</dd></dl>
            <div class="item-brands"><ul></ul></div>
			<div class="item-promotions"></div>';
		}

		//全部分类菜单的顶部
		$channels = '';
		foreach ($cwRes as $k => $v){
			$channels.= '<a href="'.$v['link_url'].'" target="_blank">'.$v['word'].'</a>';
		}


		//品牌广告内容对应图片logo
		$brandsAdContent = '';
		$brandsAdContent.='<div class="cate-brand">';
			foreach ($brands['brands'] as $k => $v){
				$brandsAdContent.=
				'<div class="img">
					<a href="'.$v['brand_url'].'" targer="_blank" title="'.$v['brand_name'].'">
						<img src="'.config('view_replace_str.__UPADMIN__').'/'.$v['brand_img'].'">
					</a>
				</div>';
			}
		$brandsAdContent.='</div>';
		$brandsAdContent.='<div class="cate-brand">
							<a href="'.$brands['promotion']['pro_url'].'" targer="_blank" >
								<img width="199" height="97" src="'.config('view_replace_str.__UPADMIN__').'/'.$brands['promotion']['pro_img'].'">
							</a>
							</div>';

		$data['topic_content'] = $channels;
		$data['cat_content'] = $cat;
		$data['brands_ad_content'] = $brandsAdContent;
		$data['cat_id'] = $id ;
		return json($data);

	}
}
