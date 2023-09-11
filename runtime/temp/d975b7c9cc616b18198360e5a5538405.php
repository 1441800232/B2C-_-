<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"D:\wamp64\www\shop\public/../application/admin\view\goods\edit.htm";i:1684912929;s:66:"D:\wamp64\www\shop\public/../application/admin\view\common\top.htm";i:1687179963;s:67:"D:\wamp64\www\shop\public/../application/admin\view\common\left.htm";i:1684912930;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Chen</title>

    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="__admin__/style/bootstrap.css" rel="stylesheet">
    <link href="__admin__/style/font-awesome.css" rel="stylesheet">
    <link href="style/weather-icons.css" rel="stylesheet">

    <!--Beyond styles-->
    <link id="beyond-link" href="__admin__/style/beyond.css" rel="stylesheet" type="text/css">
    <link href="__admin__/style/demo.css" rel="stylesheet">
    <link href="__admin__/style/typicons.css" rel="stylesheet">
    <link href="__admin__/style/animate.css" rel="stylesheet">
    <script src="__UEDITOR__/ueditor/dist/utf8-php/ueditor.config.js"></script>
    <script src="__UEDITOR__/ueditor/dist/utf8-php/ueditor.all.min.js"></script>
    <script src="__UEDITOR__/ueditor/dist/utf8-php/lang/zh-cn/zh-cn.js"></script>

    <style type="text/css">
        .price {
            width: 150px;
            margin-left: 10px;
            display: inline-block;
        }

        .a-btn {
            padding-right: 10px;
        }

    </style>
</head>

<body>
<!-- 头部 -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="#" class="navbar-brand">
                    <small>
                            <img src="__admin__//images/6.jpg" alt="">
                        </small>
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings -->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li>
                            <a href="<?php echo url('Index/clearCache'); ?>" class="login-area dropdown-toggle" >
                                <section>
                                    <h2><span class="profile"><i class="menu-icon fa fa-trash-o">&nbsp;</i>清空缓存</span></h2>
                                </section>
                            </a>
                        </li>
                        <li>
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" title="View your public profile">
                                    <img src="__admin__//images/th.jpg">
                                </div>
                                <section>
                                    <h2><span class="profile"><span>admin</span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a>David Stevenson</a></li>
                                <li class="dropdown-footer">
                                    <a href="/admin/user/logout.html">
                                            退出登录
                                        </a>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="/admin/user/changePwd.html">
                                            修改密码
                                        </a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <!-- /Account Area -->
                        <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                        <!-- Settings -->
                    </ul>
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>

<!-- /头部 -->

<div class="main-container container-fluid">
    <div class="page-container">
        <!-- Page Sidebar左侧 -->
        <div class="page-sidebar" id="sidebar">
    <!-- Page Sidebar Header-->
    <div class="sidebar-header-wrapper">
        <input class="searchinput" type="text">
        <i class="searchicon fa fa-search"></i>
        <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
    </div>
    <!-- /Page Sidebar Header -->
    <!-- Sidebar Menu -->
    <ul class="nav sidebar-menu">
        <!--Dashboard-->
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-shopping-cart"></i>
                <span class="menu-text">商品管理</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo url('Goods/lst'); ?>">
                        <span class="menu-text">商品列表</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('Goods/add'); ?>"><!-- 转到商品添加界面  -->
                        <span class="menu-text">添加商品</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('Brand/lst'); ?>"><!-- 转到商品展示界面   -->
                        <span class="menu-text">商品品牌</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('Category/lst'); ?>">
                        <span class="menu-text">商品分类</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('Type/lst'); ?>">
                        <span class="menu-text">商品类型</span>
                        <i class="menu-expand"></i>
                    </a>    
                </li>
