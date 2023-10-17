<?php

namespace app\member\controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\Controller;
use app\index\controller\Base;



//Base是继承和头部低部类
class Account extends Base
{
	//注册
	public function reg()
	{
		if (request()->isPost()){
			$data=input('post.');
			//验证
			$validate = validate('User');
			if(!$validate->check($data)){
				dump($validate->getError());
			}
			$userDate = array();
			$userDate['username']=$data['username'];
			$userDate['password']=md5($data['password']) ;
			$userDate['email']=$data['email'];
//			$userDate['mobile_phone']=$data['mobile_phone']; //没有短信验证次数
			$userDate['register_type']=$data['register_type'];
			$userDate['reg_time']=time();
			//执行注册
			$add = db('user')->insert($userDate);
			if ($add){
				$loginRes=$this->login($data,1);//登录成功后，自动登入系统
				if($loginRes['error'] == 0){
					$this->success("注册成功!正在为您跳转...",'member/User/index');
				}else{
					$this->success("注册成功!正在为您跳转...",'member/Account/login');
				}
			}else{
				$this->error("注册失败!");
			}
		}
		return view();
	}
	//登入
	public function login($type=0){//type=0说明需要为客户端返回json对象，type=1说明要为服务端返回普通数组类型
		if (request()->isPost()){
			$data = input('post.');
//			$backAct = $data['back_act'];
			return model('User')->login($data,$type);
		}
		return view();
	}
	//退出登入
	public function checkLogin(){
		$uid =session('uid');
		if ($uid){
			//成功状态
			$arr['error']=0;
			$arr['uid']=$uid;
			$arr['username']=session('username');
			return json($arr);
		}else{
			if (cookie('username')&&cookie('password')){
				//解密
				$data['username']=encryption(cookie('username'),1);
				$data['password']=encryption(cookie('password'),1);
				$loginRes = model('User')->login($data,1);
				if ($loginRes['error'] == 0){
					$arr['error']=0;
					$arr['uid']=$uid;
					$arr['username']=session('username');
					return json($arr);
				}
			}
			$arr['error']=1;
			return json($arr);

		}

	}
	//短信验证码
	public function sendMsg($type=0,$password=0)
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
		$smsapi = "http://api.smsbao.com/";
		$user = "***"; //短信平台帐号
		$pass = md5("****"); //短信平台密码
		$content=mt_rand(100000,999999);//要发送的短信内容
		//type:0表示注册场景，1代表手机找回密码场景 ，2向用户发送密码
		$tipMsg = '';
		if ($password == 0){
			$tipMsg= '您好，您的验证码是：'.$content;
		}else{
			$tipMsg= '您好，您的密码是：'.$password.'请妥善保管';

		}
		if ($password == 0){
			$phoneNum =trim(input('phoneNum'));

		}else{
			$phoneNum = session('getPasswordPhoneNum');
		}
		$phoneNum = trim(input('phoneNum'));//要发送短信的手机号码
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phoneNum."&c=".urlencode($tipMsg);
		$result =file_get_contents($sendurl) ;
		if (!is_null(json_decode($result))){
			$output = json_decode($result,true);
			if (isset($output['code']) && $output['code']=='0'){
				if ($type == 0){
					session('mobileCode',$content);
				}else{
					session('getPasswordCode',$content);
					session('getPasswordPhoneNum',$phoneNum);
				}
				$msg=['status'=>0,'msg'=>'发送成功'];
				return json($msg);
			}else{
				$msg=['status'=>1,'msg'=>$output['errorMsg']];
				return json($msg);
			}
		}else{
			$msg=['status'=>2,'msg'=>'内容错误'];
			return json($msg);
		}

	}
	//邮箱发送
	public function sendMail($email='',$password='')
	{
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions

		if ($email){//找回密码场景
			$to=$email;
		}else{//用邮箱注册场景
			$to=input('email');
		}
		$title='B2C商城验证码';
		$code = mt_rand(100000, 999999);
		$content='';
		if ($password){
			$content='您的新密码是：'.$password.'请妥善保管！';

		}else{
			$content='您的验证码是：'.$code;
		}

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
	//找回密码
	public function getPassword() {
		return view();
	}
	//验证手机号并发送短信
	public function checkSendMsg(){
		$data = input('post.');
		$phoneNum =trim($data['phoneNum']);//自动去掉前后空格
		//如果手机号存在
		if ($phoneNum){
			$users=db('user')->where(array('mobile_phone'=>$phoneNum))->find();
			if ($users){
				return $this->sendMsg(1);
			}
			else{
				$arr['msg'] = '手机号不存在';
				$arr['status'] = 1;
				return json($arr);
			}
		}else{
			$arr = array();
			$arr['msg'] = '请填写手机号';
			$arr['status'] = 1;
			return json($arr);
		}

	}

	//找回密码时候验证手机验证码是否正确
	public function checkPhoneCode(){
		$data=input('post.');//接收
		$mobileCode = trim($data['mobile_code']);//拿到验证码
		$sCode=session('getPasswordCode');
		$mobilePhone=session('getPasswordPhoneNum');
		if ($sCode == $mobileCode){
			$password=mt_rand(1000000,9999999);
			$_password=md5($password);
			$update= db('user')->where(array('mobile_phone' => $mobilePhone))->update(['password' => $_password]);
			if ($update){
				//修改密码成功
				$this->sendMsg(2,$password);
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	//通过用户名和邮箱找回密码
	public function  sendPwdEmail(){

		$data = input('post.');
		//接收提交过来的的值，
		/**
		 * 先找这个对应的用户名
		 * 再根据用户名找到对应的其他的条件
		*/
		$userData['username']=trim($data['user_name']); //trim取出空格
		$userData['email']=trim($data['email']);
		//信息对比
		$users=db('user')->where(array('username'=>$userData['username']))->find();
		//用户名比对
		if ($users){
			//邮箱比对
			if ($users['email'] == $userData['email']){//
				$password=mt_rand(1000000,9999999);//发送随机密码
				$_password=md5($password);
				$update= db('user')->where(array('email'=>$userData['email']))->update(['password' => $_password]);//更新密码
				if ($update){
					//修改密码成功
					$_msg=$this->sendMail($userData['email'],$password);//接收新密码
					$msg=json_decode($_msg,true);//转换城数组
						$msg['status']=0;
						$msg['msg']='修改密码成功！';
				}
				else{
					$msg['status']=3;
					$msg['msg']='修改密码失败！';
				}
			}
			else{
				 $msg['status']=2;
				 $msg['msg']='邮箱不匹配，请重新输入！';
				}
		}
		else{
			$msg['status']=1;
			$msg['msg']='用户名不匹配，请重新输入！';
		}
		$this->assign([
			'show_right' =>1,
			'status' =>$msg['status'],
			'msg' =>$msg['msg'],
		]);
		return view('index@/common/tip');
	}

}
