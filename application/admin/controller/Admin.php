<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;
//引入无线分级类
use catetree\Catetree;
 //继承 控制类
//管理员
class Admin  extends Common
{
	public  function lst() {
		$adminRes = db('admin')->paginate(5);
		$this->assign([
			'adminRes' => $adminRes,
		]);
		return view('list');
	}

	public  function add() {
		if (request()->isPost()){
			$data = input('post.');
			//验证
//			 $validate = validate('Admin');
//			 if (!$validate->scene('add')->check($data)) {
//			   $this->error($validate->getError());
//			 }
			$data['password'] = md5($data['password']);
			$data['create_time'] = time();
			$data['last_time'] = time();
			$add = db('admin')->insert($data);
			if ($add){
				$this->success('添加管理员成！','lst');
			}else{
				$this->error('添加管理员失败');
			}
			return ;
		}
		return view();
	}

	public  function edit() {
		if (request()->isPost()){
			$data = input('post.');
			//验证
			$validate = validate('Admin');
			if (!$validate->scene('edit')->check($data)) {
				$this->error($validate->getError());
			}
			if ($data['password']){
				$data['password'] = md5($data['password']);
			}else{
				unset($data['password']);
			}
			$save = db('admin')->update($data);
			if (!$save==false){
				$this->success('修改管理员成！','lst');
			}else{
				$this->error('修改管理员失败');
			}
			return ;
		}
		$admins = db('admin')->find(input('id'));
		$this->assign([
			'admins' => $admins,
		]);
		return view();
	}
	//
	public  function del($id) {
		//id=1是用户超级管理员
		if($id == 1){
			$this->error('超级管理员不可以删除');
		}
		$del= db('admin')->delete($id);
		if ($del){
			$this->success('删除管理员成功','lst');
		}else{
			$this->error('删除失败');
		}
		return view();
	}
	//ajax修改管理员状态
	public function changestasus(){
		$id = input('id');
		$admins = db('admin')->field('status')->find($id);
		$status = $admins['status'];
		if ($status == 1 ){
			db('admin')->where(array('id'=>$id))->update(['status' =>0]);
		}else{
			db('admin')->where(array('id'=>$id))->update(['status' =>1]);

		}
	}

	//退出登入
	public function logout(){
		session(null);
		$this->success('退出成功','Login/index');
	}

}
