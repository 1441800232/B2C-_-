<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "9021000128677348",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAg298swM8fzukJZP7cCBlxk9EuBWif9j2pmSkOSg/FyDjwJhMMHx2GGxpI/1fQS3A7/nT+Yrcok2RQG/mJ84o5JOev/H6u2m5nEESg44v0wssMNftJPFd/7ZOdtMYuk8sw1m1qxMIoZkIpZrfkGytCawsOb/uuNEFdiV7jWqIi6J7/u6gprCnz61LwAB/a+Iwx2mvLIwsQ5m8vWmsbeeJ8p7y34gCVxL5iAvo1M08VGjSrcVD2bYvuRPl7zTyI8fcc//hT2pvO5pDdasXRQ61c8Ntg5P8ilnGwt/AdA2Y6LEngZHiUsfqdygY/EV3qUNxnTtUf31p9aAf8CCVIJZsIQIDAQABAoIBAAygcUJhVTaD7EkP5l/nPN/ITbnBmlLd7RQfJwe2rhjyt+6QswEVc+L0x0UF2ljQpHBpd8vJY1jUStf96AZ678LFy8J05LmMdqBkP/sTddS4hg5LMCUUawtd4DvaG84KPSqnO6Srt3CO2x3NuxyM1DLRr438ulpW+kdXYn87dNK1Lh7poU5wFyrKmFjw07/s+kXA8uT3MXI8lGUuwDmY5H6ehQ0afO3kQ+Puak1xwT0/d/nqYJAi3OfhUHAFNbRtdeDKc/DhgOMPYN/vstoA4/gPn10qniElFdnGM0D2ynKPGs0ycL6lRt/Mu1SnMYhVY9uPhbZqCESsOL0XEc53QAECgYEAvreP79rVISikQbqC7NufSAemi3HPlGi/QDi1N1V7tu9uSeK19cf3z97HcMFhNSknugbZ+jYOz56P5h3zKl/+2w4Bn7F2ks+U4rSiOib8IRkYrP0CH8opStYj8grijMi5mdczLc6q/dE3PJG04Xpcuxa7fhb+NatqyDZpEMMVm0ECgYEAsG0c+VUSRXpmRMEh+flMlBBNXBa1LRpdTpTXXk+soj1LLy7u6ra+DvrSCkwumj0dwMS/7IFcB4OnxI+lFcROmq3eL5c5ucGPdua+lc+GyfzWsGRVjOcXzZ4szSTGZTLFPcupR4BKPXAfP+W+2dylz4ijkTTJbEqtJzRbgYmy+OECgYAok/XUGsNuIq+QLJbevnvNX5NX6Ac6lG7cwzQLaezAp4DXx5zfhoR7ffMBUqPUI8WIFx0Z15afJiWH2Kd8RKB9CyXdTGzmH7SV58j8hn7uq+BMLijdiq3udlF/lkFNoweaa+c/v9Ex3+nYwUezEc3ZIKUT1uCPmsFFiA4iut9GAQKBgC1yTg5kPaqsFwALCCeOco2JjYP1TYJq0jJV4QyoVX4Nb/qdimnn3RmavtRsP2z35Vws0oun3v8IiQT3Q71RrjXmJ9/2gqY5GC22zs1kggIyIVOa5PbA6L7MyhmmKX0UEP8UIW0LvRQKd+JL2lfgoM3PEuNqx6AftG7u68t4nyPBAoGBAKJe0s03PTLOO4/RM+jOkII+p4AG1YMNRQ+AS8oBNQkGNd99AvIF++XM+n7NfKFetvjLNWdLxbUcrqAiRnx0lDy8JcQwLQ640PDLib3YXNHAb28J74KNYyb1+K1VMS/ermCaNhLCEgL/juzh/1oD6e83fwicNdurh+22ehFtRd2n",
		
		//异步通知地址
//		'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://127.0.0.1/shop/paySuccess.html",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkeFhQ/BCebVztzfEF7vnp3g2i2Ux63NDjZdntE3iPfjOJoMXvTzKNbDw2XwSVma8dYFJpcbwAupFu/fJYTkgDfEYtjPvkhg4CayWZH1VHJgzuU0YqMb9xDFuSkKSLoEtt0Q0gxrgKhGCzYFB/Cb6ZmMC8r1WWZhv7GJ9TC89sFIu5lNj3SMFb2E4gG+GJgoZGm6ecHRhOK1lKI3h6qNimMNpiVxKbuRn/2VCdqceVPSp5yUAX6iPhlIsF4O1EUpeifFtbjG2fkkZ0cXhg3jX2aW8iN1NZ6NWBzMikVkGlnBiPERmaxV8p1vL5CfNSDG+T45uVFqkgrT8h639eLUZLwIDAQAB",

        //日志路径
        'log_path' => "http://127.0.0.1/shop/pay/alipay.treade/log",
);