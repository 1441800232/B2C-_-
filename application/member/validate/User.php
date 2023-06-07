<?php
namespace app\member\validate;
use think\Validate;

class User extends Validate
{
	protected $rule =   [
		'username'  => 'require|max:16|min:4|unique:user',
		'password'   => 'require|min:8|max:20',
		'email' => 'email|unique:user',
		'send_code' => 'number|length:6',
		'mobileagreement' => 'accepted',
		'register_type' => 'require|in:0,1',
	];

	protected $message  =   [
		'username.require' => '用户名必须',
		'username.max' => '用户名过长',
		'username.min' => '用户名过短',
		'username.unique' => '用户名重复',
		'password.require' => '密码必须',
		'password.min' => '密码过短',
		'password.max' => '密码过长',
		'send_code.number' => '邮件验证码必须为数字',
		'send_code.length' => '邮寄长度不正确',
		'mobileagreement.accepted' =>'请同意许可协议',
		'register_type.require'=>'未选择验证类型',
		'register_type.in'=>'验证类型错误',
		'email'        => '邮箱格式错误',
		'email.unique'        => '邮箱必须唯一',

	];

}


?>