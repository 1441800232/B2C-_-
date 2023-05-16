<?php
namespace app\index\controller;
//继承低部类
class Index extends Base
{
    public function index()
    {
//		dump($this->config);die();
        return view();
    }
}
