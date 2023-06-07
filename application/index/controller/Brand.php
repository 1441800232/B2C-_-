<?php
namespace app\index\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Brand  extends Controller //继承 控制类
{   //品牌列表
  public function lst()
  {
	$data = array();    //paginate是分页
    $brandRes = db('brand')->order('id DESC')->paginate(17);
	$data['total_page'] = $brandRes->lastPage();
	$brands = $brandRes->items();
	//进行拼装
	$html='';
	$html.='<div class="brand-list" id="recommend_brands"><ul>';
	foreach ($brands as $k => $v) { //$v就是品牌记录
		$html.='<li>
				<div class="brand-img">
				<a href="'.$v['brand_url'].'" target="_blank">
				<img src="'.config('view_replace_str.__UPADMIN__').'/'.$v['brand_img'].'"></a>
				</div>
				<div class="brand-mash"></div>
				</li>';
	}
	$html.='</ul><a href="javascript:void(0);" ectype="changeBrand" class="refresh-btn"><iclass="iconfont icon-rotate-alt"></i><span>换一批</span></a>
            </div>';
	$data['brands'] = $html;
	return json($data); //返回json类型
  }








}
