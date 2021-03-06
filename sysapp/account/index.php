<?php
	require('../../global.php');

	//验证是否登入
	if(!checkLogin()){
		redirect('../error.php?code='.$errorcode['noLogin']);
	}
	$member = $db->get('tb_member', '*', array(
		'tbid' => session('member_id')
	));
	$global_title = 'index';
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>基本信息</title>
	<?php include('sysapp/global_css.php'); ?>
	<script type="text/javascript">
	//cookie前缀，避免重名
	var cookie_prefix = '<?php echo $_CONFIG['COOKIE_PREFIX']; ?>';
	</script>
</head>
<body>
	<?php include('global_title.php'); ?>
	<form class="form-horizontal">
		<div class="well">
			<div class="form-group">
				<label class="col-sm-3 control-label">用户名：</label>
				<div class="col-sm-9">
	    			<p class="form-control-static"><?php echo $member['username']; ?></p>
			    </div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">注册时间：</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php echo $member['regdt']; ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">最近一次登录时间：</label>
				<div class="col-sm-9">
					<?php echo $member['lastlogindt']; ?>
					<a href="security.php" class="btn btn-link">如果不是你登录的，请及时修改密码</a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">最近一次登录IP：</label>
				<div class="col-sm-9">
					<p class="form-control-static"><?php echo $member['lastloginip']; ?></p>
				</div>
			</div>
			<?php if(QQ_AKEY && QQ_SKEY){ ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">QQ：</label>
				<div class="col-sm-9">
					<?php if($member['openid_qq'] != ''){ ?>
						<img src="<?php echo $member['openavatar_qq']; ?>" class="img-circle img-thumbnail" width="36" height="36">
						<?php echo $member['openname_qq']; ?>
						<a href="javascript:;" class="btn btn-default unbind" data-type="qq">解除绑定</a>
					<?php }else{ ?>
						<a href="javascript:;" class="btn btn-default bind" data-type="qq">绑定</a>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			<?php if(WEIBO_AKEY && WEIBO_SKEY){ ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">新浪微博：</label>
				<div class="col-sm-9">
					<?php if($member['openid_weibo'] != ''){ ?>
						<a href="<?php echo $member['openurl_weibo']; ?>" target="_blank">
							<img src="<?php echo $member['openavatar_weibo']; ?>" class="img-circle img-thumbnail" width="36" height="36">
							<?php echo $member['openname_weibo']; ?>
							<i class="glyphicon glyphicon-share"></i>
						</a>
						<a href="javascript:;" class="btn btn-default unbind" data-type="weibo">解除绑定</a>
					<?php }else{ ?>
						<a href="javascript:;" class="btn btn-default bind" data-type="weibo">绑定</a>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</form>
	<?php include('sysapp/global_js.php'); ?>
	<script>
	var childWindow, interval;
	$(function(){
		$('.bind').click(function(){
			checkUserLogin();
			childWindow = window.open('../../connect/' + $(this).data('type') + '/redirect.php', 'LoginWindow', 'width=850,height=520,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1');
		});
		$('.unbind').click(function(){
			$.ajax({
				type : 'POST',
				url : 'ajax.php',
				data : 'ac=unbind&fromsite=' + $(this).data('type')
			}).done(function(){
				location.reload();
			});
		});
	});
	function checkUserLogin(){
		Cookies.remove(cookie_prefix + 'fromsite');
		interval = setInterval(function(){
			getLoginCookie(interval);
		}, 500);
	}
	function getLoginCookie(){
		if(Cookies.get(cookie_prefix + 'fromsite')){
			childWindow.close();
			window.clearInterval(interval);
			var title;
			switch(Cookies.get(cookie_prefix + 'fromsite')){
				case 'qq': title = 'QQ'; break;
				case 'weibo': title = '新浪微博'; break;
				default: return false;
			}
			//验证该三方登录账号是否已绑定过本地账号，没有则绑定到自己账号
			$.ajax({
				url:'ajax.php',
				data:'ac=3loginBind',
				success: function(msg){
					if(msg == 'ERROR_LACK_OF_DATA'){
						window.parent.ZENG.msgbox.show('未知错误，建议重启浏览器后重新操作', 1, 2000);
					}else if(msg == 'ERROR_OPENID_IS_USED'){
						window.parent.ZENG.msgbox.show('该' + title + '账号已经绑定过其它本地账号', 1, 2000);
					}else{
						location.reload();
					}
				}
			});
		}
	}
	</script>
</body>
</html>