<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Type  extends Common //继承 控制类
{   //商品类型列表
  public function lst()
  {
    //paginate是分页
    $typeRes = db('type')->order('id DESC')->paginate(10); 
    $this->assign(
      [
        'typeRes' => $typeRes,
      ]
    );
    return view('list');
  }

  //商品类型添加
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
        

      $add = db('type')->insert($data); //添加方式语句  
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加商品类型成功！', 'lst');
      } else {
        $this->error('添加商品类型失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    return view();
  }

  //商品类型编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据


      $save = db('type')->update($data); //修改方式语句  
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改商品类型成功！', 'lst');
      } else {
        $this->error('修改商品类型失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $types = db('type')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'types' => $types,
      ]
    );
    return view();
  }


  //商品类型删除 帮定他id
  public function del($id)
  {
    //绑定数据库表使用tp5里的方法删除
    $del = db('type')->delete($id);
    //删除商品类型下面的商品属性
    db('attr')->where(array('type_id'=>$id))->delete();
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除商品类型成功！', 'lst');
    } else {
      $this->error('删除商品类型失败！');
    }
  }





}
