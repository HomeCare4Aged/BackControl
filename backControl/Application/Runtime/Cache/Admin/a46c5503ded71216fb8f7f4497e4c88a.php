<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" href="/home1/public/css/functional.css" />
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>居家养老服务平台管理系统</title>
	
	<link rel="stylesheet" href="/home1/public/css/bootstrap.css" />
	<link rel="stylesheet" href="/home1/public/css/sb-admin-2.css" />
	<link rel="stylesheet" href="/home1/public/css/metisMenu.css" />
	<link rel="stylesheet" href="/home1/public/css/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="/home1/public/css/vendor/uploadify/uploadify.css" />
	<link rel="stylesheet" href="/home1/public/css/laydate.css" />
	<link rel="stylesheet" href="/home1/public/css/vendor/default/laydate.css" />
	<link rel="stylesheet" href="/home1/public/css/fz-video.css" />
	<link rel="stylesheet" href="/home1/public/css/iconfont.css" />
	<link rel="stylesheet" href="/home1/public/css/admin/common.css" />
	
	<script type="text/javascript" src="/home1/public/js/jquery.1.11.1.js" ></script>
    <script type="text/javascript" src="/home1/public/js/dialog/layer.js" ></script>
	<script type="text/javascript" src="/home1/public/js/dialog.js" ></script>
	<script type="text/javascript" src="/home1/public/js/vendor/uploadify/jquery.uploadify.js" ></script>
	<script type="text/javascript" src="/home1/public/js/vendor/kindeditor/kindeditor-all.js"></script>
	<script type="text/javascript" src="/home1/public/js/laydate.dev.js"></script>
	<script type="text/javascript" src="/home1/public/js/laydate.js" ></script>
	 <script type="text/javascript" src="/home1/public/js/bootstrap.js" ></script>
	 <script type="text/javascript" src="/home1/public/js/metisMenu.js" ></script>
	<script type="text/javascript" src="/home1/public/js/sb-admin-2.js" ></script>
	</head>
	<body>
	

<div id="wrapper">
	<?php
