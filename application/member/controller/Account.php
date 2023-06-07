<?php

namespace app\member\controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\Controller;


//Base是继承和头部低部类
class Account extends Controller
{
	//注册
	public function reg()
	{
		if (request()->isPost()){
			$data=input('post.');
			//验证
//			$validate = Loader::validate('User');
//			if(!$validate->check($data)){
//				dump($validate->getError());
//			}
			$userDate = array();
			$userDate['username']=$data['username'];
			$userDate['password']=md5($data['password']) ;
			$userDate['email']=$data['email'];
			$userDate['mobile_phone']=$data['mobile_phone'];
			$userDate['register_type']=$data['register_type'];
			$userDate['reg_time']=time();
			//执行注册
			$add = db('user')->insert($userDate);
			if ($add){
				$this->success("注册成功!正在为您跳转...",'member/user/index');
			}else{
				$this->error("注册失败!");
			}
		}
		return view();
	}

	//登入
	public function login()
	{
		return view();
	}

	//短信验证码
	public function sendMsg()
	{
		$statusStr = array(
			"0" => "短信发送成功",
			"-1" => "参数不全",
			"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
			"30" => "密码错误",
			"40" => "账号不存在",
			"41" => "余额不足",
			"42" => "帐户已过期",
			"43" => "IP地址限制",
			"50" => "内容含有敏感词"
		);
		$smsapi = "http://www.smsbao.com/"; //短信网关
		$user = "***"; //短信平台帐号
		$pass = md5("****"); //短信平台密码
		$content=mt_rand(11111,99999);//要发送的短信内容
		$phone = input('phone');
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		$result =file_get_contents($sendurl) ;
		echo $statusStr[$result];
	}

	//邮箱发送
	public function sendMail()
	{
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		$to=input('email');
		$title='B2C商城验证码';
		$code = mt_rand(100000, 999999);
		$content='您的验证码是：'.$code;
		try {
			//服务器配置
				$mail->CharSet ="UTF-8";                     //设定邮件编码
				$mail->SMTPDebug = 0;                        // 调试模式输出
				$mail->isSMTP();                             // 使用SMTP
				$mail->Host = 'smtp.qq.com';                // SMTP服务器
				$mail->SMTPAuth = TRUE;                      // 允许 SMTP 认证
				$mail->FromName = 'PHP商城';
				$mail->Username = '2868391465';                // SMTP 用户名  即邮箱的用户名
				$mail->Password = '*****';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
//				$mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
				$mail->Port = 25;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
			$mail->SMTPDebug = 2;

			$mail->setFrom('2868391465@qq.com', 'PHP商城');  //发件人
			$mail->addAddress($to);  // 收件人
			//$mail->addAddress('ellen@example.com');  // 可添加多个收件人
			//$mail->addCC('cc@example.com');                    //抄送
			//$mail->addBCC('bcc@example.com');                    //密送
			//发送附件
			// $mail->addAttachment('../xy.zip');         // 添加附件
			// $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名
			//Content
			$mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
			$mail->Subject = $title;
			$mail->Body    = $content .'发送时间：'. date('Y-m-d H:i:s');
			$mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

			$mail->send();
			cookie('emailCode',$code,500);
			$msg =['status'=>0,'msg'=>'发送成功'];
			echo '邮件发送成功';
			return json($msg);
		}
		catch (Exception $e) {
			$msg =['status'=>1,'msg'=>'发送失败'];
			echo '邮件发送失败: ', $mail->ErrorInfo;
			return json($msg);

		}
	}





	//判断验证用户名是否可以注册
	public function isRegistered(){
		if (request()->isAjax()){
			$username = input('username');
			$userInfo = db('user')->where(array('username'=>$username))->find();

			if ($userInfo){
				return  false;
			}else{
				return true;
			}
		}else{
			$this->error('非法请求！');
		}
	}
	//判断验证邮箱是否可以注册
	public function  checkEmail(){
		if (request()->isAjax()){
			$email = input('email');
			$userInfo = db('user')->where(array('email'=>$email))->find();
			if ($userInfo){
				return  false;
			}else{
				return true;
			}
		}else{
			$this->error('非法请求！');
		}
	}

	//异步验证邮箱验证码
	public function checkEmailSendCode(){
		if (request()->isAjax()){
			$emailCode = input('send_code');

			if ($emailCode == cookie('emailCode')){
				return  true;
			}else{
				return false;
			}
		}else{
			$this->error('非法请求！');
		}
	}

}
