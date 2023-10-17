<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Attr   extends Common //继承 控制类
{   //商品类型列表
  public function lst()
  {
	  //连表操作
   $typeId = input('type_id'); //是类型的id
    if ($typeId){
        $map['type_id']=['=',$typeId];
    }  else{
        $map=1;
    }

      //连表查询
      $attrRes = db('attr')->alias('a')->field('a.*,t.type_name')->join('type t',"a.type_id =t.id")->
      where($map)->order('id DESC')->paginate(10);

    //paginate是分页
//    $attrRes = db('attr')->alias('a')->
//    field('a.*,t.type_name')->
//    join('type t',"a.type_id =t t.id")->
//    where(array('type_id'=>$typeId))->
//    order('id DESC')->paginate(10);
    $this->assign(
      [
        'attrRes' => $attrRes,
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
      $data['attr_values'] = str_replace('，',',',$data['attr_values']);
      //验证操作
      $validate=validate('attr');
      if(!$validate->check($data)){
        $this->error($validate->getError());
        }
        

      $add = db('attr')->insert($data); //添加方式语句  
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
    //获取属性的所属类型——获取type里面的类型
      $typeRes=db('type')->select();
    $this->assign([
        'typeRes'=>$typeRes,
    ]);

    return view();
  }

  //商品类型编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
        $data['attr_values'] = str_replace('，',',',$data['attr_values']);
        $save = db('attr')->update($data); //修改方式语句
        //验证操作

        $validate=validate('attr');
        if(!$validate->check($data)){
            $this->error($validate->getError());
        }

        
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
    
    $attrs = db('attr')->find($id); //把这条记录查询查询出来

     //   //获取属性的所属类型——获取type里面的类型
    $typeRes=db('type')->select();
    $this->assign( //查询好分配出去

      [
        'attrs' => $attrs,
        'typeRes'=>$typeRes,
      ]
    );
    return view();
  }


  //商品类型删除 帮定他id
  public function del($id)
  {
    //绑定数据库表使用tp5里的方法删除
    $del = db('attr')->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除商品类型成功！', 'lst');
    } else {
      $this->error('删除商品类型失败！');
    }
  }

 //异步获取 指定类型下的属性
    public  function ajaxGetAttr(){
      $typeId = input('type_id');
      $attrRes = db('attr')->where(array('type_id'=>$typeId))->select();
      echo json_encode($attrRes); //发送的方式也要用json
    }



}
