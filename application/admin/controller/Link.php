<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Link  extends Controller //继承 控制类
{   //链接列表
  public function lst()
  {
    //paginate是分页
    $linkRes = db('link')->order('id DESC')->paginate(4);
    $this->assign(
      [
        'linkRes' => $linkRes,
      ]
    );
    return view('list');
  }

  //链接添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在链接地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'] , 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }
      // if(strpos($data['link_img'],'logo') ===false)
      //   {
      //   $data['link_img']='无图片';
      //   }
      $data['link_logo'] = '无logo';
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['link_logo']['tmp_name']) {
        $data['link_logo'] = $this->upload();
      } else {
        $data['link_logo'] = '无图片';
      }
      //验证
//      $validate=validate('link');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }
        

      $add = db('link')->insert($data); //添加方式语句  
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加链接成功！', 'lst');
      } else {
        $this->error('添加链接失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    return view();
  }

  //链接编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在链接地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['link_url'] && stripos($data['link_url'] , 'http://') === false) {
        $data['link_url'] = 'http://' . $data['link_url'];
      }
      // if(strpos($data['link_img'],'logo') ===false)
      //   {
      //   $data['link_img']='无图片';
      //   }
      $data['link_logo'] = '无logo';
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['link_logo']['tmp_name']) {
        //获取选中主键id里的link_logo旧图
        $oidlinks = db('link')->field('link_logo')->find($data['id']);
      // 获取旧图地 ，定一个常量然后在拼装上$oidlinks['link_img']旧图地址，就可以进行删除操作
        $oidlinkImg = IMG_UPLOADS.$oidlinks['link_logo'];
        if (file_exists($oidlinkImg)){
            @unlink($oidlinkImg);
        }
      //进行删除操作
        $data['link_logo'] = $this->upload();
      } else {
        $data['link_logo'] = '无图片';
      }

      $save = db('link')->update($data); //修改方式语句  
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改链接成功！', 'lst');
      } else {
        $this->error('修改链接失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $links = db('link')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'links' => $links,
      ]
    );
    return view();
  }


  //链接删除 帮定他id
  public function del($id)
  {
    $linkObj=db('link');
    $links=$linkObj->field('link_logo')->find($id);
    if ($links['link_logo']){
        $linkImg=IMG_UPLOADS.$links['link_logo'];
        if(file_exists($linkImg)){
            @unlink($linkImg);
        }
    }
    //绑定数据库表使用tp5里的方法删除
    $del = $linkObj->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除链接成功！', 'lst');
    } else {
      $this->error('删除链接失败！');
    }
  }





  
  //上传图片功能  tp 手册里
  public function upload()
  {
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('link_logo');
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
