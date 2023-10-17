<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class CategoryWords  extends Common //继承 控制类
{   //关联词列表
  public function lst()
  {
    //paginate是分页, 进行连表操作:给category_words取别名 cw ，连接category表(取别名为 c)关联的条件:cw.category_id=c.id,field()里面是限制的条件
    $cwRes = db('category_words')->field('cw.*,c.cate_name')->alias('cw')->join('category c',"cw.category_id=c.id")->order('id DESC')->paginate(4);
    $this->assign(
      [
        'cwRes' => $cwRes,
      ]
    );
    return view('list');
  }

  //关联词添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在关联词地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'] , 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }

      //验证
      $validate=validate('CategoryWodes');
      if(!$validate->check($data)){
        $this->error($validate->getError());
        }


      $add = db('category_words')->insert($data); //添加方式语句
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加关联词成功！', 'lst');
      } else {
        $this->error('添加关联词失败！');
      }
      return;
    }
	//获取顶级栏目(因在在category模板中以及获取了顶级栏目)
	$cateRes = model('Category')->where(array('pid'=>0))->select();
	//分配到模板中
	$this->assign([
		'cateRes' => $cateRes,
	]);
    return view();
  }

	//关联词编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在关联词地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'] , 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }

      //验证
      $validate=validate('CategoryWodes');
      if(!$validate->check($data)){
        $this->error($validate->getError());
        }


      $save = db('category_words')->update($data); //更新
      if ($save !== false) {
        //添加成功有提示也跳转到lst界面
        $this->success('修改关联词成功！', 'lst');
      } else {
        $this->error('修改关联词失败！');
      }
      return;
    }
	//获取顶级栏目(因在在category模板中以及获取了顶级栏目)
	$cateRes = model('Category')->where(array('pid'=>0))->select();
	$categoryWords = db('category_words')->find(input('id'));
	//分配到模板中
	$this->assign([
		'cateRes' => $cateRes,
		'categoryWords' => $categoryWords
	]);
    return view();
  }




  //关联词删除 帮定他id
  public function del($id)
  {
    $linkObj=db('category_words');
    //绑定数据库表使用tp5里的方法删除
    $del = $linkObj->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除关联词成功！', 'lst');
    } else {
      $this->error('删除关联词失败！');
    }
  }



}
