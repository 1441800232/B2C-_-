<?php
// +----------------------------------------------------------------------
// | Name
// +---------------------------------------------------------------------

// | Author: B2C
//
// +----------------------------------------------------------------------
// | Version: V1
// +----------------------------------------------------------------------

/**
 * @Name
 * @Description
 * @Auther 西安咪乐多软件
 * @Date 2023/10/12 16:11
 */

namespace app\admin\controller;

class AuthGroup extends Common
{
	public function lst(){
		$authGroupRes =db('authGroup')->paginate(8);

		$this->assign([
			'authGroupRes' => $authGroupRes,
		]);
		return view('list');
	}

	public function add(){
		if (request()->isPost()){
			$data = input('post.');
			$add = db('authGroup')->insert($data);
			if ($add){
				$this->success('用户组添加成功','lst');
			}else{
				$this->error('添加用户组失败！');
			}
			return ;
		}
		return view('add');
	}

	public function edit(){
		if(request()->isPost()){
			$data=input('post.');
			$save = db('authGroup')->update($data);
			if ($save !==false){
				$this->success('修改用户组成功','lst');
			}else{
				$this->error('修改用户组失败！');
			}
			return ;

		}
		$id=input('id');
		$authGroups= db('authGroup')->find($id);
		$this->assign([
			'authGroups' => $authGroups,
		]);
		return view();
	}

	public function del($id){
		$del= db('authGroup')->delete($id);
		if ($del){
			$this->success('删除成功','lst');
		}else{
			$this->error('删除失败');
		}
		return view();
	}

	//ajax修改管理员状态
	public function changestasus(){
		$id = input('id');
		$authGroups = db('authGroup')->field('status')->find($id);
		$status = $authGroups['status'];
		if ($status == 1 ){
			db('authGroup')->where(array('id'=>$id))->update(['status' =>0]);
		}else{
			db('authGroup')->where(array('id'=>$id))->update(['status' =>1]);

		}
	}


}