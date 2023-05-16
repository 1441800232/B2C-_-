<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Nav  extends Controller //继承 控制类
{   //品牌列表
	public function lst()
	{
		$nav = db('nav');
		//排序
		if(request()->isPost()){
			$data = input('post.');
			//dump($data);die();
			foreach ($data['sort'] as $k => $v){
				$nav->where('id', '=', $k)->update(['sort' => $v]);

			}
			$this->success('排序成功');
		}
		//paginate是分页
		$navRes = $nav->order('sort DESC')->paginate(10);
		$this->assign(
			[
				'navRes' => $navRes,
			]
		);
		return view('list');
	}

	//品牌添加
	public function add()
	{
		//判断是不是post的提交过来的
		if (request()->isPost()) {
			$data = input('post.'); //接受数据

			//在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
			if ($data['nav_url'] && stripos($data['nav_url'] , 'http://') === false) {
				$data['nav_url'] = 'http://' . $data['nav_url'];
			}
			// if(strpos($data['nav_img'],'logo') ===false)
			//   {
			//   $data['nav_img']='无图片';
			//   }
//			$data['nav_img'] = '无logo';
			//处理好图片之后 没图片就不执行上传图片方法
			//处理上传图片
//			if ($_FILES['nav_img']['tmp_name']) {
//				$data['nav_img'] = $this->upload();
//			} else {
//				$data['nav_img'] = '无图片';
//			}
			//验证
			$validate=validate('Nav');
			if(!$validate->check($data)){
				$this->error($validate->getError());
			}


			$add = db('nav')->insert($data); //添加方式语句
			if ($add) {
				//添加成功有提示也跳转到lst界面
				$this->success('添加导航成功！', 'lst');
			} else {
				$this->error('添加导航失败！');
			}
			// dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
			// dump($data);
			return;
		}
		return view();
	}

	//品牌编辑
	public function edit()
	{
		//判断是不是post的提交过来的
		if (request()->isPost()) {
			$data = input('post.'); //接受数据
			//在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
			if ($data['nav_url'] && stripos($data['nav_url'] , 'http://') === false) {
				$data['nav_url'] = 'http://' . $data['nav_url'] ;
			}
//			$validate=validate('Nav');
//			if(!$validate->check($data)){
//				$this->error($validate->getError());
//			}
			// if(strpos($data['nav_img'],'logo') ===false)
			//   {
			//   $data['nav_img']='无图片';
			//   }

			//处理好图片之后 没图片就不执行上传图片方法
			//处理上传图片


			$save = db('nav')->update($data); //修改方式语句
			if ($save !==false) { //如果不等于false那就是 成功 等于就失败
				//添加成功有提示也跳转到lst界面
				$this->success('修改品牌成功！', 'lst');
			} else {
				$this->error('修改品牌失败！');
			}
			// dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
			// dump($data);
			return;
		}
		$id = input('id'); //把id传递过来之后在用input接收这个id

		$navs = db('nav')->find($id); //把这条记录查询查询出来
		$this->assign( //查询好分配出去
			[
				'navs' => $navs,
			]
		);
		return view();
	}


	//品牌删除 帮定他id
	public function del($id)
	{
		//绑定数据库表使用tp5里的方法删除
		$del = db('nav')->delete($id);
		if ($del) {
			//添加成功有提示也跳转到lst界面
			$this->success('删除品牌成功！', 'lst');
		} else {
			$this->error('删除品牌失败！');
		}
	}






	//上传图片功能  tp 手册里
	public function upload()
	{
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file('nav_img');
		// 移动到框架应用根目录/public/uploads/ 目录下
		if ($file) {
			$info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
			if ($info) {
				return $info->getSaveName();
			} else {
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
	}
}