$admin = session(C('ADMIN_SESSION')); $user = $admin['hospital_user_name']; $where = array( 'community_hospitals_id' => array('eq',$admin['community_hospitals_id']), ); $admin = array( 'hospital_user_id' => $nav_admin['hospital_user_id'], ); $res = D('h_hospitals_info')->where($where)->find(); $hospital = $res["community_hospitals_name"]; $nav_user = D('h_user_limit_info')->where($admin)->find(); $role_menu_ids = $nav_user['limit_id']; $nav_menus = D('a_limit_type_info')->select($role_menu_ids); $role = D('h_user_limit_info')->find($admin['hospital_user_id']); $index = 'index'; ?>
<!--后台管理系统的导航栏-->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a href="#" class="navbar-brand">居家养老服务平台管理系统</a>
	</div>
	<ul class="nav navbar-right top-nav" style="padding-right:20px ;">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-fw fa-user"></i><?php echo ($hospital); ?> | <?php echo ($user); ?><i class="caret"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="/home1/admin.php/Login/logout"><i class="fa fa-fw fa-power-off "></i>注销</a>
				</li>
			</ul>
		</li>
	</ul>
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav in" id="side-menu">
				<li>
					<a href="/home1/admin.php/Index/index"><i class="fa fa-fw fa-home"></i>首页</a>
				</li>
				<?php if(is_array($nav_menus)): $i = 0; $__LIST__ = $nav_menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pvo): $mod = ($i % 2 );++$i; if($pvo['limit_num'] == 0): ?><li>
							<a href="/home1/admin.php/<?php echo ($pvo["limit_controller"]); ?>/<?php echo ($pvo["limit_action"]); ?>">
								<i class="fa fa-fw fa-cogs"></i><?php echo ($pvo["limit_event"]); ?>
							</a>
						</li><?php endif; ?>
					<?php if($pvo['limit_num'] == 1): ?><li>
							<a href="#">
								<i class="fa fa-fw fa-cogs"></i><?php echo ($pvo["limit_event"]); ?>
								<span class="fa arrow"></span>
							</a>
							<ul class="nav nav-second-level">
								<?php if(is_array($nav_menus)): $i = 0; $__LIST__ = $nav_menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['limit_num'] == $pvo['limit_tyoe_id']): ?><li>
											<a href="/home1/admin.php/<?php echo ($vo["limit_controller"]); ?>/<?php echo ($vo["limit_action"]); ?>">
												<i class="fa fa-fw fa-cog"></i><?php echo ($vo["limit_event"]); ?>
											</a>
										</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</ul>
								<!-- /.nav-second-level二级目录下拉 -->
						</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				
				
				
				
				
				
				<!--<li>
					<a href="/home1/admin.php/Community/index"><i class="icon-building"></i>社区管理</a>
				</li>
				<li>
					<a href="/home1/admin.php/HospitalRegister/index"><i class="fa fa-fw fa-edit"></i>账号管理</a>
				</li>
				<li>
					<a><i class="fa fa-fw fa-film"></i>商铺管理<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="/home1/admin.php/Store/index"><i class="fa fa-fw fa-newspaper-o"></i>浏览商铺</a>
						</li>
						<li>
							<a href="/home1/admin.php/Store/check"><i class="fa fa-fw fa-university"></i>商铺审核</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="/home1/admin.php/Announcement/index"><i class="fa fa-fw fa-newspaper-o"></i>公告管理<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="/home1/admin.php/Announcement/index"><i class="fa fa-fw fa-newspaper-o"></i>公告浏览</a>
						</li>
						<li>
							<a href="/home1/admin.php/Announcement/check"><i class="fa fa-fw fa-university"></i>公告审核</a>
						</li>
					</ul>
				</li>
				<li>
					<a><i class="fa fa-fw fa-film"></i>视频管理<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="/home1/admin.php/Video/index"><i class="fa fa-fw fa-newspaper-o"></i>视频浏览</a>
						</li>
						<li>
							<a href="/home1/admin.php/Video/check"><i class="fa fa-fw fa-university"></i>视频审核</a>
						</li>
					</ul>
				</li>
				<li>
					<a><i class="fa fa-fw fa-film"></i>类型管理<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="/home1/admin.php/Type/index"><i class="fa fa-fw fa-newspaper-o"></i>视频类型管理</a>
						</li>
						<li>
							<a href="/home1/admin.php/Type/notice"><i class="fa fa-fw fa-university"></i>公告类型管理</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="/home1/admin.php/Power/index"><i class="fa fa-fw fa-film"></i>员工管理</a>
				</li>-->
				<li>
					<a href="/home1/admin.php/Account/index"><i class="fa fa-fw fa-film"></i>账号信息</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

				
	<div id="page-wrapper">
		<div class="container-fluid">
			<!--面包屑导航.row-->
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-fw fa-table"></i>
							<a href="/home1/admin.php/Video/check">视频审核列表</a>
						</li>
						<li class="active">
							<i class="fa fa-fw fa-edit"></i>
							视频审核
						</li>
					</ol>
				</div>
			</div>
			<!--表单.row-->
			<div class="row">
				<video id="myVideo" width="700" height="270" controls style="position: absolute;margin-left: 15px;">
					<source src="http://www.kphp.org/html5/kphp.mp4" type="video/mp4">
					<source src="http://www.kphp.org/html5/kphp.ogv" type="video/ogg">
					kphp框架提醒您：您的浏览器不支持 video 标签。
				</video>
		        <div class="col-sm-4 col-sm-offset-8">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4">视频标题:</label>
							<label class="control-label"><?php echo ($menu["video_title"]); ?></label>	
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">视频时长:</label>
							<label class="control-label"><?php echo ($menu["video_length"]); ?></label>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">发布时间:</label>
							<label class="control-label"><?php echo ($menu["send_datetime"]); ?></label>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">发布人:</label>
							<label class="control-label"><?php echo ($menu["hospital_user_name"]); ?></label>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">视频类型:</label>
							<label class="control-label"><?php echo ($menu["video_type_name"]); ?></label>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">审核状态:</label>
							<label class="control-label"><?php echo ($menu["video_check_state"]); ?></label>
							<button type="button" class="btn btn-danger btn-xs"
						        data-container="body" data-toggle="popover" data-placement="bottom"
						        data-content="<?php echo ($menu["error_message"]); ?>" <?php if($menu['video_check_state'] != 未通过): ?>style="display:none ;"<?php endif; ?>>
						        驳回原因
						    </button>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" style="border: 1px solid #dddddd;position: relative;margin-top: 35px">
						<label class="label_name" style="background-color: #FFF;position: absolute;top: -20px;font-size: 18px;left: 20px !important;padding: 5px 20px;">视频简介</label>
						<div style="margin: 20px;line-height: 24px;">
						<?php echo ($menu["video_introduction"]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="padding-left: 15px;">
				<form id="zyn-form-submit" style="display: none;">
			        <textarea name="error_message" rows="4" cols="143" placeholder="请输入驳回原因"></textarea>
			        <input type="hidden" name="id" value="<?php echo ($menu["video_id"]); ?>" />
			        <input type="hidden" name="num" value="<?php echo ($menu["video_num"]); ?>"/></br>
			        <div class="col-sm-6 col-sm-offset-3">
				        <button type="button" class="btn btn-primary  col-md-offset-3" id="zyn-btn-submit">提交</button>
				        <button id="zyn-btn-abolish" type="button" class="btn btn-group" >取消</button>
			        </div>
			     </form>
		</div>
		<div id="zyn-div-submit" style="display: outo;" class="col-sm-4 col-sm-offset-4">
			<form id="zyn-form-addtwo">
				<input type="hidden" name="idtwo" value="<?php echo ($menu["video_id"]); ?>"/>
				<input type="hidden" name="numtwo" value="<?php echo ($menu["video_num"]); ?>"/>
			</form>
			<button <?php if($menu['video_check_state'] == 已通过 || $menu['video_check_state'] == 未通过): ?>style="display:none ;"<?php endif; ?> type="button" id="zyn-btn-add-submittwo" class="btn btn-primary">通过</button>
			<button id="zyn-btn-reject" <?php if($menu['video_check_state'] == 已通过 || $menu['video_check_state'] == 未通过): ?>style="display:none ;"<?php endif; ?> type="button" class="btn btn-danger">驳回</button>
			<input type="button" class="btn btn-group" onclick="javascript:history.back(-1);" value="返回上一页">
		</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/home1/public/js/flowplayer.min.js" ></script>
<script>
	var SCOPE = {
		'add_url':'/home1/admin.php/Video/add',
		'type_url':'/home1/admin.php/Video/add',
		'success_jump_url':'/home1/admin.php/Video/check',
	};
	
    $('#zyn-btn-reject').click(function(){
        $('#zyn-form-submit').attr('style','display:auto');
        $('#zyn-div-submit').attr('style','display:none');
    });
    $('#zyn-btn-abolish').click(function(){
        $('#zyn-form-submit').attr('style','display:none');
        $('#zyn-div-submit').attr('style','display:auto');
    });
    
    $(function () { 
		$("[data-toggle='popover']").popover();
	});
</script>
    <script type="text/javascript" src="/home1/public/js/constants.js" ></script>
    <script type="text/javascript" src="/home1/public/js/admin/common.js" ></script>
    <script type="text/javascript" src="/home1/public/js/jquery.tablesorter.js" ></script>
	<script  type="text/javascript">
	laydate({

            elem: '#J-xl'
	});
		</script>
	</body>
</html>