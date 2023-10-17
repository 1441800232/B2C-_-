<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------

/**
 * @Name
 * @Description
 * @Auther 西安咪乐多软件
 * @Date 2023/10/12 10:46
 */

namespace app\admin\model;
//引入系统模型类
use think\Model;

class Admin extends Model
{
	public function login($data){
		$uname = $data['uname'];
		$password = md5($data['password']);//提交的密码
		//在Admin类里面进行get的查询用户账号
		$admins = Admin::get(['uname'=>$uname]);
		if ($admins){
			$_password = $admins['password'];//获取传递过来的密码
			if ($_password == $password){
				//判断是否禁用账号
				if ($admins['status']==0){
					//管理员权限禁用
					return  4;
				}
				session('uname', $uname);
				session('id', $admins['id']);
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