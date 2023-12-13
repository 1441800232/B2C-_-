<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class AlternateImg  extends Common//继承 控制类
{   //轮播图列表
  public function lst()
  {
	  $alternateImg = \db('alternate_img');
	  //排序
	  if(request()->isPost()){
		  $data = input('post.');
		  //dump($data);die();
		  foreach ($data['sort'] as $k => $v){
			  $alternateImg->where('id', '=', $k)->update(['sort' => $v]);
		  }
		  $this->success('排序成功!');
	  }
    //paginate是分页
    $alternate_imgRes = $alternateImg->order('sort DESC')->paginate(10);
    $this->assign(
      [
        'alternate_imgRes' => $alternate_imgRes,
      ]
    );
    return view('list');
  }

  //轮播图添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据

      //在轮播图地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'] , 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }
      // if(strpos($data['img_src'],'logo') ===false)
      //   {
      //   $data['img_src']='无图片';
      //   }
      $data['img_src'] = '无logo';
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['img_src']['tmp_name']) {
        $data['img_src'] = $this->upload();
      } else {
        $data['img_src'] = '无图片';
      }
      //验证
//      $validate=validate('alternate_img');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }
        

      $add = db('alternate_img')->insert($data); //添加方式语句  
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加轮播图成功！', 'lst');
      } else {
        $this->error('添加轮播图失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    return view();
  }

  //轮播图编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在轮播图地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'] , 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }
      // if(strpos($data['img_src'],'logo') ===false)
      //   {
      //   $data['img_src']='无图片';
      //   }
      $data['img_src'] = '无logo';
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['img_src']['tmp_name'])
      {
        //获取选中主键id里的img_src旧图
      $oidalternate_imgs=db('alternate_img')->field('img_src')->find($data['id']);
// 获取旧图地 ，定一个常量然后在拼装上$oidalternate_imgs['img_src']旧图地址，就可以进行删除操作
      $oidalternate_imgImg=IMG_UPLOADS.$oidalternate_imgs['img_src'];
      //进行删除操作
      if(file_exists($oidalternate_imgImg)){
        //易错符
        @unlink($oidalternate_imgImg);

      }
        $data['img_src'] = $this->upload();
      } else {
        $data['img_src'] = '无图片';
      }

      $save = db('alternate_img')->update($data); //修改方式语句  
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改轮播图成功！', 'lst');
      } else {
        $this->error('修改轮播图失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $alternate_imgs = db('alternate_img')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'alternate_imgs' => $alternate_imgs,
      ]
    );
    return view();
  }


  //轮播图删除 帮定他id
  public function del($id)
  {

	  $alterImg=db('alternate_img')->field('img_src')->find($id);
	  // 获取旧图地 ，定一个常量然后在拼装上$oidBrands['brand_img']旧图地址，就可以进行删除操作
	  $imgSrc=IMG_UPLOADS.$alterImg['img_src'];
	  //进行删除操作
	  if(file_exists($imgSrc)){
		  //易错符
		  @unlink($imgSrc);

	  }
    //绑定数据库表使用tp5里的方法删除
    $del = db('alternate_img')->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除轮播图成功！', 'lst');
    } else {
      $this->error('删除轮播图失败！');
    }
  }

  //上传图片功能  tp 手册里
  public function upload()
  {
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('img_src');
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
