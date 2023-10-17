<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class CategoryBrands  extends Common //继承 控制类
{   //关联品牌列表
  public function lst()
  {

    //paginate是分页,连表为了取得主栏目的名称
	//使用db函数连接数据库，并指定查询表名为categoryBrands。
	//使用field函数选择要查询的字段，包括categoryBrands表的所有字段，以及category表中的cate_name字段和brand表中的brand_name字段。
	//使用alias函数给categoryBrands表指定别名为cb，并使用join函数分别连接category表和brand表，
	//同时使用find_in_set函数将categoryBrands表中的brands_id字段与brand表中的id字段进行匹配查询出对应的品牌名称。
	//使用order函数按照id字段降序排序。
	//用group函数按照id字段分组，并使用GROUP_CONCAT函数将brand_name字段合并为一个字符串。
	//使用paginate函数进行分页处理，每页显示6条记录。
    $cbRes = db('categoryBrands')->field('cb.*,c.cate_name,GROUP_CONCAT(b.brand_name) brand_name')->alias('cb')->join('category c','cb.category_id=c.id')->join('brand b',"find_in_set(b.id,cb.brands_id)",'LEFT')->order('id DESC')->group('cb.id')->paginate(6);
    $this->assign(
      [
        'cdRes' => $cbRes,
      ]
    );
    return view('list');
  }

  //关联品牌添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //在关联品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
      if ($data['pro_url'] && stripos($data['pro_url'] , 'http://') === false) {
        $data['pro_url'] = 'http://' . $data['pro_url'];
      }

      if ($_FILES['pro_img']['tmp_name']) {
        $data['pro_img']=$this->upload();
      }
      //验证
//      $validate=validate('link');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }
	  if (isset($data['brands_id'])){
		  $data['brands_id']=implode(',', $data['brands_id']);
	  }
      $add = db('categoryBrands')->insert($data); //添加方式语句
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加关联品牌成功！', 'lst');
      } else {
        $this->error('添加关联品牌失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
	  //获取所有品牌信息,要求所有品牌logo
	  $brandRes=db('brand')->where('brand_img','NEQ','')->select();
	  //获取所有顶级栏目(因在在category模板中以及获取了顶级栏目)
	  $cateRes = model('Category')->where(array('pid'=>0))->select();
	  //分配到模板中
	  $this->assign([
		  'cateRes' => $cateRes,
		  'brandRes' => $brandRes,
	  ]);
    return view();
  }

  //关联品牌编辑
	public function edit()
	{
		//当前记录信息(获取当前栏目的id)
		$categoryBrands = db('categoryBrands')->find(input('id'));
		//判断是不是post的提交过来的
		if (request()->isPost()) {
			$data = input('post.'); //接受数据
			//在关联品牌地址前面加上http://方法  stripos 会区分大小strpos不区分大小写
			if ($data['pro_url'] && stripos($data['pro_url'] , 'http://') === false) {
				$data['pro_url'] = 'http://' . $data['pro_url'];
			}
			//处理图片上传

			if ($_FILES['pro_img']['tmp_name']) {
				//如果又原图会先把原图删除
				if ($categoryBrands['pro_img']){
					$proImg=IMG_UPLOAD.$categoryBrands['pro_img'];
					if(file_exists($proImg)){
						@unlink($proImg);
					}
				}
				$data['pro_img']=$this->upload();
			}

			//验证
//      $validate=validate('link');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }
			if (isset($data['brands_id'])){
				$data['brands_id']=implode(',',$data['brands_id']);
			}else{
				$data['brands_id']='';
			}

			$add = db('categoryBrands')->update($data); //修改方式语句
			if ($add) {
				//添加成功有提示也跳转到lst界面
				$this->success('修改关联品牌成功！', 'lst');
			} else {
				$this->error('修改关联品牌失败！');
			}
			// dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
			// dump($data);
			return;
		}
		//获取所有品牌信息,要求所有品牌logo
		$brandRes=db('brand')->where('brand_img','NEQ','')->select();
		//获取所有顶级栏目(因在在category模板中以及获取了顶级栏目)
		$cateRes = model('Category')->where(array('pid'=>0))->select();

		//分配到模板中
		$this->assign([
			'cateRes' => $cateRes,
			'brandRes' => $brandRes,
			'categoryBrands' => $categoryBrands
		]);
		return view();
	}


  //关联品牌删除 帮定他id
  public function del($id)
  {
    $cbObj=db('categoryBrands');
    $pro=$cbObj->field('pro_img')->find($id);
    if ($pro['pro_img']){
        $proImg=IMG_UPLOAD.$pro['pro_img'];
        if(file_exists($proImg)){
            @unlink($proImg);
        }
    }
    //绑定数据库表使用tp5里的方法删除
    $del = $cbObj->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除关联品牌成功！', 'lst');
    } else {
      $this->error('删除关联品牌失败！');
    }
  }






  //上传图片功能  tp 手册里
  public function upload()
  {
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('pro_img');
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
