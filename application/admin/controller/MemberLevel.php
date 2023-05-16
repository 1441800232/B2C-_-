<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class MemberLevel  extends Controller //继承 控制类
{   //会员级别列表
  public function lst()
  {
    //paginate是分页
    $mlRes = db('member_level')->order('id DESC')->paginate(10);
    $this->assign(
      [
        'mlRes' => $mlRes,
      ]
    );
    return view('list');
  }

  //会员级别添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据

      //验证
//      $validate=validate('type');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }


      $add = db('member_level')->insert($data); //添加方式语句
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加会员级别成功！', 'lst');
      } else {
        $this->error('添加会员级别失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    return view();
  }

  //会员级别编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据


      $save = db('member_level')->update($data); //修改方式语句
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改会员级别成功！', 'lst');
      } else {
        $this->error('修改会员级别失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $mls = db('member_level')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'mls' => $mls,
      ]
    );
    return view();
  }


  //会员级别删除 帮定他id
  public function del($id)
  {
    //绑定数据库表使用tp5里的方法删除
    $del = db('member_level')->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除会员级别成功！', 'lst');
    } else {
      $this->error('删除会员级别失败！');
    }
  }





}
