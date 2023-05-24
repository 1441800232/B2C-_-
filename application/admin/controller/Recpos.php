<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Recpos  extends Controller //继承 控制类
{   //推荐位列表
  public function lst()
  {
      //连表查询
      $recposRes = db('rec_pos')->paginate(10);

    //paginate是分页
//    $recposRes = db('recpos')->alias('a')->
//    field('a.*,t.type_name')->
//    join('type t',"a.type_id =t t.id")->
//    where(array('type_id'=>$typeId))->
//    order('id DESC')->paginate(10);
    $this->assign(
      [
        'recposRes' => $recposRes,
      ]
    );
    return view('list');
  }

  //推荐位添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
     
      //验证操作
//      $validate=validate('Recpos');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }
        

      $add = db('rec_pos')->insert($data); //添加方式语句
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加推荐位成功！', 'lst');
      } else {
        $this->error('添加推荐位失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    //获取属性的所属类型——获取type里面的类型


    return view();
  }

  //推荐位编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据

        $save = db('rec_pos')->update($data); //修改方式语句
        //验证操作

//        $validate=validate('Recpos');
//        if(!$validate->check($data)){
//            $this->error($validate->getError());
//        }

        
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改推荐位成功！', 'lst');
      } else {
        $this->error('修改推荐位失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $recpos = db('rec_pos')->find($id); //把这条记录查询查询出来

    $this->assign( //查询好分配出去

      [
        'recpos' => $recpos,
      ]
    );
    return view();
  }


  //推荐位删除 帮定他id
  public function del($id)
  {
    //绑定数据库表使用tp5里的方法删除
    $del = db('rec_pos')->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除推荐位成功！', 'lst');
    } else {
      $this->error('删除推荐位失败！');
    }
  }

// //异步获取 指定类型下的属性
//    public  function ajaxGetrecpos(){
//      $typeId = input('type_id');
//      $recposRes = db('recpos')->where(array('type_id'=>$typeId))->select();
//      echo json_encode($recposRes); //发送的方式也要用json
//    }



}
