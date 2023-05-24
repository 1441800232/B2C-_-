<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;
use Catetree\Catetree;

class Category extends Controller //继承 控制类
{   //品牌列表
  public function lst()
  {
    $Category= new Catetree();
    $CategoryObj=db('Category');
    if(request()->isPost())
    {
      $data=input('post.');
      $Category->cateSort($data['sort'],$CategoryObj);
      $this->success('成功',url('lst'));
    }
    $CategoryRes=$CategoryObj->order('sort ASC')->select();

    $CategoryRes=$Category->Catetree($CategoryRes);
    $this->assign([
         'CategoryRes'=>$CategoryRes,
    ]);


    return view('list');
  }

  //品牌添加
  public function add()
  {
    //实例化无限极分类 对象
    $Category= new Catetree();
    //实例化数据对象
    $CategoryObj=model('Category');
    //判断是不是post的提交过来的
    if (request()->isPost())
    {
      $data = input('post.'); //接受数据
      //在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      //图片上传处理
        if ($_FILES['cate_img']['tmp_name']) {
            $data['cate_img'] = $this->upload();
        }
      $add =$CategoryObj->save($data); //添加方式语句
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
	  //商品分类推荐位
	$CategoryRecposRes = db('rec_pos')->where('rec_type','=',2)->select();
	  //当前商品分类相关数据推荐位,1就是必需是商品

    $CategoryRes=$CategoryObj->order('sort ASC')->select();

    $CategoryRes=$Category->Catetree($CategoryRes);
    $this->assign([
         'CategoryRes'=>$CategoryRes,
		'CategoryRecposRes'=>$CategoryRecposRes
    ]);
    return view();
  }

  //品牌编辑
  public function edit()
  {
    $Category= new Catetree();
    $CategoryObj = model('Category');
    //判断是不是post的提交过来的
    if (request()->isPost())
    {
      $data = input('post.');
        //图片上传处理 ，在修改前把图片上传过来
        if ($_FILES['cate_img']['tmp_name']) {
            $data['cate_img'] = $this->upload();

            //把旧的缩略图删除  field 是获取到的 cate_img
        $categorys =   $CategoryObj->field('cate_img')->find($data['id']);
        //如果categorys有值（图片）的话把他删除
        if($categorys['cate_img']){
            $imgSrc = IMG_UPLOADS.$categorys['cate_img'];
            //file_exists 是一个函数，中文名是检查文件或目录是否存在
            if (file_exists($imgSrc)){
                //unlink — 删除文件
                //这个@是php中的错误抑制符。⽐如当你要删除不存在的⽂件，正常使⽤unlink
                @unlink($imgSrc);
            }
        }
        }
      $save =$CategoryObj->update($data); //修改方式语句
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
    //当前栏目用Categorys来接收，把等到的id主键结果传递过来
    //实例化
	//商品分类推荐位
	  $goodsRecposRes = db('rec_pos')->where('rec_type','=',2)->select();
	  //当前商品相关数据推荐位,2就是必需是分类商品
	  $_myGoodsRecposRes = db('rec_item')->where(array('value_type'=>2,'value_id'=>input('id')))->select();
	  //把当前商品相关数据推荐位获取的数据改写成一维数组
	  $myGoodsRecposRes = array();
	  foreach ($_myGoodsRecposRes as $K => $v){//v就是代表的里的数据，只要把他的元素值取出来
		  $myGoodsRecposRes[]=$v['recpos_id'];
	  }
//	dump($_myCategoryRecposRes);die();
	//查询表 按照 asc 顺序排列
	$Categorys=$CategoryObj->find(input('id'));
	$CategoryRes=$CategoryObj->order('sort DESC')->select();
    $CategoryRes=$Category->Catetree($CategoryRes);
	//模板分配
    $this->assign([
         'CategoryRes'=>$CategoryRes,
         'Categorys'=> $Categorys,
		'goodsRecposRes' => $goodsRecposRes,
		'myGoodsRecposRes' => $myGoodsRecposRes,
    ]);
    return view();
  }


  //品牌删除 帮定他id
  public function del($id)
  {
    $Category=db('Category');
    $Catetree = new Catetree();
    $sonids=$Catetree->childrenids($id,$Category);
    $sonids[]=intval($id);

    //删除分类前判断分类下的文章和文字相关的缩略图
    $article=db('article');
//    foreach($sonids as $k =>$v){
//      /****
//      **fied是限定要查找的字段
//      **where是查询文章对应的Category_id的字段
//      **对应当前的$v字段
//      ******/
//       $artRes=$article->field('id,thumb')->where(array('Category_id'=>$v))->select();
//
//       foreach( $artRes as $k1 =>$v1  ){
//        /**
//         *  把thumb的路径拼装出来
//         * IMG_UPLOADS是他的常量
//         */
//        // $thumbSrc=IMG_UP.$v1['thumb'];
//        // if (file_exists($thumbSrc)) {
//        //   //易错符
//        //   @unlink($thumbSrc);
//        // }
//        $article->delete($v1['id']);
//
//       }
//
//
//    }
	$recItem=\db('recItem');
	//删除栏目前，检查并删除当前栏目的推荐信息
	foreach ($sonids as $k => $v) {
		$recItem->where(array('value_id'=>$v,'value_type'=>2))->delete();
	}
        //绑定数据库表使用tp5里的方法删除
    $del = db('Category')->delete($sonids);
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
    $file = request()->file('cate_img');
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
