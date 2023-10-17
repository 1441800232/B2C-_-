<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"D:\wamp64\www\shop\public/../application/admin\view\conf\conflst.htm";i:1684232731;s:66:"D:\wamp64\www\shop\public/../application/admin\view\common\top.htm";i:1697091390;s:67:"D:\wamp64\www\shop\public/../application/admin\view\common\left.htm";i:1697098256;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>chen</title>

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
                                    <h2><span class="profile"><span><?php echo \think\Session::get('uname'); ?></span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a>David Stevenson</a></li>
                                <li class="dropdown-footer">
                                    <a href="<?php echo url('Admin/logout'); ?>">
                                            退出登录
                                        </a>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="<?php echo url('Admin/edit',array('id'=>\think\Session::get('id'))); ?>">
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
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text">管理员</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="<?php echo url('Admin/lst'); ?>">
                    <span class="menu-text">管理员列表 </span>
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
            <i class="menu-icon fa fa-th"></i>
            <span class="menu-text">权限配置</span>
            <i class="menu-expand"></i>
        </a>
        <ul class="submenu">
            <li>
                <a href="<?php echo url('AuthRule/lst'); ?>">
                    <span class="menu-text">规则管理 </span>
                    <i class="menu-expand"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="menu-text">用户组管理 </span>
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
                            <a href="<?php echo url('Conf/lst'); ?>">配置管理</a>
                        </li>
                        <li class="active">配置列表</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Body -->
                <div class="page-body">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!--配置列表开始-->
                                <div class="widget-body">
                                    <div class="widget-main ">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs tabs-flat" id="myTab11">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#home11">
                                                        店铺配置
                                                    </a>
                                                </li>

                                                <li>
                                                    <a data-toggle="tab" href="#profile11">
                                                        商品配置
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content tabs-flat">
                                                <div id="home11" class="tab-pane in active">
                                                    <div id="horizontal-form">
                                                                       <!--ction="" 的值为空就是添加到当前控制器的add方法    enctype意思是可以上传图片-->
                                                        <form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                                                            <?php foreach ($ShopConfRes as $k => $conf):?>
                                                            <div class="form-group">
                                                                <label for="username" class="col-sm-2 control-label no-padding-right">
                                                                    <?php echo $conf['cname'];?>
                                                                </label>
                                                                <div class="col-sm-6">
                                                                    <!-- 单行文本-->
                                                                     <?php if($conf['form_type']=='input'):?>
                                                                    <!-- 单行文本-->
                                                                    <input class="form-control"  value="<?php echo $conf['value'];?>"  name=" <?php echo $conf['ename'];?>" required="" type="text">
                                                                    <!-- 文本域-->
                                                                    <?php elseif($conf['form_type'] == 'textarea'):?>
                                                                    <!-- 文本域-->
                                                                    <textarea name="<?php echo $conf['ename'];?>"   class="form-control">
                                                                        <?php echo $conf['value'];?>
                                                                    </textarea>
                                                                    <!--单选-->
                                                                    <?php elseif($conf['form_type']=='radio'):?>
                                                                     <!--单选-->
                                                                    <div class="radio">
                                                                       <!-- 把可选值 拆分成数组 用explode进行分割（分割的值是可选值） 分割的符号是’， ‘ -->
                                                                        <?php if($conf['values']):
                                                                        $arr=explode(',', $conf['values']);
                                                                        foreach($arr as $k1=>$v1):?>
                                                                        <label>
                                                                            <!--和默认做一个比对  如果当前的这条记录value的默认值等于$v1，所以说明$v1就是默认值-->
                                                                            <input type="radio" class="colored-blue"
                                                                            <?php if($conf['value']==$v1){ echo 'checked="checked"'; }?>
                                                                            name="<?php echo $conf['ename'];?>" value="<?php echo $v1;?>">
                                                                            <span class="text"> <?php echo $v1;?> </span>
                                                                        </label>
                                                                        <?php endforeach; endif;?>
                                                                    </div>
                                                                    <!--下拉菜单-->
                                                                    <?php elseif($conf['form_type']=='select'):?>
                                                                    <select name="<?php echo $conf['ename'];?>">
                                                                        <option value="">请选择</option>
                                                                    <?php if($conf['values']):
                                                                        $arr=explode(',',$conf['values']);
                                                                        foreach($arr as $k1 => $v1):?>
                                                                        <option <?php if($conf['value']==$v1){ echo 'selected="selected"'; }?> value="<?php echo $v1;?>">
                                                                            <?php echo $v1;?>
                                                                        </option>
                                                                    <?php endforeach; endif;?>
                                                                    </select>
                                                                    <!--下拉菜单-->

                                                                    <!--复选框-->
                                                                    <?php elseif($conf['form_type']=='checkbox'):?>
                                                                     <!--复选框-->
                                                                    <div class="checkbox">
                                                                        <?php if($conf['values']):
                                                                        $arr=explode(',',$conf['values']);
                                                                        $arr_value=explode(',',$conf['value']);
                                                                        foreach($arr as $k1=>$v1):
                                                                        ?>
                                                                        <!--复选框按钮1-->
                                                                        <label>
                                                                           <!--第一个数组（）： $arr=explode(',',$conf['values']);
                                                                           如果有多个默认值或者选定值:有两个数组第一个是总共有多少选项
                                                                           是可选值的数组:$arr=explode(',',$conf['values']);
                                                                           默认值数组：$arr_value=explode(',',$conf['value']);
                                                                           -->
                                                                            <!--和默认做一个比对，果当前的这条记录value的默认值等于$v1，所以说明$v1就是默认值
                                                                            如果你循环了一个可选值在我们的数组里面（$arr_value），那么就说明它处于选定的状态
                                                                            如果当前的当前的可选值他在我们默认值数组组成的默认值里面，么说明就处于选定的状态
                                                                            -->
                                                                            <input
                                                                            <?php if(in_array($v1, $arr_value)){ echo 'checked="checked"'; }?>
                                                                            name=" <?php echo $conf['ename'];?>[]" value="<?php echo $v1;?>"
                                                                            type="checkbox" class="colored-blue">
                                                                            <span class="text"> <?php echo $v1;?> </span>
                                                                        </label>
                                                                        <?php endforeach; endif;?>
                                                                        <!--复选框按钮2-->
                                                                    </div>
                                                                    <!--文件上传-->
                                                                    <?php elseif($conf['form_type'] ==  'file'):?>
                                                                       <!--文件上传-->
                                                                    <input name="<?php echo $conf['ename'];?>" type="file" >
                                                                    <?php if($conf['value']):?>
                                                                    <img src="__UPADMIN__/<?php echo $conf['value']; ?>" height="50px">
                                                                    <?php else:?>
                                                                    暂无图片
                                                                    <?php endif;endif;?>
                                                               </div>
                                                            </div>
                                                            <?php endforeach;?>
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-2 col-sm-10">
                                                                    <button type="submit" class="btn btn-default">保存信息</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>

                                                <div id="profile11" class="tab-pane">
                                                    <div id="horizontal-form">
                                                        <!--ction="" 的值为空就是添加到当前控制器的add方法    enctype意思是可以上传图片-->
                                                        <form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                                                            <?php foreach ($GoodsConfRes as $k => $conf):?>
                                                            <div class="form-group">
                                                                <label for="username" class="col-sm-2 control-label no-padding-right">
                                                                    <?php echo $conf['cname'];?>
                                                                </label>
                                                                <div class="col-sm-6">
                                                                    <!-- 单行文本-->
                                                                    <?php if($conf['form_type']=='input'):?>
                                                                    <!-- 单行文本-->
                                                                    <input class="form-control"  value="<?php echo $conf['value'];?>"  name=" <?php echo $conf['ename'];?>" required="" type="text">
                                                                    <!-- 文本域-->
                                                                    <?php elseif($conf['form_type'] == 'textarea'):?>
                                                                    <!-- 文本域-->
                                                                    <textarea name="<?php echo $conf['ename'];?>"   class="form-control">
                                                                        <?php echo $conf['value'];?>
                                                                    </textarea>
                                                                    <!--单选-->
                                                                    <?php elseif($conf['form_type']=='radio'):?>
                                                                    <!--单选-->
                                                                    <div class="radio">
                                                                        <!-- 把可选值 拆分成数组 用explode进行分割（分割的值是可选值） 分割的符号是’， ‘ -->
                                                                        <?php if($conf['values']):
                                                                        $arr=explode(',', $conf['values']);
                                                                        foreach($arr as $k1=>$v1):?>
                                                                        <label>
                                                                            <!--和默认做一个比对  如果当前的这条记录value的默认值等于$v1，所以说明$v1就是默认值-->
                                                                            <input type="radio" class="colored-blue"
                                                                            <?php if($conf['value']==$v1){ echo 'checked="checked"'; }?>
                                                                            name="<?php echo $conf['ename'];?>" value="<?php echo $v1;?>">
                                                                            <span class="text"> <?php echo $v1;?> </span>
                                                                        </label>
                                                                        <?php endforeach; endif;?>
                                                                    </div>
                                                                    <!--下拉菜单-->
                                                                    <?php elseif($conf['form_type']=='select'):?>
                                                                    <select name="<?php echo $conf['ename'];?>">
                                                                        <option value="">请选择</option>
                                                                        <?php if($conf['values']):
                                                                        $arr=explode(',',$conf['values']);
                                                                        foreach($arr as $k1 => $v1):?>
                                                                        <option <?php if($conf['value']==$v1){ echo 'selected="selected"'; }?> value="<?php echo $v1;?>">
                                                                        <?php echo $v1;?>
                                                                        </option>
                                                                        <?php endforeach; endif;?>
                                                                    </select>
                                                                    <!--下拉菜单-->

                                                                    <!--复选框-->
                                                                    <?php elseif($conf['form_type']=='checkbox'):?>
                                                                    <!--复选框-->
                                                                    <div class="checkbox">
                                                                        <?php if($conf['values']):
                                                                        $arr=explode(',',$conf['values']);
                                                                        $arr_value=explode(',',$conf['value']);
                                                                        foreach($arr as $k1=>$v1):
                                                                                             ?>
                                                                                             <!--复选框按钮1-->
                                                                        <label>
                                                                            <!--第一个数组（）： $arr=explode(',',$conf['values']);
                                                                            如果有多个默认值或者选定值:有两个数组第一个是总共有多少选项
                                                                            是可选值的数组:$arr=explode(',',$conf['values']);
                                                                            默认值数组：$arr_value=explode(',',$conf['value']);
                                                                            -->
                                                                            <!--和默认做一个比对，果当前的这条记录value的默认值等于$v1，所以说明$v1就是默认值
                                                                            如果你循环了一个可选值在我们的数组里面（$arr_value），那么就说明它处于选定的状态
                                                                            如果当前的当前的可选值他在我们默认值数组组成的默认值里面，么说明就处于选定的状态
                                                                            -->
                                                                            <input
                                                                            <?php if(in_array($v1, $arr_value)){ echo 'checked="checked"'; }?>
                                                                            name=" <?php echo $conf['ename'];?>[]" value="<?php echo $v1;?>"
                                                                            type="checkbox" class="colored-blue">
                                                                            <span class="text"> <?php echo $v1;?> </span>
                                                                        </label>
                                                                        <?php endforeach; endif;?>
                                                                                             <!--复选框按钮2-->
                                                                    </div>
                                                                    <!--文件上传-->
                                                                    <?php elseif($conf['form_type'] ==  'file'):?>
                                                                    <!--文件上传-->
                                                                    <input name="<?php echo $conf['ename'];?>" type="file" >
                                                                    <?php if($conf['value']):?>
                                                                    <img src="__UPADMIN__/<?php echo $conf['value']; ?>" height="50px">
                                                                    <?php else:?>
                                                                    暂无图片
                                                                    <?php endif;endif;?>
                                                                </div>
                                                            </div>
                                                            <?php endforeach;?>
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-2 col-sm-10">
                                                                    <button type="submit" class="btn btn-default">保存信息</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--配置列表结束-->





<!--                                <div class="widget-body">-->
<!--                                    <div id="horizontal-form">-->
<!--                                        &lt;!&ndash; action="" 的值为空就是添加到当前控制器的add方法  &ndash;&gt; &lt;!&ndash;   enctype意思是可以上传图片&ndash;&gt;-->
<!--                                        <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">-->

<!--                                            <div class="form-group">-->
<!--                                                <label for="username" class="col-sm-2 control-label no-padding-right">配置名称</label>-->
<!--                                                <div class="col-sm-6">-->
<!--                                                    <input class="form-control"  placeholder="" name="cname" required="" type="text">-->
<!--                                                </div>-->
<!--                                            </div>-->

<!--                                            <div class="form-group">-->
<!--                                                <div class="col-sm-offset-2 col-sm-10">-->
<!--                                                    <button type="submit" class="btn btn-default">保存信息</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </form>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
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



</body>

</html>