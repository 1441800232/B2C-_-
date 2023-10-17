<?php

namespace app\admin\controller;
//引入系统数据库类
use think\Db;

//引入系统的控制器类
use think\Controller;

//引入共享控制器(第三方扩展类)
use catetree\Catetree;
use think\Model;

class Goods extends Common //继承 控制类
{   //商品类型列表
    public function lst()
    {
        //tp5 手册的JOIN方法也是连贯操作方法之一，用于根据两个或多个表中的列之间的关系，从这些表中查询数据，关联表（连表查询）
		//在tp5中的join  LEFT JOIN: 即使右表中没有匹配，也从左表返回所有的行 g是goods表的别名
		//关联category c的意思是给category表取一个别名 //条件就是goods 表的category_id 关联category表的id字段
		//关联brand b的意思是给brand表取一个别名 //条件就是goods 表的brand_id 关联brand表的id字段
		//关联type t的意思是给type表取一个别名//条件就是goods 表的type_id  表的id 关联type表的id字段
		////关联product p的意思是给product去一个别名 //条件就是goods 表的id 关联product表的goods_id字段
        //paginate是分页  alias 是个goods去一个别名 为g; // sum(p.goods_number)意思是求p表goods_number字段内容值的总和 ，定义一个名字为gn是给前端传递数据的值的
        //  group('g.id')可以让求和出来的值和对应的商品一一对应
		$join = [
			['category c','g.category_id=c.id','LEFT'],
			['brand b','g.brand_id=b.id','LEFT'],
			['type t','g.type_id=t.id','LEFT'],
			['product p','g.id=p.goods_id','LEFT'],
		];
        $goodsRes = db('goods')->alias('g')->field('g.*,c.cate_name,b.brand_name,t.type_name,SUM(p.goods_number) gn')->join($join)->group('g.id')->order('g.id DESC')->paginate(6);

//		$goodsRes=db('goods')->alias('g')->field('g.*,c.cate_name,b.brand_name,t.type_name,SUM(p.goods_number) gn')->join($join)->group('g.id')->order('g.id DESC')->paginate(6);
//		$goodsRess = db('goods')->select();

        $this->assign(
            [
                'goodsRes' => $goodsRes,
            ]
        );
        return view('list');

    }

