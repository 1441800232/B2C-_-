<?php
namespace app\index\model;
use catetree\Catetree;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class Cart extends Model
{
	//加入购物车(加入的商品、加入的商品属性、加入购物的数量)
	public function addToCart($goodsId, $goodsAttr='',$goodsNum=1){
		//显示判断是否有没有，如果有就进行反序列化成为一个数组，没用的话就是一个空数组
		$cart =isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();		//购物车数组
		$key = $goodsId.'-'.$goodsAttr;//拼装号成键
		if (isset($cart[$key])){
			//如果在此之前已经为该商品加入购物车，那么再次添加该商品的时候只需要修改商品的数量
			$cart[$key] += $goodsNum;//多次为该商品加入购物车
		}else{
			$cart[$key] = $goodsNum;//第一次为该商品加入购物车
		}
		$aMonth = time()+ 30*24*3600;
		setcookie('cart',serialize($cart),$aMonth,'/'); //serialize 是把数组转换成字符串（序列化）

	}
	//清空购物车
	public function clearCart(){
		setcookie('cart','',1,'/');
	}
	//删除一条购物车记录
	public function delCart($idAttr){

		$cart =isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();		//购物车数组
		$key = $idAttr;
		unset($cart[$key]);
		$aMonth = time()+ 30*24*3600;
		setcookie('cart',serialize($cart),$aMonth,'/'); //serialize 是把数组转换成字符串（序列化）

	}

	//批量删除购物车记录
	public function deleteCartGoods($cartValue){
		$cart =isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();		//购物车数组
		$cartValue = explode(' ', $cartValue);
//		[格式
//			'16-12,12'
//			'15-11,52'
//		]
		foreach ($cartValue as $k => $v){
			unset($cart[$v]);
		}
		$aMonth = time()+ 30*24*3600;
		setcookie('cart',serialize($cart),$aMonth,'/'); //serialize 是把数组转换成字符串（序列化）
	}

	//修改购物车中的商品数量
	public function updateCart($idAttr,$goodsNum=1){

		$cart =isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();		//购物车数组
		$key = $idAttr;//拼装号成键
		$cart[$key]= $goodsNum;
//		if ($cart[$key]){
//			$cart[$key]=$cart[$key]+$goodsNum;//多次为该商品加入购物车
//		}else{
//			$cart[$key]=$goodsNum;//第一次为该商品加入购物车
//		}
		$aMonth = time()+ 30*24*3600;
		setcookie('cart',serialize($cart),$aMonth,'/'); //serialize 是把数组转换成字符串（序列化）
		return json(['error'=>0]);
	}
	//读取cookie获取购物车商品
	public  function  getGoodsListInCart($doGoods=''){
		$goods=model('Goods');
		$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array(); //购物车数组
		//如果$doGoods 不为空那么就携带的参数进入到结算页面
		if($doGoods){
			//打散成数组接收 （转换成的格式：15-3,4）
			$doGoodsArr = explode(' ',$doGoods);
			foreach ($cart as $k => $v){
				if(!in_array($k,$doGoodsArr)){//商品不在$k里面就进行删除
					//如果商品不在列表中，它使用 unset($cart[$k]) 从 $cart 数组中移除它。
					unset($cart[$k]);
				}
			}
		}
		$_cart=array(); //把需要的数据放入进去
		foreach ($cart as $k => $v){
			//$arr[0]（第一个元素）就是商品的id，如果存在第二个元素$arr[1]就代表商品属性id字符串。 进行一个拆分id
			$arr = explode('-',$k);
			$goodsInfo= $goods->field('id,goods_name,mid_thumb,shop_price,markte_price')->find($arr[0]);
			$memberPrice = $goods->getMemberPrice($arr[0]);//获取会员的价格
			$_cart[$k]['goods_name']=$goodsInfo['goods_name'];
			$_cart[$k]['mid_thumb']=$goodsInfo['mid_thumb'];
			$_cart[$k]['member_price']=$memberPrice;
			$_cart[$k]['shop_price']=$goodsInfo['shop_price'];
			$_cart[$k]['market_price']=$goodsInfo['markte_price'];//
			$_cart[$k]['goods_num']=$v;
			$_cart[$k]['goods_id']=$goodsInfo['id'];
			$_cart[$k]['goods_id_attr_id']=$k;//单独保存$k，处理复选框问题
			$_cart[$k]['goods_attr_str']='';//商品单选属性字符串初始化
			if ($arr[1]){
				/*属性名称、属性值、属性价格
				  颜色		红色		0
				  尺寸		XXL		  100*/
				$goodsAttrStr = array(); //商品单选属性数组
				$goodsAttrPrice = 0;
				$goodsAttrRes = db('goods_attr')->alias('ga')->field('ga.*,a.attr_name')->join('attr a',"ga.attr_id = a.id")->where('ga.id','in',$arr[1])->select();
				foreach ($goodsAttrRes as $k1 => $v1){
					$goodsAttrStr[]=$v1['attr_name'].':'.$v1['attr_value'].'（￥ '.$v1['attr_price'].'元)';
					$goodsAttrPrice +=$v1['attr_price'];
				}
				$goodsAttrStr=implode('<br />',$goodsAttrStr);
				$_cart[$k]['goods_attr_str']=$goodsAttrStr;
				$_cart[$k]['member_price']+=$goodsAttrPrice;
				$_cart[$k]['shop_price']+=$goodsAttrPrice;
			}
			//小计
			$_cart[$k]['subtotal']=$_cart[$k]['member_price']*$v;
		}
		return $_cart;
	}

	//购物车数据改动时候，计算选中商品的总价、节省价、总数
	public function ajaxCartGoodsAmount($recId){
		//$recId选择商品的id字符串 $recId格式为：15-68,69 16-72,75 16-73,76
		$goods=model('index/Goods');
		$_cart['subtotal_number']=0;//商品的总数
		$_cart['goods_amount']=0;//商品会员价格总金额
		$_cart['save_total_amount']=0;//优惠节省总金额
		$_cart['shop_total']=0;//商品本店价格总金额
		$recIdArr = explode(' ',$recId);//一个字符串分割另一个字符串，并返回由字符串组成的数组
		$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array(); //购物车数组
		//删除为选中的购物车中的商品
		foreach ($cart as $k => $v){
			//$arr[0]（第一个元素）就是商品的id，如果存在第二个元素$arr[1]就代表商品属性id字符串。 进行一个拆分id
			$arr = explode('-',$k);
			if (!in_array($k,$recIdArr)){//函数搜索数组中是否存在指定的值。商品的id是否存在$recIdArr数组里面
				unset($cart[$k]);//unset删除
			}
		}
		//开始计算(这里的商品信息就是全部选定的信息)
		foreach ($cart as $k => $v){
 			$_cart['subtotal_number']+=$v;//计算商品总数
			//计算商品的会员总价总金额（含属性价格）
			$arr = explode('-',$k);    // 使用横杠('-')分割键值，提取产品ID和属性ID（如果存在）
			// 计算产品的会员价格和本店价格
			$memberPrice = $goods->getMemberPrice($arr[0]);//获取会员的价格
			$shopPrice=$goods->getShopPrice($arr[0]);

			//计算商品总本店价格（含属性价格）
			// 如果存在附加属性，计算其价格
			if ($arr[1]){
				$goodsAttrPrice = 0;
				$goodsAttrRes = db('goods_attr')->field('attr_price')->where('id','in',$arr[1])->select();
				foreach ($goodsAttrRes as $k1 => $v1){
					$goodsAttrPrice +=$v1['attr_price'];
				}
				$memberPrice+=$goodsAttrPrice;
				$shopPrice+=$goodsAttrPrice;
			}
			//对应商品的数量是$v
			$_cart['goods_amount']+=$memberPrice*$v;//商品的最终价格
			$_cart['shop_total']+=$shopPrice*$v;//商品本店价格
//			dump($v);die();
		}
		//计算商品总节省价格（优惠价）
		$_cart['save_total_amount']= $_cart['shop_total']-$_cart['goods_amount'];

		return $_cart;
	}

	//计算下单的商品总价格在flow3里面结算
	public 	function doGoodsPrice($doGoods){
		$goodsTotalPrice = 0;
		$goods=model('Goods');
		$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array(); //购物车数组
		//如果$doGoods 不为空那么就携带的参数进入到结算页面
		if($doGoods){
			//打散成数组接收 （转换成的格式：15-3,4）
			$doGoodsArr = explode(' ',$doGoods);
			foreach ($cart as $k => $v){
				if(!in_array($k,$doGoodsArr)){//商品不在$k里面就进行删除
					//如果商品不在列表中，它使用 unset($cart[$k]) 从 $cart 数组中移除它。
					unset($cart[$k]);
				}
			}
			$_cart=array(); //把需要的数据放入进去
			foreach ($cart as $k => $v){
				//$arr[0]（第一个元素）就是商品的id，如果存在第二个元素$arr[1]就代表商品属性id字符串。 进行一个拆分id
				$arr = explode('-',$k);
				$memberPrice = $goods->getMemberPrice($arr[0]);//获取会员的价格
				$_cart[$k]['member_price']=$memberPrice;
				if ($arr[1]){
					$goodsAttrPrice = 0;
					$goodsAttrRes = db('goods_attr')->alias('ga')->field('ga.*,a.attr_name')->join('attr a',"ga.attr_id = a.id")->where('ga.id','in',$arr[1])->select();
					foreach ($goodsAttrRes as $k1 => $v1){
						$goodsAttrPrice +=$v1['attr_price'];
					}
					$_cart[$k]['member_price']+=$goodsAttrPrice;
				}
				//小计
				$goodsTotalPrice += $_cart[$k]['member_price']*$v;
			}
		}
		return $goodsTotalPrice;

	}


}
