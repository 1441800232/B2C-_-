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

class AuthRule extends Common
{
	public  function lst(){
		$ruleRes =db('authRule')->select();
		$ruleTree = model('AuthRule')->ruletree($ruleRes);
		$this->assign([
			'ruleTree' => $ruleTree,
		]);
		return view('list');

	}

	public function add(){
		if (request()->isPost()){
			$data = input('post.');
			$add = db('authRule')->insert($data);
			if ($add){
				$this->success('添加规则成功','lst');
			}else{
				$this->error('添加规则失败！');
			}
			return ;
		}
		//调用子规则
		$ruleRes =db('authRule')->select();
		$ruleTree = model('AuthRule')->ruletree($ruleRes);
		$this->assign([
			'ruleTree' => $ruleTree,
		]);
		return view('add');
	}

	public  function edit(){
		if (request()->isPost()){
			$data= input('post.');
			$save= db('authRule')->update($data);
			if ($save !==false){
				$this->success('修改规则成功','lst');
			}else{
				$this->error('修改规则失败！');
			}


			return ;
		}

		$id=input('id');
		$rules=db('authRule')->find($id);
		$ruleRes =db('authRule')->select();
		$ruleTree = model('AuthRule')->ruletree($ruleRes);
		$this->assign([
			'ruleTree' => $ruleTree,
			'rules' => $rules
		]);
		return view('edit');
	}


	public function del($id){
		//拿到全部的子栏目
		$cid =model('AuthRule')->childrenids($id);
		$cid[]=$id;
		$del= db('authRule')->delete($cid);
		if ($del){
			$this->success('删除成功','lst');
		}else{
			$this->error('删除失败');
		}
	}

	///栏目伸缩状态
	public function  ajxlst() {
		if (request()->isAjax()){
			$ruleid =  input('ruleid');
			$sonids = model('AuthRule')->childrenids($ruleid);
			echo json_encode($sonids);
		}else{
			$this->error('非法操作！');
		}
	}

}