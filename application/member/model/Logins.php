<?php
// +----------------------------------------------------------------------
// | Name: 咪乐多管理系统 [ 为了快速搭建软件应用而生的，希望能够帮助到大家提高开发效率。 ]
// +---------------------------------------------------------------------

// | Author: 西安咪乐多软件 
// +----------------------------------------------------------------------
// | Version: V1
// +----------------------------------------------------------------------

/**
 * @Name
 * @Description
 * @Auther 西安咪乐多软件
 * @Date 2023/10/23 08:58
 */

namespace app\member\model;
use app\admin\model\Admin;
use app\admin\model\Login;
use  think\Model;
//前台文章模型 获取文章 和栏目信息
class Logins extends Model{
	public function login($data){
		$name = $data['uname'];
		$password = md5($data['password']);//提交的密码
		$admin = Admin::get(['uname'=>$name]);
		if ($admin){
			$_password = $admin['password'];//获取传递过来的密码
			if ($_password == $password){
				session('uname', $name);
				//密码正确可以登入
				return 1;
			}else{
				//密码出错
				return 2;
			}
		}else{
			//用户不存在
			return 3;
		}


	}


}