<?php

namespace app\member\controller;
use app\index\controller\Base;
use think\Controller;
use think\Exception;

//Base是继承和头部低部类
class Login extends Base
{
	public function login(){
		if(request()->isPost()){
			$data = input('post.');
			//验证码验证
			try {
				// 假设captcha_check函数内部已经处理了验证码的生成和验证
				if(!captcha_check($data['code'])){
					throw new Exception('验证码错误');
				}
				// 假设login函数内部已经处理了密码的加密和验证
				$logins = model('Logins')->login($data);
				if ($logins == 1){
					$this->success('登录成功!');
				}elseif($logins == 4){
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
		return view();
	}
	public  function add() {
		if (request()->isPost()){
			$data = input('post.');
			$data['password'] = md5($data['password']);
			$data['create_time'] = time();
			$data['last_time'] = time();
			$add = db('admin')->insert($data);
			if ($add){
				$this->success('成功','login');
			}else{
				$this->error('失败');
			}
			return ;
		}
		return view();
	}





}

