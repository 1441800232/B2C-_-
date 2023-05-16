<?php

namespace app\admin\model;
//引入系统模型类

use think\File;
use think\Model;
use think\Session;

class Goods extends Model //extends继承 控制类
{
    //制作得一个配置项 功能 把不存在的字段忽略掉
    protected $field = true;
    //手册里面模型方法
    //可以在模型类的init（就是不管是前还是后之类都可以方在这个方法里面起始载入程式）方法里面统一注册模型事件，例如：
    protected static function init()
    {
        //生成商品主图的三张缩略图
        Goods::beforeInsert(function ($goods) {  //goods当前类实例也是获取goods控制器
            //修改商品之前，如果有上传新的缩略图，先处理图片
            //如果是$ogThumb=$this->upload('og_thumb');那么就会出现下面情况
            //Using $this when not in object context
            //原因是在静态方法中使用$this或者直接调用非静态的方法。（也就是没this这个对象）
            if ($_FILES['og_thumb']['tmp_name']) {
                $thumbName = $goods->upload('og_thumb');
                //把图片以原图、 大图、中图、小图 4张图片存放
                $ogThumb = date("Ymd") . DS . $thumbName;  //原图 地址
                $bigThumb = date("Ymd") . DS . 'big_' . $thumbName;//大图地址
                $midThumb = date("Ymd") . DS . 'mid_' . $thumbName;//中图地址
                $smThumb = date("Ymd") . DS . 'sm_' . $thumbName;//小图地址
                $image = \think\Image::open(IMG_UPLOAD . $ogThumb);//原图 地址
                $image->thumb(500, 500)->save(IMG_UPLOAD . $bigThumb);//大图地址
                $image->thumb(200, 200)->save(IMG_UPLOAD . $midThumb);//中图地址
                $image->thumb(80, 80)->save(IMG_UPLOAD . $smThumb);//小图地址
                //把四类图片存放到数据库
                $goods->og_thumb = $ogThumb;
                $goods->big_thumb = $bigThumb;
                $goods->mid_thumb = $midThumb;
                $goods->sm_thumb = $smThumb;
//                unlink(IMG_UPLOAD.$ogThumb);//删除原图
            }
            $goods->goods_code = time() . rand(111111, 999999);//商品编号
//            dump($ogThumb);die();
        });

        //修改商品之前 的操作 （修改）
        Goods::beforeUpdate(function ($goods) {  //goods当前类实例也是获取goods控制器
            //商品的id接收
            //两个数组 传递过来的值上传
//            $goodsAttr = $goods->goods_attr; //对应前端商品属性值自己定义数组goods_attr
//            $goodsPrice = $goods->goods_price;//对应前端商品属性价格自己定义数组goods_price
            //利用数组嵌套进行设置
            $goodsID = $goods->id;
//            处理新增商品属性
            $goodsDate = input('post.');
//            dump($goodsDate);die();
            if (isset($goodsDate['goods_attr'])) {//isset — 检测变量是否已设置并且非 null
                $money = 0;//处理单选属性价格 （初始值）
                foreach ($goodsDate['goods_attr'] as $k => $v) {
                    if (is_array($v)) {//是否是数组
                        //如果数组里面有空值直接删除在上传到数据表里面
                        //$v = array_filter($v);//array_filter — 使用回调函数过滤数组的元素array
                        //要遍历的数组callback使用的回调函数
                        //如果没有提供 callback 回调函数，将删除数组中 array 的所有"空"元素。有关 PHP 如何判定"空"元素
//                        实现价格和属性值的的一一对应
                        if (!empty($v)) {  //$v就是嵌套数组的里面的嵌套的那个数组  //是否为空
                            foreach ($v as $k1 => $v1) {
                                //属性价格和属性值如果是 空值就不把空值上传，
                                if (!$v1) {//如果 $v1为空的话 那么就直接跳过这个值输出其他的值
                                    //如果等于那么就不输出这个值 输出其他的值
                                    $money++;
                                    continue;//continue 在循环结构用用来跳过本次循环中剩余的代码并在条件求值为真时开始执行下一次循环。
                                }
                                db('goods_attr')->insert(['attr_id' => $k, 'attr_value' => $v1, 'attr_price' => $goodsDate['attr_price'][$money], 'goods_id' => $goodsID,]);
                                $money++;
                            }
                        }
                    } else {
                        //处理唯一属性类型的值
                        db('goods_attr')->insert(['attr_id' => $k, 'attr_value' => $v, 'goods_id' => $goodsID]);

                    }
                }
            }

            //处理修改商品属性
            if (isset($goodsDate['old_goods_attr'])) {//isset — 检测变量是否已设置并且非 null
                $i= 0;//处理单选属性价格 （初始值）
                $attrPrice = $goodsDate['old_attr_price'];
                $idsArr = array_keys($attrPrice); // 返回数组中部分的或所有的键名（键名就是数组中的排序 0，1，2之类的)
                $valuesArr = array_values($attrPrice);//返回数组中所有的值 具体的价格属性
//                dump($idsArr);
//                dump($valuesArr);

                foreach ($goodsDate['old_goods_attr'] as $k => $v) {
                    if (is_array($v)) {//是否是数组
                        //如果数组里面有空值直接删除在上传到数据表里面
                        //$v = array_filter($v);//array_filter — 使用回调函数过滤数组的元素array
                        //要遍历的数组callback使用的回调函数
                        //如果没有提供 callback 回调函数，将删除数组中 array 的所有"空"元素。有关 PHP 如何判定"空"元素
//                        实现价格和属性值的的一一对应
                        if (!empty($v)){  //$v就是嵌套数组的里面的嵌套的那个数组  //是否为空
                            foreach ($v as $k1 => $v1) {
                                //属性价格和属性值如果是 空值就不把空值上传，
                                if (!$v1) {//如果 $v1为空的话 那么就直接跳过这个值输出其他的值
                                    //如果等于那么就不输出这个值 输出其他的值
                                    $i++;
                                    continue;//continue 在循环结构用用来跳过本次循环中剩余的代码并在条件求值为真时开始执行下一次循环。
                                }
                                //单选属性的修改
                                db('goods_attr')->where('id','=',$idsArr[$i])->update(['attr_value' => $v1,'attr_price' => $valuesArr[$i]]);
                                $i++;
                            }
                        }
                    } else {
                        //处理唯一属性类型修改的值
                        db('goods_attr')->where('id','=',$idsArr[$i])->update(['attr_value' => $v,'attr_price'=>$valuesArr[$i]]);
                        $i++;

                    }
                }
            }


            //商品相册处理
            if ($goods->_hasImgs($_FILES['goods_photo']['tmp_name'])) {//下面的两个数组 传递过来
                $files = request()->file('goods_photo');
                //tp5手册方法
                if (is_array($files) || is_object($files)) {
                    //is_object — 检测变量是否是一个对象 ，is_array — 检测变量是否是数组
                    foreach ($files as $file) {
                        // 移动到框架应用根目录/public/uploads/ 目录下
                        $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                        if ($info) {
                            // 输出 42a79759f284b767dfcb2a0197904287.jpg
                            $photoName = $info->getFilename();
                            $og_photo = date("Ymd") . DS . $photoName;  //原图 地址
                            $big_photo = date("Ymd") . DS . 'big_' . $photoName;//大图地址
                            $mid_photo = date("Ymd") . DS . 'mid_' . $photoName;//中图地址
                            $sm_photo = date("Ymd") . DS . 'sm_' . $photoName;//小图地址
                            $image = \think\Image::open(IMG_UPLOAD . $og_photo);//原图 地址
                            $image->thumb(500, 500)->save(IMG_UPLOAD . $big_photo);//大图地址
                            $image->thumb(200, 200)->save(IMG_UPLOAD . $mid_photo);//中图地址
                            $image->thumb(80, 80)->save(IMG_UPLOAD . $sm_photo);//小图地址
                            @unlink(IMG_UPLOAD . $og_photo);//删除原图 unlink — 删除文件(里面是路径)
                            db('goods_photo')->insert(['goods_id' => $goodsID, 'og_photo' => $og_photo, 'big_photo' => $big_photo, 'mid_photo' => $mid_photo,
                                'sm_photo' => $sm_photo]);
                        } else {
                            // 上传失败获取错误信息
                            echo $file->getError();
                        }
                    }
                }


            }


            //批量写人会员价格
//            dump($goods);die();
            //把会员价格数组拿出来 ， 在html界面设置了mp 是把会员价格放进去
            $mpricerArr = $goods->mp;

            $mp = db('member_price');
            /**在修改之前除了修改会员价格
             * 也就是暴力删除在添加
             **/
            //删除原有会员价格
            $mp->where('goods_id', '=', $goodsID)->delete();
            //这个数组进行循环 插入到 数据库里
            if ($mpricerArr) {  //如果不是一个空数组的话
                foreach ($mpricerArr as $K => $v) {//K指的是会员级别 v就是我们设定的会员价格
                    if (trim($v) == '') { //trim()   函数移除字符串两侧的空白字符或其他预定义字符。
                        continue;
                    } else {
                        $mp->insert(['mlevel_id' => $K, 'mprice' => $v, 'goods_id' => $goodsID]);
                    }

                }
            }

            //修改商品之前，如果有上传新的缩略图，先处理图片
            //如果是$ogThumb=$this->upload('og_thumb');那么就会出现下面情况
            //Using $this when not in object context
            //原因是在静态方法中使用$this或者直接调用非静态的方法。（也就是没this这个对象）
            if ($_FILES['og_thumb']['tmp_name']) {
                //如果存在就删除旧缩略图
                @unlink(IMG_UPLOAD . $goods->og_thumb);
                @unlink(IMG_UPLOAD . $goods->big_thumb);
                @unlink(IMG_UPLOAD . $goods->mid_thumb);
                @unlink(IMG_UPLOAD . $goods->sm_thumb);
                //上传新缩略图
                $thumbName = $goods->upload('og_thumb');
                //把图片以原图、 大图、中图、小图 4张图片存放
                $ogThumb = date("Ymd") . DS . $thumbName;  //原图 地址
                $bigThumb = date("Ymd") . DS . 'big_' . $thumbName;//大图地址
                $midThumb = date("Ymd") . DS . 'mid_' . $thumbName;//中图地址
                $smThumb = date("Ymd") . DS . 'sm_' . $thumbName;//小图地址
                $image = \think\Image::open(IMG_UPLOAD . $ogThumb);//原图 地址
                $image->thumb(500, 500)->save(IMG_UPLOAD . $bigThumb);//大图地址
                $image->thumb(200, 200)->save(IMG_UPLOAD . $midThumb);//中图地址
                $image->thumb(80, 80)->save(IMG_UPLOAD . $smThumb);//小图地址
                //把四类图片存放到数据库
                $goods->og_thumb = $ogThumb;
                $goods->big_thumb = $bigThumb;
                $goods->mid_thumb = $midThumb;
                $goods->sm_thumb = $smThumb;
//                unlink(IMG_UPLOAD.$ogThumb);//删除原图
            }
            $goods->goods_code = time() . rand(111111, 999999);//商品编号
//            dump($ogThumb);die();


        });


//            会员价格处理
        Goods::afterInsert(function ($goods) {
            //批量写人会员价格
//            dump($goods);die();
            //把会员价格数组拿出来 ， 在html界面设置了mp 是把会员价格放进去
            $mpricerArr = $goods->mp;
            $goodsID = $goods->id;
            //这个数组进行循环 插入到 数据库里
            if ($mpricerArr) {  //如果不是一个空数组的话
                foreach ($mpricerArr as $K => $v) {//K指的是会员级别 v就是我们设定的会员价格
                    if (trim($v) == '') { //trim()   函数移除字符串两侧的空白字符或其他预定义字符。
                        continue;
                    } else {
                        db('member_price')->insert(['mlevel_id' => $K, 'mprice' => $v, 'goods_id' => $goodsID]);
                    }

                }
            }


//           商品属性处理
            //两个数组 传递过来的值上传
//            $goodsAttr = $goods->goods_attr; //对应前端商品属性值自己定义数组goods_attr
//            $goodsPrice = $goods->goods_price;//对应前端商品属性价格自己定义数组goods_price
            //利用数组嵌套进行设置
            $goodsDate = input('post.');
            $money = 0;//处理单选属性价格 （初始值）
            if (isset($goodsDate['goods_attr'])) {//isset — 检测变量是否已设置并且非 null
                foreach ($goodsDate['goods_attr'] as $k => $v) {
                    if (is_array($v)) {//是否是数组
                        //如果数组里面有空值直接删除在上传到数据表里面
                        //$v = array_filter($v);//array_filter — 使用回调函数过滤数组的元素array
                        //要遍历的数组callback使用的回调函数
                        //如果没有提供 callback 回调函数，将删除数组中 array 的所有"空"元素。有关 PHP 如何判定"空"元素

//                        实现价格和属性值的的一一对应
                        if (!empty($v)) {  //$v就是嵌套数组的里面的嵌套的那个数组  //是否为空
                            foreach ($v as $k1 => $v1) {
                                //属性价格和属性值如果是 空值就不把空值上传，
                                if (!$v1) {//如果 $v1为空的话 那么就直接跳过这个值输出其他的值
                                    //如果等于那么就不输出这个值 输出其他的值
                                    $money++;
                                    continue;//continue 在循环结构用用来跳过本次循环中剩余的代码并在条件求值为真时开始执行下一次循环。
                                }
                                db('goods_attr')->insert(['attr_id' => $k, 'attr_value' => $v1, 'attr_price' => $goodsDate['attr_price'][$money], 'goods_id' => $goodsID,]);
                                $money++;

                            }

                        }
                    } else {
                        //处理唯一属性的值
                        db('goods_attr')->insert(['attr_id' => $k, 'attr_value' => $v, 'goods_id' => $goodsID]);

                    }
                }
            }
//            dump(input('post.'));die();
//            dump($goodsAttr);die();


//            商品相册的处理
            //调用good模型里面的_hasImgs方法对象
            if ($goods->_hasImgs($_FILES['goods_photo']['tmp_name'])) {//下面的两个数组 传递过来
                $files = request()->file('goods_photo');
                //tp5手册方法
                if (is_array($files) || is_object($files)) {
                    //is_object — 检测变量是否是一个对象 ，is_array — 检测变量是否是数组
                    foreach ($files as $file) {
                        // 移动到框架应用根目录/public/uploads/ 目录下
                        $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                        if ($info) {
                            // 输出 42a79759f284b767dfcb2a0197904287.jpg
                            $photoName = $info->getFilename();
                            $og_photo = date("Ymd") . DS . $photoName;  //原图 地址
                            $big_photo = date("Ymd") . DS . 'big_' . $photoName;//大图地址
                            $mid_photo = date("Ymd") . DS . 'mid_' . $photoName;//中图地址
                            $sm_photo = date("Ymd") . DS . 'sm_' . $photoName;//小图地址
                            $image = \think\Image::open(IMG_UPLOAD . $og_photo);//原图 地址
                            $image->thumb(500, 500)->save(IMG_UPLOAD . $big_photo);//大图地址
                            $image->thumb(200, 200)->save(IMG_UPLOAD . $mid_photo);//中图地址
                            $image->thumb(80, 80)->save(IMG_UPLOAD . $sm_photo);//小图地址
                            @unlink(IMG_UPLOAD . $og_photo);//删除原图 unlink — 删除文件(里面是路径)
                            db('goods_photo')->insert(['goods_id' => $goodsID, 'og_photo' => $og_photo, 'big_photo' => $big_photo, 'mid_photo' => $mid_photo,
                                'sm_photo' => $sm_photo]);
                        } else {
                            // 上传失败获取错误信息
                            echo $file->getError();
                        }
                    }
                }


            }


        });
        //删除有商品及后面该所有数据
        Goods::beforeDelete(function ($goods) {
            $goodsID = $goods->id;
            //删除主图及其缩略图
            //使用数组的方式 使用循环删除
            // 判断是否有值 ，有图
            if ($goods->og_thumb) {//有值 进行的操作
                $thumb = [];
                $thumb[] = IMG_UPLOAD . $goods->og_thumb;
                $thumb[] = IMG_UPLOAD . $goods->big_thumb;
                $thumb[] = IMG_UPLOAD . $goods->mid_thumb;
                $thumb[] = IMG_UPLOAD . $goods->sm_thumb;
                //循环这个数组一次行把这个删除
                foreach ($thumb as $k => $v) { //v就是要删除的路径 把路径赋值给了k = 给了 v
                    if (file_exists($v)) { //file_exists — 检查文件或目录是否存在 $v 是路径
                        @unlink($v);
                    }
                }
            }


            //删除关联的会员价格  用的是db方法删除
            db('member_price')->where('goods_id', '=', $goodsID)->delete();
//            //删除关联的商品属性
            db('goods_attr')->where('goods_id', '=', $goodsID)->delete();
            //删除关联的商品相册 ，使用模型文件删除
            //实例化GoodsPhoto这个模型， where 是里面是条件
            $goodsPhotoRes = model('GoodsPhoto')->where('goods_id', '=', $goodsID)->select();
            if (!empty($goodsPhotoRes)) {//如果他不为空
                foreach ($goodsPhotoRes as $k => $v) {
                    //使用数组的方式 使用循环删除
                    // 判断是否有值 ，有图
                    if ($v->og_photo) {//有值 进行的操作
                        $photo = [];
                        $photo[] = IMG_UPLOAD . $v->og_photo;
                        $photo[] = IMG_UPLOAD . $v->big_photo;
                        $photo[] = IMG_UPLOAD . $v->mid_photo;
                        $photo[] = IMG_UPLOAD . $v->sm_photo;
                        //循环这个数组一次行把这个删除
                        //k1和v1就代表具体的一条记录里面的对应的几个缩略图和原图的地址
                        foreach ($photo as $k1 => $v1) { //v就是要删除的路径 把路径赋值给了k1 = 给了 v1
                            if (file_exists($v1)) { //file_exists — 检查文件或目录是否存在 $v 是路径
                                @unlink($v1);
                            }
                        }
                    }

                }
            }
            //把数据库记录删除
            model('GoodsPhoto')->where('goods_id', '=', $goodsID)->delete();
//            dump($goosPhotoRes);die();

        });

    }

//    商品相册图片是否有上传图判断 是否有空图
    private function _hasImgs($tmpArr)
    {//直接把商品相册图片以数组传递过来
        foreach ($tmpArr as $k => $v) {//v代表每个输出出来的数组值
            if ($v) { //判断是否有值不为空
                return true;
            }
        }
        return false;
    }


    public function upload($imgName)
    {
// 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($imgName);
// 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
            if ($info) {
// 成功上传后 获取上传信息
// 输出 jpg

// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg

// 输出 42a79759f284b767dfcb2a0197904287.jpg
                return $info->getFilename();
            } else {
// 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }


}