<!--                <li>-->
<!--                    <a href="#">-->
<!--                        <span class="menu-text">商品回收站</span>-->
<!--                        <i class="menu-expand"></i>-->
<!--                    </a>-->
                </li>
            </ul>
        </li>

        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa  fa-thumbs-up"></i>
                <span class="menu-text">推荐位管理</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo url('Recpos/lst'); ?>">
                        <span class="menu-text">推荐位列表 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('Recpos/add'); ?>">
                        <span class="menu-text">添加推荐位</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa  fa-random"></i>
                <span class="menu-text">栏目关联信息</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo url('CategoryWords/lst'); ?>">
                        <span class="menu-text">推荐词关联</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('CategoryBrands/lst'); ?>">
                        <span class="menu-text">品牌关联</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('CategoryAd/lst'); ?>">
                        <span class="menu-text">左图品牌关联</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa  fa-buysellads"></i>
                <span class="menu-text">  促销商品</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="#">
                        <span class="menu-text">团购活动 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text">  积分商城 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text">优惠卷</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-gavel"></i>
                <span class="menu-text">订单管理</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="#">
                        <span class="menu-text">订单列表 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text"> 订单查询 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-user-plus"></i>
                <span class="menu-text"> 会员管理</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="#">
                        <span class="menu-text">会员列表 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('MemberLevel/lst'); ?>">
                        <span class="menu-text">  会员级别 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text">会员留言</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-sitemap"></i>
                <span class="menu-text">  数据库管理</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="#">
                        <span class="menu-text">数据备份 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text">  数据表优化 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>
        <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-envelope"></i>
            <span class="menu-text">  短信管理</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="#">
                    <span class="menu-text">发送短信 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="menu-text">  短信签名 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-file-text"></i>
            <span class="menu-text"> 文章模块</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="<?php echo url('Cate/lst'); ?>">
                    <span class="menu-text">文章分类 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo url('Article/lst'); ?>">
                    <span class="menu-text">  文章管理 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
        </ul>
    </li>    <li>
        <a href="#" class="menu-dropdown">
            <i class="menu-icon fa fa-location-arrow"></i>
            <span class="menu-text"> 导航管理</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="<?php echo url('Nav/lst'); ?>">
                    <span class="menu-text">导航列表 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
            <li>
                <a href="<?php echo url('Nav/add'); ?>">
                    <span class="menu-text">  添加导航 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-picture-o"></i>
                <span class="menu-text"> 图片管理</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo url('Article/imglist'); ?>">
                        <span class="menu-text">图片列表</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo url('AlternateImg/lst'); ?>">
                        <span class="menu-text">首页轮播图管理</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>

            </ul>


        </li>
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-gear"></i>
                <span class="menu-text">  系统设置</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo url('Conf/conflst'); ?>">
                        <span class="menu-text">配置项 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                </li>
                <li>
                    <a href="<?php echo url('Conf/lst'); ?>">
                        <span class="menu-text"> 配置管理 </span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text">支付方式设置</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-link"></i>
                <span class="menu-text"> 友情链接</span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo url('Link/lst'); ?>">
                        <span class="menu-text">链接列表</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- /Sidebar Menu -->
