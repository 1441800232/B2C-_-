<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;
//引入无线分级类
use catetree\Catetree;
 //继承 控制类
class article  extends Controller
{   //文章列表
  public function lst()
  {
    
//    //paginate是分页
//    /**alias('a') 给当前的文章表取一个别名：a；当前文章表名为：article
//     * join('cate c',"a.cate_id=c.id")  join是进行定义一个连接关系的函数，要连接的表是cate表，给他定义一个别名为：c
//     * 里面的a.cate_id=c.id 这他们的关联条件
//     * 目的是取出当前栏目对应的名称的  field（'a.*'）是获取a表的所有字段 ，article表的别名就是a
//     * c.cate_name 是c表里面的cate_name字段
//     * order('a.id DES') 意思定义a里的id ,DES表示升序
//     * **/
    $artRes = db('article')->field('a.*,c.cate_name')->alias('a')->join('cate c',"a.cate_id=c.id")->order('a.id DESC')->paginate(10);
     $this->assign(
      [
        'artRes' => $artRes,
      ]
    );
   return view('list');
  }

  //文章添加
  public function add()
  { 
    //实例化Catetree无线分级类方法
    $cate= new Catetree();
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      $data['addtime']=time();
      //在文章地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'], 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }
      // if(strpos($data['article_img'],'logo') ===false)
      //   {
      //   $data['article_img']='无图片';
      //   }
     
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['thumb']['tmp_name']) {
        $data['thumb'] = $this->upload();
      } 
      else {
        $data['thumb'] = '无图片';
      }
      //验证
      // $validate = validate('article');
      // if (!$validate->check($data)) {
      //   $this->error($validate->getError());
      // }


      $add = db('article')->insert($data); //添加方式语句  
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加文章成功！', 'lst');
      } else {
        $this->error('添加文章失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $cate= new Catetree();
    $cateRes=db('cate')->order('sort ASC')->select();
    $cateRes=$cate->catetree($cateRes);
    $this->assign([
         'cateRes'=>$cateRes,
    ]);
    return view();
  }

  //文章编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在文章地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'], 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }
      // if(strpos($data['article_img'],'logo') ===false)
      //   {
      //   $data['article_img']='无图片';
      //   }
 
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['thumb']['tmp_name']) {
        //获取选中主键id里的article_img旧图
        $oidarticles = db('article')->field('thumb')->find($data['id']);
        // 获取旧图地 ，定一个常量然后在拼装上$oidarticles['article_img']旧图地址，就可以进行删除操作
        $oidarticleImg = IMG_UPS . $oidarticles['thumb'];
        //进行删除操作
        if (file_exists($oidarticleImg)) {
          //易错符
          @unlink($oidarticleImg);
        }
        $data['thumb'] = $this->upload();
      } else {
        $data['thumb'] = '无图片';
      }

      $save = db('article')->update($data); //修改方式语句  
      if ($save !== false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改文章成功！', 'lst');
      } else {
        $this->error('修改文章失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    $cate= new Catetree();
    $cateRes=db('cate')->order('sort ASC')->select();
    $cateRes=$cate->catetree($cateRes);


    $arts = db('article')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'arts' => $arts,
        'cateRes'=> $cateRes,
      ]
    );
    return view();
  }


  //文章删除 帮定他id
  public function del($id)
  {
    $article=db('article');
    $arts=$article->field('thumb')->find($id);
    $thumbSrc = IMG_UP.$arts['thumb']; //如果这个图片存在就删除不在就不删除
    if (file_exists($thumbSrc)) {
      //易错符
      @unlink($thumbSrc); 
    }
    //绑定数据库表使用tp5里的方法删除
    $del = $article->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除文章成功！', 'lst');
    } else {
      $this->error('删除文章失败！');
    }
  }


  //ueditor图片管理模块  读取这个文件夹下面的ueditor的图片资源然后得到结果最后分配出去
    public  function  imglist(){
      $_files = my_scandir();
      //dump($_files);die();
      $files = array();//以数组的方式存储  二维数组
      foreach ($_files as $k => $v){
         //判断一下是否 是数组
          if (is_array ($v)){
              foreach ($v as $k1 => $v1){
                  //有几级文件夹就要嵌套几次循环
                  //UEDUITOR 和 HTTP_UEDITOP   是个给 图片的url地址定义了一个常量
                  $v1=str_replace(UEDITOR,HTTP_UEDITOR,$v1);
//                  dump($v1);die();
                  $files[]=$v1;
              }
          }
          else
          {
              $v=str_replace(UEDITOR,HTTP_UEDITOR,$v);
              $files[]=$v;
          }
      }
      //给前端页面 传输图片imgRes 和调用$files
      $this->assign([
         'imgRes'=>$files,
      ]);
      //dump($files);die();
      //通过一个函数 myscandir()函数dump($files);die();

      return view();

    }



    //图片管理的删除功能
    public  function  delimg(){
      $imgsrc=input('imgsrc');    //通过input接收到imglist里面的imgsrc的主键
      $imgsrc=DEL_UEDITOR.$imgsrc;
      if (file_exists($imgsrc)) {
         //易错符
          //echo 3是返回 图片不存在 对应imglist里面写的js的delimg方法里面的判断
         if (@unlink($imgsrc)){
             echo 1;  //删除成功
         }else{
             echo 2; //删除失败
         }
        }else{
          echo 3;  //echo 3是返回 图片不存在 对应imglist里面写的js的delimg方法里面的判断
      }
}



  //上传图片功能  tp 手册里
  public function upload()
  {
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('thumb');
    // 移动到框架应用根目录/public/uploads/ 目录下
    if ($file) 
    {
      $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
      if ($info) 
      {
        return $info->getSaveName();
      } 
      else
      {
        // 上传失败获取错误信息
        echo $file->getError();
      }
    }

  }
}
