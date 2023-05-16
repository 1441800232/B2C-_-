<?php
namespace app\admin\controller;
//引入系统数据库类
use think\Db;
//引入系统的控制器类
use think\Controller;

class Conf  extends Controller //继承 控制类
{

    //配置项
    public function  conflst()
    {


        $conf =	db('conf');
		if(request()->isPost())
		{
			$data = input('post.');

//			//复选框空选问题处理  只需要ename字段
			$checkFides2D = $conf->field('ename')->where(array('form_type'=>'checkbox'))->select();
			//			dump($_FILES);

//			//修改拼装为一维数组

//			//进行可能为空的判断
			$checkFides=array();
			if($checkFides2D){
				foreach ($checkFides2D as $k => $v){
					$checkFides[]=$v['ename'];
				}
			}
			//所送的字段组成的数组
			$allFiled=array();
//			// 处理文字数据
			foreach ($data as $k => $v){
				$allFiled[]=$k;
				//先判断你是否是复选 按钮
				if (is_array($v)){
					$value=implode(',',$v);
					$conf->where(array('ename'=>$k))->update(['value'=>$value]);
				}
				else{
					$conf->where(array('ename'=>$k))->update(['value'=>$v]);
				}

			}

//			//如果复选框中未有任何一个选项为 选择到，则设置值为空
			foreach ($checkFides as $k => $v){
				if (!in_array($v, $allFiled)){
					$conf->where(array('ename'=>$v))->update(['value'=>'']);

				}

			}
			if($_FILES){
				foreach ($_FILES as  $k => $v){
					if($v['tmp_name']){
					$imgs=$conf->field('value')->where(array('ename'=>$k))->find(
					);
					if ($imgs['value']){
						$o_img = IMG_UPLOAD.$imgs['value']; //如果这个图片存在就删除不在就不删除
						if (file_exists($o_img)) {
							//易错符
							@unlink($o_img);
						}
					}
					$imgSrc=$this->upload($k);
					$conf->where(array('ename'=>$k))->update(['value'=>$imgSrc]);
					}
				}
			}
			$this->success('配置成功');
			//处理图片数据


			//要给一个超级全局变量
//            dump($_FILES);
//            dump($data);die();

		}
        //ShopConfRes 网店配置
        $ShopConfRes =$conf->where(array('conf_type' => 1))->order('sort desc')->select();
        //GoodsConfRes 网店配置
        $GoodsConfRes =$conf->where(array('conf_type' => 2))->order('sort desc')->select();

        $this->assign(
            [
                'ShopConfRes' => $ShopConfRes,
                'GoodsConfRes' => $GoodsConfRes,
            ]
        );
        return view();
    }




    //配置列表
  public function lst()
  {
      //实例化这一下者数据表
      $conf = db('conf');
      //判断是不是post的提交过来的
      if (request()->isPost())
      {
          //接受post提交过来的数据
          $data = input('post.');
          //用一个循环，$data里面的sort是一个一维数组，$k是id，$v就是要修改的数值
          foreach ($data['sort'] as $k => $v)
          {
              //指向where指向update(修改的意思)要修改sort字段把值修改成$v里面的值
              $conf->where('id','=',$k)->update(['sort' => $v]);
          }
          $this->success('排序成功');

      }
    //paginate是分页
    $confRes = $conf->order('sort DESC')->paginate(8);
    $this->assign(
      [
        'confRes' =>  $confRes,
      ]
    );
    return view('list');
  }

  //配置添加
  public function add()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
      //进行如果判断:如果多选，可以替换中文的逗号“，”
      if($data['form_type'] == 'radio' || $data['form_type'] == 'select' ||$data['form_type'] == 'checkbox'  )  //如果这个“==”等于radio；“||” 或者
      {   //数据库定义的values （名称）默认值   value 可以选值
          //  str_replace是替换意思把中文逗号替换成英文逗号 在重新把值赋予给 默认值  可选值也是一样
          $data['values'] = str_replace('，',',',$data['values']);
          $data['value'] = str_replace('，',',',$data['value']);

      }


      //验证
      $validate=validate('conf');
      if(!$validate->check($data))
      {
        $this->error($validate->getError());
      }
        

      $add = db('conf')->insert($data); //添加方式语句  
      if ($add) {
        //添加成功有提示也跳转到lst界面
        $this->success('添加配置成功！', 'lst');
      } else {
        $this->error('添加配置失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    return view();
  }

  //配置编辑
  public function edit()
  {
    //判断是不是post的提交过来的
    if (request()->isPost()) {
      $data = input('post.'); //接受数据
        //进行如果判断:如果多选，可以替换中文的逗号“，”
        if($data['form_type'] == 'radio' || $data['form_type'] == 'select' ||$data['form_type'] == 'checkbox'  )  //如果这个“==”等于radio；“||” 或者
        {   //数据库定义的values （名称）默认值   value 可以选值
            //  str_replace是替换意思把中文逗号替换成英文逗号 在重新把值赋予给 默认值  可选值也是一样
            $data['values'] = str_replace('，',',',$data['values']);
            $data['value'] = str_replace('，',',',$data['value']);

        }
      $save = db('conf')->update($data); //修改方式语句  
      if ($save !==false) {
         //如果不等于false那就是 成功 等于就失败
        //添加成功有提示也跳转到lst界面
        $this->success('修改配置成功！', 'lst');
      } else {
        $this->error('修改配置失败！');
      }
      // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
      // dump($data);
      return;
    }
    $id = input('id'); //把id传递过来之后在用input接收这个id
    
    $confs = db('conf')->find($id); //把这条记录查询查询出来
    $this->assign( //查询好分配出去
      [
        'confs' => $confs,
      ]
    );
    return view();
  }


  //配置删除 帮定他id
  public function del($id)
  {
    //绑定数据库表使用tp5里的方法删除
    $del = db('conf')->delete($id);
    if ($del) {
      //添加成功有提示也跳转到lst界面
      $this->success('删除配置成功！', 'lst');
    } else {
      $this->error('删除配置失败！');
    }
  }

//上传图片功能  tp 手册里
    public function upload($imgName)
    {

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($imgName);
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




  
  //上传图片功能  tp 手册里
}
