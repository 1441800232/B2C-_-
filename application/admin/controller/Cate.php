<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;
use catetree\Catetree;

class Cate  extends Common //继承 控制类
{   //品牌列表
  public function lst()
  {
    $cate= new Catetree();
    $cateObj=db('cate');
    if(request()->isPost())
    {
      $data=input('post.');
      $cate->cateSort($data['sort'],$cateObj);
      $this->success('成功',url('lst'));
    }
    $cateRes=$cateObj->order('sort ASC')->select();
   
    $cateRes=$cate->catetree($cateRes);
    $this->assign([
         'cateRes'=>$cateRes,
    ]);

  
    return view('list');
  }

  //品牌添加
  public function add()
  {
    $cate= new Catetree();
    $cateObj=db('cate');
    //判断是不是post的提交过来的
    if (request()->isPost()) 
    {
      $data = input('post.'); //接受数据
      //在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      //验证
      $validate=validate('Cate');
      if(!$validate->check($data)){
        $this->error($validate->getError());
        }
      if(in_array($data['pid'],['1','48'])){
        $this->error('系统分类不能作为上级栏目');
      }

      if($data['pid']==48){
        $data['cate_type']=2;
      }

      $cateId = $cateObj->field('pid')->find($data['pid']);
      if($cateId==2)
      {
        $this->error('此分类不可以作为上级分类');
      }     
      $add =$cateObj->insert($data); //添加方式语句  
      if ($add) 
      {
        //添加成功有提示也跳转到lst界面
        $this->success('添加分类成功！', 'lst');
      } 
      else 
      {
        $this->error('添加分类失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $cateRes=$cateObj->order('sort ASC')->select();
   
    $cateRes=$cate->catetree($cateRes);
    $this->assign([
         'cateRes'=>$cateRes,
    ]);
    return view();
  }
  
  //品牌编辑
  public function edit()
  {
    $cate= new Catetree();
    $cateObj=db('cate');
    //判断是不是post的提交过来的
    if (request()->isPost()) 
    {
      $data = input('post.');
      $validate=validate('Cate');
      if(!$validate->check($data))
      {
        $this->error($validate->getError());
      } 
      //接受数据
      //在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
   
      // if(strpos($data['brand_img'],'logo') ===false)
      //   {
      //   $data['brand_img']='无图片';
      //   }
   
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
    
      $save = db('cate')->update($data); //修改方式语句  
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改品牌成功！' , 'lst');
      } 
      else 
      {
        $this->error('修改品牌失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    //当前栏目用cates来接收，把等到的id主键结果传递过来
    $cates=$cateObj->find(input('id'));
    //实例化
    $cateRes=$cateObj->order('sort ASC')->select();
    $cateRes=$cate->catetree($cateRes);
    $this->assign([
         'cateRes'=>$cateRes,
         'cates'=> $cates
    ]);
    return view();
  }


  //品牌删除 帮定他id
  public function del($id)
  {
    $cate=db('cate');
    $cateTree = new Catetree();
    $sonids=$cateTree->childrenids($id,$cate);
    $sonids[]=intval($id);
    $arr1=[1,16,5];
    $arrRes=array_intersect($arr1,$sonids);
    if($arrRes){
      $this->error('系统内置文章分类不允许删除！');

    }
    //删除分类前判断分类下的文章和文字相关的缩略图
    $article=db('article');
    foreach($sonids as $k =>$v){
      /****
      **fied是限定要查找的字段 
      **where是查询文章对应的cate_id的字段 
      **对应当前的$v字段
      ******/
       $artRes=$article->field('id,thumb')->where(array('cate_id'=>$v))->select();

       foreach( $artRes as $k1 =>$v1  ){
        /**
         *  把thumb的路径拼装出来
         * IMG_UPLOADS是他的常量
         */
        // $thumbSrc=IMG_UP.$v1['thumb'];
        // if (file_exists($thumbSrc)) {
        //   //易错符
        //   @unlink($thumbSrc);
        // }
        $article->delete($v1['id']);

       }


    }
        //绑定数据库表使用tp5里的方法删除 
    $del = db('cate')->delete($sonids);
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
    $file = request()->file('brand_img');
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