    //商品类型添加
    public function add()
    {
        //判断是不是post的提交过来的
        if (request()->isPost()) {
            $data = input('post.'); //接受数据;
//      dump($data);die();

            //验证
//      $validate=validate('goods');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }


            $add = model('goods')->save($data); //添加方式语句
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
        //会员级别数据
        //调用查询会员表（memberLevel）里的id字段和level_name字段
        $mlRes = db('memberLevel')->field('id,level_name')->select();
        //分配都前端模板中  获取类型
        $typeRes = db('type')->select();
        //品牌分类
        $brandRes = db('brand')->field('id,brand_name')->select();//用field给他限定字段go
		//商品推荐位
		$goodsRecposRes = db('rec_pos')->where('rec_type','=',1)->select();
        //商品分类
        $Category = new Catetree();
        $CategoryObj = db('Category');
        $CategoryRes = $CategoryObj->order('sort ASC')->select();
        $CategoryRes = $Category->Catetree($CategoryRes);
        $this->assign([
            'mlRes' => $mlRes,
            'typeRes' => $typeRes,
            'brandRes' => $brandRes,
            'CategoryRes' => $CategoryRes,
			'goodsRecposRes'=> $goodsRecposRes,
        ]);
        return view();
    }

    //商品类型编辑
    public function edit()
    {
        //判断是不是post的提交过来的
        if (request()->isPost()) {
            $data = input('post.'); //接受数据;
//      dump($data);

            //验证
//      $validate=validate('goods');
//      if(!$validate->check($data)){
//        $this->error($validate->getError());
//        }


            $update = model('goods')->update($data); //添加方式语句
            if ($update) {
                //添加成功有提示也跳转到lst界面
                $this->success('修改商品类型成功！', 'lst');
            } else {
                $this->error('修改商品类型失败！');
            }
            // dump($_FILES);//通过 HTTP POST 方式上传到当前脚本的项目的数组
            // dump($data);
            return;
        }
        /**
         ** 取出连接
         * 对应表里面的需要的数据和值
         * */
        //接收商品的id(获取当前商品的id)
        $goodsId = input('id');
        //会员级别数据
        //调用查询会员表（memberLevel）里的id字段和level_name字段
        $mlRes = db('memberLevel')->field('id,level_name')->select();
        //分配都前端模板中  获取商品类型
        $typeRes = db('type')->select();
        //品牌分类
        $brandRes = db('brand')->field('id,brand_name')->select();//用field给他限定字段
        //商品分类
        $Category = new Catetree();
        //商品相册
        $gphotoRes = db('goods_photo')->where("goods_id", '=', $goodsId)->select();
        //商品的会员价格 // input 接收商品的id(获取当前商品的id) 获取单个变量 判断变量是否定义
        $_mpRes = db('member_price')->where('goods_id', '=', input('id'))->select();
        $mpRes = array();
        foreach ($_mpRes as $k => $v) {
            $mpRes[$v['mlevel_id']] = $v;
        }
        //查询当前商品基本信息
        $goods = db('goods')->find($goodsId); //查询单个数据使用 find 方法 返回一维数组
		//商品推荐位
		$goodsRecposRes = db('rec_pos')->where('rec_type','=',1)->select();
		//当前商品相关数据推荐位,1就是必需是商品
		$_myGoodsRecposRes = db('rec_item')->where(array('value_type'=>1,'value_id'=>$goodsId))->select();
		//把当前商品相关数据推荐位获取的数据改写成一维数组
		$myGoodsRecposRes = array();
		foreach ($_myGoodsRecposRes as $K => $v){//v就是代表的里的数据，只要把他的元素值取出来
			$myGoodsRecposRes[]=$v['recpos_id'];
		}
//		dump($myGoodsRecposRes);die();
        //查询当前商品拥有的商品属性的属性值 goods_attr
        $_gattrRes= db('goods_attr')->where('goods_id','=',$goodsId)->select();
//        dump($_gattrRes);die();
        //更改二维数组结构 改为三维数组结构(打散成 三维数组)
        $gattrRes = array();
        //打散成 三维数组
        foreach ($_gattrRes  as  $k => $v){
            $gattrRes[$v['attr_id']][] = $v;
        }
        //查询当前商品类型所有属性类型信息
        $attrRes = db('attr')->where('type_id', '=', $goods['type_id'])->select();
        //获取商品属性的无限级分类信息
        $CategoryObj = db('Category');
        $CategoryRes = $CategoryObj->order('sort ASC')->select();
        $CategoryRes = $Category->Catetree($CategoryRes);
        //把商品信息分配到模板当中，让前端可以获取到商品信息
        $this->assign([
            'mlRes' => $mlRes,
            'typeRes' => $typeRes,
            'brandRes' => $brandRes,
            'CategoryRes' => $CategoryRes,
            'goods' => $goods,
            'mpRes' => $mpRes,
            'gphotoRes' => $gphotoRes,
            'attrRes' => $attrRes,
            'gattrRes' => $gattrRes,
			'goodsRecposRes' => $goodsRecposRes,
			'myGoodsRecposRes' => $myGoodsRecposRes,
        ]);
        return view();
    }


    //商品类型删除 帮定他id
    public function del($id)
    {
        //绑定数据库表使用tp5里的方法删除,使用模型方法删除
        $del = model('goods')->destroy($id);// destroy支持批量删除多个数据 (可以批量删除)
        if ($del) {
            //添加成功有提示也跳转到lst界面
            $this->success('删除商品成功！', 'lst');
        } else {
            $this->error('删除商品失败！');
        }
    }


    //商品库存
    //接收商品的id
    public function inventory($id)
    {
        //如果你是post提交过来的数据， 我们在这处理提交的数据 而不是 加载页面
        if (request()->isPost()) {
            //修库存量直接接暴力修改 把之前的 全部数据删除在重新添加
            //    db('product')->where('goods_id','=',$id)->delete();//把原来删除掉 ，在进行重新添加一下
            db('product')->where('goods_id', '=', $id)->delete();
            $data = input('post.');
            $goodsAttr = $data['goods_attr'];
            $goodsNum = $data['goods_num'];
            $product = db('product');
            foreach ($goodsNum as $k => $v) {
                $strArr = array();
                foreach ($goodsAttr as $k1 => $v1) {
                    //判读如果有一条记录的id或值为空那么就不能让你进行传递（插入到数据表中）
                    if (intval($v1[$k]) <= 0) {
                        //continue在循环结构用用来跳过本次循环中剩余的代码并在条件求值为真时开始执行下一次循环(这里是跳出两级)
                        continue 2;
                    }
                    $strArr[] = $v1[$k];
                }
                sort($strArr);
                $strArr = implode(',', $strArr);
                $product->insert([
                    'goods_id' => $id,
                    'goods_number' => $v,
                    'goods_attr' => $strArr
                ]);
            }
            $this->success('修改库存成功!');
            return;

//           foreach ($goodsNum as $k => $v){
//               $strArr = array(); //把值放进来的地方
//               foreach ($goodsAttr as $k1 => $v1){
//                   $strArr[] = $v1[$k];//$goodsAttr （goods_attr）取出这个二位数组里面的两个元素的第一条记录 通过且套 ，第一条记入$k
//                   //$goodsAttr （goods_attr）
//               }
//               sort($strArr); //进行排序    对数组排序
//               $strArr=implode(',' , $strArr);//转换成字符串implode — 将一个一维数组的值转化为字符串
//               $product->insert([
//                   'goods_id' =>$id,
//                   'goods_number' =>$v,
//                   'goods_attr' => $strArr
//               ]);
//               $this->success('添加库存成功!');
//
//         }
//           dump($data);die();


        }

        //获取单选属性
        //根据这商品的id查找他的单选属性  select查找多条 where条件是goods_id 对应正在打开的商品 goods_attr 商品属性表
        //alias('g')是个goods_attr取了个别名为g  ,把g表拿去关联  join是关联表 ，关联到tp_attr表 在取了个别名为a ，他们的关联条件是g.attr_id = a.id
        //field是取一下他们对应的字段 :如 g表的里面的字段g.attr_id ，g.attr_value , g.id   a表的里面的字段：
        //where(array('g.goods_id'=>$id,'a.attr_type'=>1)) 只打开单选属性
        $_radioRes = db('goods_attr')->alias('g')->field('g.id,g.attr_id,g.attr_value,
          a.attr_name')->join("attr a", 'g.attr_id = a.id')->where(array('g.goods_id' => $id, 'a.attr_type' => 1))->select();
        $radioRes = array();
        //数组格式重组
        foreach ($_radioRes as $k => $v) {
            //把他变成三位数组
            $radioRes[$v['attr_name']][] = $v;
        }

        //获取商品的库存信息  这个id就是当前商品的id
        $goodsProRes = \db('product')->where('goods_id', '=', $id)->select();
//        dump($goodsProRes);die();
        //把数据（这个三位数组）分配出去
        $this->assign([
            //分配到模板当中
            'radioRes' => $radioRes,
            'goodsProRes' => $goodsProRes,
        ]);
//        dump($radioRes);die();
        return view();
    }

    //异步请求处理 删除商品相册图片
    public function ajaxdelpic($id)
    {//用参数绑定的方式来接收id id是对应数据里面的前端ajax发送过来的
        //获取对应数据库表
        $gphoto = db('goods_photo');
        //获取商品相册图片的数据获取id, 查询单个数据使用 find $id就是他对的条件
        $photo = $gphoto->find($id);
        //拼装商品相册图片路径//获取相册图片地址
        $ogPhoto = IMG_UPLOAD . $photo['og_photo'];
        $smPhoto = IMG_UPLOAD . $photo['sm_photo'];
        $midPhoto = IMG_UPLOAD . $photo['mid_photo'];
        $bigPhoto = IMG_UPLOAD . $photo['big_photo'];
        //对商品相册图片删除
        @unlink($ogPhoto);
        @unlink($smPhoto);
        @unlink($midPhoto);
        @unlink($bigPhoto);
        //删除商品相册图片对应的记录
        $delete = $gphoto->delete($id);
        if ($delete) {
            echo 1;
        } else {
            echo 2;
        }


    }


//    public  function  product($id)
//    {
//        //如果你是post提交过来的数据， 我们在这处理提交的数据 而不是 加载页面
//        if (request()->isPost()){
//
//            db('product')->where('goods_id','=',$id)->delete();
//            $data = input('post.');
//            $goodsAttr = $data['goods_attr'];
//            $goodsNum = $data['goods_num'];
//            $product = db('product');
//            foreach ($goodsNum as $k => $v){
//                $strArr = array();
//                foreach ($goodsAttr as $k1=>$v1){
//                    //判读如果有一条记录的id或值为空那么就不能让你进行传递（插入到数据表中）
//                    if(intval($v1[$k])<=0){
//                        //continue在循环结构用用来跳过本次循环中剩余的代码并在条件求值为真时开始执行下一次循环(这里是跳出两级)
//                        continue 2;
//                        $strArr[]=$v1[$k];
//                    }
//                    sort($strArr);
//                    $strArr= implode(',', $strArr);
//                    $product->insert([
//                        'goods_id' => $id,
//                        'goods_number'=>$v,
//                        'goods_attr' => $strArr
//                    ]);
//                }
//                $this->success('修改库存成功!');
//        }}
//    }


}
