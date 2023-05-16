<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Brand  extends Controller //继承 控制类
{   //品牌列表
  public function lst()
  {
    //paginate是分页
    $brandRes = db('brand')->order('id DESC')->paginate(10); 
    $this->assign(
      [
        'brandRes' => $brandRes,
      ]
    );
    return view('list');
  }

  //品牌添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据

      //在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['brand_url'] && stripos($data['brand_url'] , 'http://') === false) {
        $data['brand_url'] = 'http://' . $data['brand_url'];
      }
      // if(strpos($data['brand_img'],'logo') ===false)
      //   {
      //   $data['brand_img']='无图片';
      //   }
      $data['brand_img'] = '无logo';
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['brand_img']['tmp_name']) {
        $data['brand_img'] = $this->upload();
      } else {
        $data['brand_img'] = '无图片';
      }
      //验证
      $validate=validate('brand');
      if(!$validate->check($data)){
        $this->error($validate->getError());
        }
        

      $add = db('brand')->insert($data); //添加方式语句  
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加品牌成功！', 'lst');
      } else {
        $this->error('添加品牌失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    return view();
  }

  //品牌编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['brand_url'] && stripos($data['brand_url'] , 'http://') === false) {
        $data['brand_url'] = 'http://' . $data['brand_url'];
      }
      // if(strpos($data['brand_img'],'logo') ===false)
      //   {
      //   $data['brand_img']='无图片';
      //   }
      $data['brand_img'] = '无logo';
      //处理好图片之后 没图片就不执行上传图片方法
      //处理上传图片
      if ($_FILES['brand_img']['tmp_name'])
      {
        //获取选中主键id里的brand_img旧图
      $oidBrands=db('brand')->field('brand_img')->find($data['id']); 
// 获取旧图地 ，定一个常量然后在拼装上$oidBrands['brand_img']旧图地址，就可以进行删除操作
      $oidBrandImg=IMG_UPLOADS.$oidBrands['brand_img'];
      //进行删除操作
      if(file_exists($oidBrandImg)){
        //易错符
        @unlink($oidBrandImg);

      }
        $data['brand_img'] = $this->upload();
      } else {
        $data['brand_img'] = '无图片';
      }

      $save = db('brand')->update($data); //修改方式语句  
      if ($save !==false) { //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改品牌成功！', 'lst');
      } else {
        $this->error('修改品牌失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $brands = db('brand')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'brands' => $brands,
      ]
    );
    return view();
  }


  //品牌删除 帮定他id
  public function del($id)
  {
    //绑定数据库表使用tp5里的方法删除
    $del = db('brand')->delete($id);
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