</div>
        <!-- /Page Sidebar -->
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo url('Index/index'); ?>">系统</a>
                    </li>
                    <li>
                        <a href="<?php echo url('Goods/lst'); ?>">商品管理</a>
                    </li>
                    <li class="active">修改商品</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <form class="form-horizontal" role="form" action="" method="post"
                                  enctype="multipart/form-data">
                                <!--   enctype意思是可以上传图片-->
                                <!--隐藏域-->
                                <input type="hidden" name="id" value="<?php echo $goods['id']; ?>">
                                <input type="hidden" name="og_thumb" value="<?php echo $goods['og_thumb']; ?>">
                                <input type="hidden" name="sm_thumb" value="<?php echo $goods['sm_thumb']; ?>">
                                <input type="hidden" name="mid_thumb" value="<?php echo $goods['mid_thumb']; ?>">
                                <input type="hidden" name="big_thumb" value="<?php echo $goods['big_thumb']; ?>">
                                <!--商品信息开始 -->
                                <div class="widget-body">
                                    <div class="widget-main ">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs tabs-flat" id="myTab11">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#baseinfo" aria-expanded="true">
                                                        商品基本信息
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a data-toggle="tab" href="#goodsdes" aria-expanded="false">
                                                        商品描述信息
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a data-toggle="tab" href="#mbprice" aria-expanded="false">
                                                        会员价格
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a data-toggle="tab" href="#goodsattr" aria-expanded="false">
                                                        商品属性
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a data-toggle="tab" href="#goodsphoto" aria-expanded="false">
                                                        商品相册
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content tabs-flat">
                                                <div id="baseinfo" class="tab-pane active">
                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">
                                                            商品名称
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" placeholder="" name="goods_name" required="" type="text" value="<?php echo $goods['goods_name']; ?>">
                                                        </div>
                                                        <p class="help-block col-sm-4 red">* 必填</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">
                                                            推荐位
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <div class="checkbox">
                                                                <?php if(is_array($goodsRecposRes) || $goodsRecposRes instanceof \think\Collection || $goodsRecposRes instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsRecposRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$recpos): $mod = ($i % 2 );++$i;?>
                                                                <label style="margin-left: 10px">
                                                                    <?php if(in_array($recpos['id'],$myGoodsRecposRes)){
                                                                                $checked='checked="checked"';
                                                                                } else{
                                                                                $checked='';
                                                                                }?>
                                                                    <input <?php echo $checked?> type="checkbox" name="recpos[]" class="inverted" value="<?php echo $recpos['id']; ?>" >
                                                                    <span class="text"><?php echo $recpos['rec_name']; ?></span>
                                                                </label>
                                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </div>
                                                        </div>
                                                        <p class="help-block col-sm-4 red">* 必填</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">商品主图</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" style="border: none; box-shadow:none" name="og_thumb" type="file">
                                                            <?php if($goods['sm_thumb']): ?>
                                                            <img src="__UPADMIN__/<?php echo $goods['sm_thumb']; ?>" height="30px">
                                                            <?php else: ?>
                                                            暂无缩略图
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">上架</label>
                                                        <div class="col-sm-6">
                                                            <div class="radio">
                                                                <label>
                                                                    <input <?php if($goods['on_sale'] == 1): ?> checked="checked" <?php endif; ?> name="on_sale" checked="checked" type="radio" class="colored-blue" value="1">
                                                                    <span class="text">是</span>
                                                                </label>

                                                                <label>
                                                                    <input <?php if($goods['on_sale'] == 0): ?> checked="checked" <?php endif; ?> name="on_sale" type="radio" class="colored-blue" value="0">
                                                                    <span class="text">否</span>
                                                                </label>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">所属栏目</label>
                                                        <div class="col-sm-6">
                                                            <SELECT name="category_id">
                                                                <option value="">请选择</option>
                                                                <?php if(is_array($CategoryRes) || $CategoryRes instanceof \think\Collection || $CategoryRes instanceof \think\Paginator): $i = 0; $__LIST__ = $CategoryRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
                                                                <!-- 如果当前栏目的pid 等于我们现在 正在循环的某一个id的话那么就是我们当前栏目的上级栏目   selected="selected"选定-->
                                                                <option <?php if($goods['category_id'] ==  $cate['id']): ?> selected="selected" <?php endif; ?>
                                                                value="<?php echo $cate['id']; ?>"><?php echo str_repeat('--',  $cate['level']*6)?>
                                                                <?php echo $cate['cate_name']; ?>
                                                                </option>
                                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </SELECT>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username"
                                                               class="col-sm-2 control-label no-padding-right">所属品牌</label>
                                                        <div class="col-sm-6">
                                                            <SELECT name="brand_id">
                                                                <!--一定要给一个空值，要不然下面免得volist里面的值就会是上面的‘请选择’ -->
                                                                <option value="">请选择</option>
                                                                <?php if(is_array($brandRes) || $brandRes instanceof \think\Collection || $brandRes instanceof \think\Paginator): $i = 0; $__LIST__ = $brandRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?>
                                                                <option <?php if($goods['category_id'] ==  $cate['id']): ?> selected="selected" <?php endif; ?> value="<?php echo $brand['id']; ?>"> <?php echo $brand['brand_name']; ?></option>
                                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </SELECT>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username"
                                                               class="col-sm-2 control-label no-padding-right">
                                                            市场价格
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" placeholder=""
                                                                   value="<?php echo $goods['markte_price']; ?>" name="markte_price"
                                                                   required="" type="text">
                                                        </div>
                                                        <p class="help-block col-sm-4 red">* 必填</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username"
                                                               class="col-sm-2 control-label no-padding-right">
                                                            本店价格
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" value="<?php echo $goods['shop_price']; ?>" placeholder="" name="shop_price" required="" type="text">
                                                        </div>
                                                        <p class="help-block col-sm-4 red">* 必填</p>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">商品重量</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" style="width: 300px; display: inline-block;" value="<?php echo $goods['goods_weight']; ?>" placeholder="" name="goods_weight" required="" type="text">
                                                            <select name="weiht_uint">
                                                                <option <?php if($goods['weiht_uint'] == 'kg'): ?> selected="selected" <?php endif; ?> value="kg">kg</option>
                                                                <option <?php if($goods['weiht_uint'] == 'g'): ?> selected="selected" <?php endif; ?> value="g">g</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!--描述信息-->
                                                <div id="goodsdes" class="tab-pane">
                                                    <textarea id="goods_des"><?php echo $goods['editorValue']; ?></textarea>
                                                </div>


                                                <div id="mbprice" class="tab-pane">
                                                    <?php if(is_array($mlRes) || $mlRes instanceof \think\Collection || $mlRes instanceof \think\Paginator): $i = 0; $__LIST__ = $mlRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ml): $mod = ($i % 2 );++$i;?>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">
                                                            <?php echo $ml['level_name']; ?>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <!--判断数组元素是否存在 检测变量是否已设置并且非 null-->
                                                            <input  class="form-control" placeholder="" name="mp[<?php echo $ml['id']; ?>]"
                                                              value="<?php if(isset($mpRes[$ml['id']]['mprice'])){
                                                             echo $mpRes[$ml['id']]['mprice'];
                                                             }
                                                            else{echo '';}?>"
                                                            type="text">
                                                        </div>
                                                    </div>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </div>


                                                <div id="goodsattr" class="tab-pane">
                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right">商品类型</label>
                                                        <div class="col-sm-6" >
                                                            <SELECT name="type_id"
                                                                    <?php if($goods['type_id'] != 0): ?> disabled="disabled"
                                                                    <?php endif; ?> >
                                                                     <!--通过着name 切换类型实时 进行绑定下面数据属性   -->
                                                                <option value="0" selected="selected" >请选择</option>
                                                                <?php if(is_array($typeRes) || $typeRes instanceof \think\Collection || $typeRes instanceof \think\Paginator): $i = 0; $__LIST__ = $typeRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                                                                <option
                                                                <?php if($goods['type_id'] == $type['id']): ?> selected="selected" <?php endif; ?> value="<?php echo $type['id']; ?>">
                                                                <?php echo $type['type_name']; ?>
                                                                </option>
                                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </SELECT>
                                                        </div>
                                                        <p class="help-block col-sm-4 red">* 必填</p>
                                                    </div>
                                                    <div id="attr_list">
                                                        <!-- 商品属性显示（）
															explode — 使用一个字符串分割另一个字符串
															此函数返回由字符串组成的数组(打散成一个数组)
															-->
                                                        <?php foreach($attrRes as $k => $v):if($v['attr_type']==1):
																 $attrRido = explode(",",$v['attr_values']);
																?>
                                                        <!-- 单选-->
                                                        <!--循环显示当前商品所用有的所有的单选属性值
                                                        $v['id']就是 商品属性的id
                                                        -->
                                                        <?php foreach($gattrRes[$v['id']] as $k0 => $v0):?>
                                                        <!--获取goods_attr表里面的（id） gaid="" --->
                                                        <div gaid="<?php echo $v0['id'];?>" class="form-group">
                                                            <label class="col-sm-2 control-label no-padding-right">
                                                                <?php echo $v['attr_name'];?>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <a class="a-btn" onclick="addrow(this);" href="#"><?php if($k0==0){echo '[+]'; }else{echo '[-]'; }?></a>
                                                                <select name='old_goods_attr[<?php echo $v['id']?>][]'>
                                                                    <option  value="0">请选择</option>
                                                                    <?php foreach($attrRido as $k1 => $v1):?>
                                                                    <option <?php if($v1 == $v0['attr_value']){ echo 'selected="selected"'; }?> value="<?php echo $v1;?>"><?php echo $v1;?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                                <input type="text" placeholder="价格"  class="form-control price"value="<?php echo $v0['attr_price']?>" name="old_attr_price[<?php echo $v0['id']?>]">
                                                            </div>
                                                        </div>

                                                        <?php endforeach;else:?>
                                                        <!-- 唯一-->
                                                        <?php if(!$v['attr_values']):?>
                                                        <div class="form-group"><label class="col-sm-2 control-label no-padding-right"><?php echo $v['attr_name'];?></label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control price" name='old_goods_attr[<?php echo $v['id']?>]' value="<?php echo $gattrRes[$v['id']][0]['attr_value'];?>"><!--定位到当前记录的值-->
                                                                <input type="hidden" name="old_attr_price[<?php echo $gattrRes[$v['id']][0]['id'];?>]"> <!--定位到当前记录的id-->
                                                            </div>
                                                        </div>
                                                        <?php else:
															   $attrSole=explode(",",$v['attr_values']);
															?>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label "><?php echo $v['attr_name'];?></label>
                                                            <div class="col-sm-6">
                                                                <select name='old_goods_attr[<?php echo $v['id']?>]'>
                                                                    <option value="">请选择</option>
                                                                    <?php foreach($attrSole as $k1 => $v1):?>
                                                                    <option <?php if($v1 == $gattrRes[$v['id']][0]['attr_value']){ echo 'selected="selected"'; }?> value="<?php echo $v1;?>"><?php echo $v1;?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                                <input type="hidden" name="old_attr_price[<?php echo $gattrRes[$v['id']][0]['id'];?>]">
                                                            </div>
                                                        </div>
                                                        <?php endif;endif;endforeach;?>
                                                    </div>
                                                </div>



                                                <div id="goodsphoto" class="tab-pane">
                                                    <?php if(is_array($gphotoRes) || $gphotoRes instanceof \think\Collection || $gphotoRes instanceof \think\Paginator): $i = 0; $__LIST__ = $gphotoRes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gphoto): $mod = ($i % 2 );++$i;?>
                                                    <div id="<?php echo $gphoto['id']; ?>" class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right"></label>
                                                        <div class="col-sm-6">
                                                            <!-- addphoto(this) 是定义一个方法 并把他自己传递进去，
                                                            this就是把自己传递进去 自己就是a标签这个元素-->
                                                            <a onclick="delrow(this);" href="#">[-]</a>
                                                            <!--name=“”改成数组模式才可以接收到所有的提交的图片-->
                                                            <img height="50px" src="__UPADMIN__/<?php echo $gphoto['sm_photo']; ?>" style=" box-shadow:none; display: inline-block"/>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>

                                                    <div class="form-group">
                                                        <label for="username" class="col-sm-2 control-label no-padding-right"></label>
                                                        <div class="col-sm-6">
                                                            <!-- addphoto(this) 是定义一个方法 并把他自己传递进去，
                                                            this就是把自己传递进去 自己就是a标签这个元素-->
                                                            <a onclick="addphoto(this);"href="javascript:;">[+]</a>
                                                            <!--name=“”改成数组模式才可以接收到所有的提交的图片-->
                                                            <input class="form-control" style="border: none;width: 50%; box-shadow:none; display: inline-block" name="goods_photo[]" type="file">
                                                        </div>
                                                    </div>

                                                    <div id="goods_photo">

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-default">保存信息</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--商品信息结束 -->
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
</div>

