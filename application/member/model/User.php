<?php
namespace app\member\model;
use catetree\Catetree;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class User extends Model
{
//	protected  $field = true;
	//登入
	//type=0说明需要为客户端返回json对象，type=1说明要为服务端返回普通数组类型
	public function login($data,$type =0){
		$userDate = array();
		$userDate ['username']=trim($data['username']);//trim意思是不允许前后出现空格
		$userDate ['password']=md5($data['password']);
		//验证用户名、邮箱、手机号是否存在
		$users = db('user')->whereOr(array('username'=>$userDate['username']))->whereOr(array('email'=>$userDate['username']))->whereOr(array('mobile_phone'=>$userDate['username']))->whereOr(array('password'=>$userDate['password']))->find(); //whereOr是多条件查询
		if ($users) {
			if ($users['password'] === $userDate['password']) {
				// 将用户信息存储到会话中
				session('uid', $userDate['password']);
				session('username', $userDate['username']);

				// 获取用户积分并确定会员等级和折扣率
				$points = $users['points'];
				$memberLevel = db('member_level')->where('bom_point', '<=', $points)->where('top_point', '>=', $points)->find();
				session('level_id', $memberLevel['id']);//等级id
				session('level_rate', $memberLevel['rate']);//等级折扣率

				// 如果勾选了“记住我”，将凭据存储在 cookie 中以实现自动登录
				if (isset($data['remember'])) {
					$aMonth = 30 * 24 * 60 * 60; // 一个月的秒数
					$username = encryption($users['username'], 0);
					$password = encryption($data['password'], 0);
					cookie('username', $username, $aMonth, '/');
					cookie('password', $password, $aMonth, '/');
				}
				$response = [
					'error' => 0,
					'message' => "",
				];
			} else {
				$response = [
					'error' => 1,
					'message' => "<i class='iconfont icon-minus-sign'></i>密码错误",
					'url' => '',
				];
			}
		} else {
			$response = [
				'error' => 1,
				'message' => "<i class='iconfont icon-minus-sign'></i>用户名错误",
				'url' => '',
			];
		}

// 根据 $type 的值返回响应，使用三元运算符来简化代码
		return $type === 1 ? $response : json($response);

//		if ($users){
//			if ($users['password'] ==  $userDate['password'])
//			{
//				//把值写入session，登入后会显示你的账号已经登入在首页左上角
//				session('uid', $userDate['password']);
//				session('username', $userDate['username']);
//				//拿到当前会员积分
//				$points = $users['points'];
// 				//写入会员等级及折扣率信息
//				$memberLevel=db('member_level')->where(array('bom_point','<=',$points))->where('top_point','<=',$points)->find();
//				session('level_id',$memberLevel['id']);//等级id
//				session('level_rate',$memberLevel['rate']);//等级折扣率
//					//使用cookie，完成自动登入，写入cookie
//					if (isset($data['remember']))//isset是检查数组是否存在
//					{
//						$aMonth=30*24*60*60;//保存时间（一个月）
//						$username=encryption($users['username'],0);
//						$password=encryption($data['password'],0);
//						cookie('username',$username,$aMonth,3600,'/');
//						cookie('password',$password,$aMonth,3600,'/');
//					}
//				$arr=[
//					'error' =>0,
//					'message' =>"",
//				];
//					if ($type=1){
//						return $arr;
//					}else{
//						return json($arr);
//					}
//			}
//			else{
//				$arr= [
//					 'error'=>1,
//					 'message'=>"<i class='iconfont icon-minus-sign'></i>密码错误",
//					 'url'=>'',
//					 ];
//				if ($type=1){
//					return $arr;
//				}else{
//					return json($arr);
//				}
//			}
//		}
//		else{
//			$arr= [
//				'error'=>1,
//				'message'=>"<i class='iconfont icon-minus-sign'></i>用户名错误",
//				'url'=>'',
//			];
//			if ($type=1){
//				return $arr;
//			}else{
//				return json($arr);
//			}
//		}
	}

	//检查登入
	public function checkLogin(){
		$uid =session('uid');
		if ($uid){
			//成功状态
			$arr['error']=0;
			$arr['uid']=$uid;
			$arr['username']=session('username');
			return json($arr);
		}else{
			if (cookie('username')&&cookie('password')){
				$data['username']=cookie('username');
				$data['password']=cookie('password');
				//访问的数组
				$loginRes=model('User')->login($data);
				if ($loginRes['error'] == 0){
					$arr['error']=0;
					$arr['uid']=$uid;
					$arr['username']=session('username');
					return json($arr);
				}
			}
			$arr=array();
			$arr['error']=1;
			return json($arr);

		}
	}
	//退出登入(清空自动登入)
	public function loginout(){
		session(NULL);
		cookie('username',null);
		cookie('password',null);
	}
}
