<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="panel panel-info">
			    <div class="panel-heading" role="tab" id="headingOne">
			        <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				                医院列表
				        </a>
				    </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			        <div class="panel-body">
				        <div class="row">
						    <div class="col-sm-12">
						    	<div class="table-responsive">
									<form id="zh-form-list">
										<table class="table table-bordered table-hover">
											<thead>
												<tr class="btn-primary">
													<td>医院名称</td>
													<td>医院地址</td>
													<td>联系方式</td>
												</tr>
											</thead>
											<tbody>
												<?php if(is_array($communityhospitalsinfos)): $i = 0; $__LIST__ = $communityhospitalsinfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
													    <td><?php echo ($vo["community_hospitals_name"]); ?></td>
														<td><?php echo ($vo["community_hospitals_address"]); ?></td>
														<td><?php echo ($vo["principal_contact_phone"]); ?></td>
													</tr><?php endforeach; endif; else: echo "" ;endif; ?>
											</tbody>
										</table>
									</form>
									<nav>
										<ul class="pagination">
											<?php echo ($pageRes); ?>
										</ul>
									</nav>
								</div>
						    </div>
						</div>
			        </div>
			    </div>
			</div>
			<div class="panel panel-info">
			    <div class="panel-heading" role="tab" id="headingTwo">
			        <h4 class="panel-title"> 
			            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			                        商户列表   
			            </a>
			        </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			        <div class="panel-body">
				        <div class="row">
						    <div class="col-sm-12">
						    	<div class="table-responsive">
									<form id="zh-form-list">
										<table class="table table-bordered table-hover">
											<thead>
												<tr class="btn-primary">
													<td>商户名称</td>
													<td>商户地址</td>
													<td>联系方式</td>
												</tr>
											</thead>
											<tbody>
												<?php if(is_array($storeshopinfos)): $i = 0; $__LIST__ = $storeshopinfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
													    <td><?php echo ($vo["store_shop_name"]); ?></td>
														<td><?php echo ($vo["store_shop_address"]); ?></td>
														<td><?php echo ($vo["store_contact_user_phone"]); ?></td>
													</tr><?php endforeach; endif; else: echo "" ;endif; ?>
											</tbody>
										</table>
									</form>
									<nav>
										<ul class="pagination">
											<?php echo ($pageRes2); ?>
										</ul>
								   </nav>
							    </div>
					        </div>
					    </div> 
			        </div>
			    </div>
			</div> 
		</div>
	</div>
</div>
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