<!--Basic Scripts-->
<script src="__admin__/style/jquery_002.js"></script>
<script src="__admin__/style/bootstrap.js"></script>
<script src="__admin__/style/jquery.js"></script>
<!--Beyond Scripts-->
<script src="__admin__/style/beyond.js"></script>
<script type="text/javascript">/*富文本编辑器设置*/
var ue = UE.getEditor('goods_des', {initialFrameWidth: 620, initialFrameHeight: 400});


</script>

<script type="text/javascript">
    // 利用json来写
    //主要功能：当我切换点击类型的时候，就要获取当前这个最新的类型的他下面有那些属性{所有属性}（根据类型的id获取到这类型下面有那些属性）
    // 选定select,根据select的name来选定他的name是等于type_id,当他的值change（值发送改变的）的时候就执行里面的命名函数
    $("select[name=type_id]").change(function () {
        var type_id = $(this).val();
        //通过ajax的异步请求获取当前类型下面的属性
        $.ajax({
            type: "POST",
            url: "<?php echo url('Attr/ajaxGetAttr'); ?>", //通过类型的id获取属性的方法在attr控制下面的AjaxGetAttr方法
            data: {type_id: type_id}, //发送的参数
            dataType: "json",//接收的数据格式是json格式
            success: function (data) { //我们获取——经过异步的请求或去的数据就是data
                var html = ''; //定义一个空的字符串
                $(data).each(function (k, v) {  //date是一个二维数组 ，每次都会把一条记入给了v，一个v就代表一个属性
                    // html+=v.attr_name+":<input type='text'/><br>";
                    if (v.attr_type == 1) {
                        //单选处理
                        html += "<div class='form-group'>"
                        html += "<label class='col-sm-2 control-label no-padding-right'>" + v.attr_name + "</label>";
                        var attrValuesArr = v.attr_values.split(",") //对他进行拆分 split函数是拆分把一个字符串分割成字符串数组
                        //等拆分的数组放到这里  //addrow(this) 是定义一个方法 并把他自己传递进去，this就是把自己传递进去 自己就是a标签这个元素
                        html += "<div class='col-sm-6'><a class='a-btn' onclick='addrow(this);' href='#'>[+]</a>";
                        html += "<select name='goods_attr[" + v.id + "][]'>";//goods_attr 后面加[] 是要以数组的形式处理上传 因为他是多个上传
                        html += "<option value=''>请选择</option>";
                        //循环得到的数组
                        for (var i = 0; i < attrValuesArr.length; i++) {
                            //循环选项 (循环的属性值是attrValuesArr里的i)
                            html += "<option value='" + attrValuesArr[i] + "'>" + attrValuesArr[i] + "</option>";
                        }
                        html += "</select>";
                        html += "<input type='text'  placeholder='价格' class='form-control price' name='attr_price[]'  >";//attr_price 后面加[] 是要以数组的形式处理上传 因为他是多个上传
                        html += "</div></div> ";


                    } else {
                        //唯一处理
                        if (v.attr_values) {
                            html += "<div class='form-group'>"
                            html += "<label class='col-sm-2 control-label no-padding-right'>" + v.attr_name + "</label>";
                            var attrValuesArr = v.attr_values.split(",") //对他进行拆分 split函数是拆分把一个字符串分割成字符串数组
                            //等拆分的数组放到这里
                            html += "<div class='col-sm-6'>";
                            html += "<select name='goods_attr[" + v.id + "]'>";
                            html += "<option value=''>请选择</option>";
                            //循环得到的数组
                            for (var i = 0; i < attrValuesArr.length; i++) {
                                //循环选项 (循环的属性值是attrValuesArr里的i)
                                html += "<option value='" + attrValuesArr[i] + "'>" + attrValuesArr[i] + "</option>";
                            }
                            html += "</select>";
                            html += "</div></div> ";

                        } else {
                            //单行文本框
                            html += "<div class='form-group'>"
                            html += "<label class='col-sm-2 control-label no-padding-right'>" + v.attr_name + "</label>";
                            var attrValuesArr = v.attr_values.split(",") //对他进行拆分 split函数是拆分把一个字符串分割成字符串数组
                            //等拆分的数组放到这里
                            html += "<div class='col-sm-6'>";
                            html += "<input type='text'  name='goods_attr[" + v.id + "]'   class='form-control price' >"
                            html += "</div></div> ";
                        }


                    }
                });
                $("#attr_list").html(html);//用css定义的id属性来选择 ,直接把定义的var html 放进去
            }
        })
    })

    function addrow(o){
        var div = $(o).parent().parent();
        if($(o).html() == '[+]'){
            var newdiv=div.clone();
            newdiv.find('a').html('[-]');
            //修改old_attr_price[]为attr_price
            newdiv.find(':text').attr('name','attr_price[]');
            /**修改old_goods_attr[][]为goods_attr[][]
            * *定位到他的select
            * *在获取他里面的name*/
            var select = newdiv.find('select');
            var oldname = select.attr('name');
            //replace用于在字符串中用一些字符 替换另一些字符, 或替换一个与正则表达式匹配的子串
            var newname = oldname.replace('old_','');//把old_goods_attr前面的old_替换成空null
            select.attr('name',newname);


            div.after(newdiv);
        }else {
            div.remove();
            var div = $(o).parent().parent();
            //获取图片在数据库里面的id
            var gaid = div.attr('gaid');//获取属性的值 attr（value）,可以获得属性值
            // alert(id);
            $.ajax({
                type: "POST",
                data: {gaid:gaid},
                url: "<?php echo url('GoodsAttr/ajaxdelga'); ?>",
                success: function (data) {
                    if (data == 1) {
                        div.remove();
                    } else {
                        alert('删除失败！');
                    }
                }
            });
        }

    }

    //addphoto方法可以对select加一对减一
    function addphoto(o) {
        //定义最外层的div 他下面的副记标签的父记标签 parent()就是父记标签的意思是
        var div=$(o).parent().parent();
        if ($(o).html()  == '[+]'){
            //clone()函数就复制克隆
            var newdiv=div.clone();//clone是克隆方法，克隆方法生成被选元素的副本，包含子节点、文本和属性。
            newdiv.find('a').html('[-]');//利用find函数去查询到newdiv里的a标签，在利用html把a标签里面的'+'修改成'-'
            div.after(newdiv);
        }else {
            //remove函数
            //方法移除被选元素，包括所有的文本和子节点。
            // 该方法也会移除被选元素的数据和事件。
            //删除所有匹配的元素。
            div.remove();
        }
    }
    //addrow方法可以对select加一对减一
    // function addrow(o) {
    //     //定义最外层的div 他下面的副记标签的父记标签 parent()就是父记标签的意思是
    //     var div = $(o).parent().parent();
    //     if ($(o).html() =='[+]') {
    //         //clone()函数就复制克隆
    //         var newdiv = div.clone();//clone是克隆方法，克隆方法生成被选元素的副本，包含子节点、文本和属性。
    //         newdiv.find('a').html('[-]');//利用find函数去查询到newdiv里的a标签，在利用html把a标签里面的'+'修改成'-'
    //     } else {
    //         div.remove();            // if (confirm('确定要删除该属性吗？')) {
    //         //     //定义最外层的div 他下面的副记标签的父记标签 parent()就是父记标签的意思是 $(o)就是对应的a标签
    //         //     var div = $(o).parent().parent();
    //         //     //获取图片在数据库里面的id
    //         //     var gaid = div.attr('gaid');//获取属性的值 attr（value）,可以获得属性值
    //         //     // alert(id);
    //         //     $.ajax({
    //         //         type: "POST",
    //         //         data: {gaid:gaid},
    //         //         url: "<?php echo url('GoodsAttr/ajaxdelga'); ?>",
    //         //         success: function (data) {
    //         //             if (data == 1) {
    //         //                 div.remove();
    //         //             } else {
    //         //                 alert('删除失败！');
    //         //             }
    //         //         }
    //         //     });
    //
    //         }
    //         //remove函数
    //         //方法移除被选元素，包括所有的文本和子节点。
    //         // 该方法也会移除被选元素的数据和事件。
    //         //删除所有匹配的元素。
    //     }



    function delrow(o) {
        if (confirm('确定要删除该图片吗？')) {
            //定义最外层的div 他下面的副记标签的父记标签 parent()就是父记标签的意思是
            var div = $(o).parent().parent();
            //获取图片在数据库里面的id
            var id = div.attr('id');//获取属性的值 attr（value）,可以获得属性值
            // alert(id);
            $.ajax({
                type: "POST",
                data: {'id': id},
                url: "<?php echo url('Goods/ajaxdelpic'); ?>",
                success: function (data) {
                    if (data == 1) {
                        div.remove();
                    } else {
                        alert('删除失败！');
                    }
                }
            });

        }
    }
</script>


</body>

</html>