<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:43:"./template/mobile/56go/user/forget_pwd.html";i:1523930804;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>找回密码-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
			<div class="registered_box">
				<form action="<?php echo U('User/ajaxforget_pwd'); ?>" id="mobileForm" name="mobileForm" method="post"  onsubmit="return check_submit()">
				<div id="first_step">
					<div class="login_item">
						<label class="f28">手机号</label><input onBlur="checkMobilePhone(this.value);" id="mobile" name="username" class="f28" type="text" placeholder="请输入账号"/>
					</div> 
					<div class="login_item">
						<label class="f28">验证码</label>
						<input class="f28" type="text" id="mobile_code" name="mobile_code" placeholder="请输入验证码"/>
						<button type="button" class="orange f26" rel="mobile"  onClick="sendcode(this)">发送验证码</button>
						<button type="button" class="gray f26" style="display:none;" >已发送(<span id="count_down">0</span>)</button>
					</div> 
					<div class="login_btn">
						<button type="button" onclick="show_step();" class="orange_btn f28">下一步</button>
					</div>
					<div class="tip f22" style="float: right;">
						<a href="<?php echo U('User/login'); ?>" class="o_color">已有账号登陆</a>
					</div>
				</div>
				<div style="display: none;" id="second_step">
					<div class="login_item">
						<label class="f28">密码</label><input type="password" id="password" name="password" class="f28" type="text" onBlur="check_password(this.value);" placeholder="请输入密码"/>
					</div> 
					<div class="login_item">
						<label class="f28">确认密码</label><input type="password"  id="password2" name="password2" class="f28" type="text" onBlur="check_password(this.value);" placeholder="请再次输入密码"/>
					</div> 
					<div class="login_btn">
						<input type="submit" id="btn_submit" name="Submit" class="orange_btn f28" value="提 交" />
						<!--<button type="submit"  class="orange_btn f28">完成</button>-->
					</div>
				</div>
				</form>
			</div>
			
		</div>
		<script type="text/javascript">
			var flag = false;
			var currentForm="#mobileForm";
			function show_step(type){
				/*验证短信验证码*/
				$.ajax({
					type : "GET",			
					url:"/index.php?m=Home&c=Api&a=check_validate_code",//+tab,
					data :{mobile:$('#mobile').val(),code:$('#mobile_code').val(),scene:2},
					success: function(data)
					{
						if(data.status<0){
							layer.msg(data.msg,{icon:2});
						}else{
							$('#first_step').hide();
							$('#second_step').show();
						}
					}
				});		
			}
			function checkMobilePhone(mobile){
				if(checkMobile(mobile)){
					$.ajax({
						type : "GET",			
						url:"/index.php?m=Home&c=Api&a=issetMobile",//+tab,
						data :{mobile:mobile},
						success: function(data)
						{
							if(data == '0')
							{
								layer.msg('账号不存在',{icon:2});
								flag = false;
							}else{
								flag = true;
							}
						}
					});		
				}else{
					layer.msg('请正确填写手机号码',{icon:2});
				}
			}
			function check_password(password) {
				if (password.indexOf(" ") != -1) {
					layer.msg('密码不能包含空格',{icon:2});
					flag = false;
				} else if (password.length < 6) {
					layer.msg('密码不能少于 6 个字符',{icon:2});
					flag = false;
				}else{
					flag = true;
				}
			}
			
			function check_confirm_password(confirm_password) {
				var password = $(currentForm).find('#password').val();
				if (password.indexOf(" ") != -1) {
					layer.msg('确认密码不能包含空格',{icon:2});
					flag = false;
					return false;
				}
				if (confirm_password.length < 6) {
					layer.msg('登录密码不能少于 6 个字符',{icon:2});
					flag = false;
					return false;
				}
				if (confirm_password != password) {
					layer.msg('两次密码不一致',{icon:2});
					flag = false;
				} else {
					flag = true;
				}
			}
			
			
			function check_submit()
			{ 
				var username = $.trim($('#mobile').val());
				var password = $(currentForm).find('#password').val();
				var password2= $(currentForm).find('#password2').val();		
				if(username.length >0 && password.length > 0 && password2.length > 0 && flag)
				{
					return true;
				} else{
					return false;	
				}
					 
			}
			
			function sendcode(o){
				if(flag){
					$.ajax({
						url:  '/index.php?m=Home&c=Api&a=send_validate_code&t='+Math.random() ,
						type:'post',
						dataType:'json',
						data:{type:$(o).attr('rel'),send:$.trim($('#mobile').val()) , scene:2},
						success:function(res){	 
							if(res.status==1){
								layer.msg(res.msg,{icon:1});
								$('.orange').hide();
								$('.gray').show();
								countdown();
							}else{
								layer.msg(res.msg,{icon:2});
							}
						}
					})
				}
			}
			
			var wait = 60;
			function countdown() {
				if (wait <=0) {
					$('.orange').show();
					$('.gray').hide();
					wait = 60;
				} else {
					$("#count_down").html(wait+'秒');
					wait--;
					setTimeout(function() {
						countdown();
					}, 1000)
				}
			}
		</script>
	</body>
</html>
