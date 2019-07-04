<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./template/mobile/56go/user/login.html";i:1523930805;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>登录-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
	<link rel="stylesheet" type="text/css" href="__STATIC__/css/style.css">
	<script type="text/javascript" src="__STATIC__/photoClip/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="__STATIC__/js/flexible.js"></script>
	<script type="text/javascript" src="__STATIC__/js/jquery.form.js"></script>
	<script src="__PUBLIC__/js/layer/layer.js"></script>
	<script src="__PUBLIC__/js/global.js"></script>
</head>
	<body>
		<style>
			body{background:#fff;}
		</style>
		<div class="main">
			<div class="login_box">
				<div class="login_item">
					<label class="f28">账 号</label>
					<input name="username"   id="username" placeholder="请输入手机号" class="f28" type="text" placeholder="请输入账号"/>
					<a id="user_a" href="javascript:void(0);" onclick="unshow('username');" style="display:none;position: absolute;right: 0;top:.109375rem;font-size:.75rem;color: #999;transform: rotate(45deg);">+</a>
				</div> 
				<div class="login_item">
					<label class="f28">密 码</label>
					<input  class="f28" type="password" name="password" id="password"  placeholder="请输入密码"/>
					<a id="pwd_a" href="javascript:void(0);" onclick="unshow('password');" style="display:none;position: absolute;right: 0;top:.109375rem;font-size:.75rem;color: #999;transform: rotate(45deg);">+</a>
				</div> 
				<div class="login_btn">
					<button type="button" onClick="checkSubmit()" id="login" class="gray_btn f28">登 录</button>
					<input type="hidden" name="referurl" id="referurl" value="<?php echo $referurl; ?>">
					<div class="tip">
						<a href="<?php echo U('User/forget_pwd'); ?>" class="left f22">忘记密码？</a>
						<a href="<?php echo U('User/reg'); ?>" class="right f22">立即注册</a>
					</div>
				</div>
				
			</div>
			<div class="other_login" style="display:none;">
				<h1 class="f22">第三方登录</h1>
				<ul>
					<li>
						<a href="#">
							<img src="images/login_ic_qq.png">
							<p class="f22">qq登录</p>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="images/login_ic_wx.png">
							<p class="f22">微信登录</p>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="images/login_ic_ali.png">
							<p class="f22">支付宝登录</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
<script type="text/javascript">
$(document).keyup(function(e){
	var username = $.trim($('#username').val());
	var password = $.trim($('#password').val());
	if(username){
		show_input('user_a');
	}else{
		unshow_input('user_a');
	}
	if(password){
		show_input('pwd_a');
	}else{
		unshow_input('pwd_a');
	}
  	if(username != ''&&password != ''){
  		$('#login').addClass('orange_btn');
		$('#login').removeClass('gray_btn');
	}else{
		$('#login').addClass('gray_btn');
		$('#login').removeClass('orange_btn');
	}
	
})
function unshow(id){
	$('#'+id).val('');
	$('#login').addClass('gray_btn');
	$('#login').removeClass('orange_btn');
	var username = $.trim($('#username').val());
	var password = $.trim($('#password').val());
	if(username){
		show_input('user_a');
	}else{
		unshow_input('user_a');
	}
	if(password){
		show_input('pwd_a');
	}else{
		unshow_input('pwd_a');
	}
}
function show_input(id){
	$('#'+id).show();
}
function unshow_input(id){
	$('#'+id).hide();
}
function checkSubmit()
{
	var username = $.trim($('#username').val());
	var password = $.trim($('#password').val());
	var referurl = $('#referurl').val();
  	if(username == ''){
		showErrorMsg('用户名不能为空!');
		return false;
	}
	if(!checkMobile(username) && !checkEmail(username)){
		showErrorMsg('账号格式不匹配!');
		return false;
	}
	if(password == ''){
		showErrorMsg('密码不能为空!');
		return false;
	}
	$.ajax({
		type : 'post',
		url : '/index.php?m=Mobile&c=User&a=do_login_no_verify',
		data : {username:username,password:password,referurl:referurl},
		dataType: "json",
		success : function(res){
			console.log(res);
			if(res.status == 1){
				top.location.href = res.url;
			}else{
				showErrorMsg(res.msg);
			}
			
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			showErrorMsg('网络失败，请刷新页面后重试');
		}
	})
}
function checkMobile(tel) {
    var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
    if (reg.test(tel)) {
        return true;
    }else{
        return false;
    };
}
function checkEmail(str){
    var reg = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if(reg.test(str)){
        return true;
    }else{
        return false;
    }
}
function showErrorMsg(msg){
	layer.msg(msg,{icon:2});
}
</script>		
	</body>
</html>
