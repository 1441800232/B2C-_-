<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;
//引入无线分级类
use catetree\Catetree;
use think\Exception;

//继承 控制类
//管理员
class Login  extends Controller
{
	public function index(){
		if (session('uname') && session('id')){
			$this->error('您已经登入成功，请勿重复登陆！','Index/index');
		}

		if(request()->isPost()){
			$data = input('post.');
			//验证码验证
			try {
				// 假设captcha_check函数内部已经处理了验证码的生成和验证
				if(!captcha_check($data['code'])){
					throw new Exception('验证码错误');
				}

				// 假设login函数内部已经处理了密码的加密和验证
				$loginStatus = model('Admin')->login($data);
				if ($loginStatus == 1){
					$this->success('登录成功','Index/index');
				}elseif($loginStatus == 4){
					throw new Exception('当前用户账号被禁用！');
				}
				else{
					throw new Exception('用户名或密码错误');
				}
			} catch (Exception $e) {
				$this->error($e->getMessage());
			}
			return;
		}
		return view('index');
	}

}
