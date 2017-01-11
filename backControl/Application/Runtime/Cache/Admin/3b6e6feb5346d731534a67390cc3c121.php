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
		<div class="container-fluid">
			<!--面包屑导航.row-->
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-fw fa-table"></i>
							视频类型列表
						</li>
					</ol>
				</div>
			</div>
			<div class="row zyn-div-search">
            	<div class="col-md-4">
	            	<form action="/home1/admin.php/Type/index" method="post" class="form-horizontal">
	            		<div class="input-group">
	            			<span class='input-group-addon'>搜索</span>
	            				<input type="text" name="search" id="" value="" placeholder="请输入视频类型" style="line-height: 28px;width: 248px;"/>
	            			<div class="input-group-btn">
		            			<button type="submit" class="btn btn-primary">
		            				<span class='glyphicon glyphicon-search'></span>
		            			</button>
	            			</div>
	            			<div style="padding-left: 15px;">
	            				<button type="button" class="btn btn-primary" onclick="location.href = '/home1/admin.php/Type/index'">刷新</button>
	            			</div>
	            		</div>
	            	</form>
	            </div>
	            <div class="col-sm-4 col-sm-offset-1">
				<button type="button" class="btn btn-group btn-primary" data-toggle="modal" data-target="#myModal">新增视频类型</button>
				</div>
            </div>
            <br/>
			<!--表单.row-->
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<form id="zh-form-list">
							<table class="table table-bordered table-hover zyn-table-list" id="table">
								<thead>
									<tr class="btn-primary">
										<td style="width: 50%;">视频类型</td>
										<td colspan="2">操作</td>
									</tr>
								</thead>
								<tbody>
									<?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
											<td><?php echo ($vo["video_type_name"]); ?></td>
											<td>
												<input data-toggle="modal" data-target="#Modal" value="编辑" attr-id="<?php echo ($vo["video_type_id"]); ?>" type="button" class="btn btn-default btn-xs" onClick="editClick(this)"/>
											</td>
											<td>	
												<input id="zyn-span-trash" attr-id="<?php echo ($vo["video_type_id"]); ?>" value="删除" type="button" class="btn btn-default btn-xs" />
											</td>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">请输入新增视频类型</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="zh-input-video_type_name" class="control-label col-sm-3">视频类型:</label>
						<div class="col-sm-7">
							<input id="zh-input-video_type_name" class="form-control" type="text" 
							    name="video_type_name" placeholder="请输入视频类型"/>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" onclick="update()">提交</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">请输入修改视频类型</h4>
			</div>
			<div class="modal-body">
				<form id="zyn-form-submit" class="form-horizontal">
					<div class="form-group">
						<label for="zh-input-video_type_name" class="control-label col-sm-3">视频类型:</label>
						<div class="col-sm-7">
							<input id="zh-video_type_name" class="form-control" type="text" 
							    name="video_type_name" placeholder="请输入视频类型"/>
						</div>
						<input type="hidden" id="zh-input-id" name="id"/>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" onclick="update1()">确定</button>
			</div>
		</div>
	</div>
</div>
<script>
	var SCOPE = {
		'set_status_url':'/home1/admin.php/Type/setStatus',
		'success_jump_url':'/home1/admin.php/Type/index',
		'video_add':'/home1/admin.php/Type/videoadd',
	};
	 function update() {  
    //获取模态框数据  
    var name = $('#zh-input-video_type_name').val();
	Dialog.confirm('是否确定提交数据',function(){
    $.ajax({  
        type: "post",  
        url:SCOPE.video_add,  
        data: "video_type_name=" + name,  
        dataType: 'json',  
        contentType: "application/x-www-form-urlencoded; charset=utf-8",  
        success: function(result){  
				//链接服务器其成功
				console.log(typeof result);
				if(result.status == SUCCESS){
					//成功
					result.msg,location.href =SCOPE.success_jump_url;
				}else{
					 Dialog.error(result.msg);
					
				}
			},
    });
    });
};

function editClick(obj){
	var id = $(obj).attr("attr-id");
	var tds = $(obj).parent().parent().find('td');
	$('#zh-input-id').val(id); 
    $('#zh-video_type_name').val(tds.eq(0).text());  
	$().modal('show');
}
 function update1() {  
    //获取模态框数据  
    var id = $('#zh-input-id').val();
    var name = $('#zh-video_type_name').val();
	Dialog.confirm('是否确定提交数据',function(){
    $.ajax({  
        type: "post",  
        url:SCOPE.video_add,  
        data: "id=" + id + "&video_type_name=" + name,  
        dataType: 'json',  
        contentType: "application/x-www-form-urlencoded; charset=utf-8",  
        success: function(result){  
				//链接服务器其成功
				if(result.status == SUCCESS){
					//成功
					result.msg,location.href =SCOPE.success_jump_url;
				}else{
					 Dialog.error(result.msg);
					
				}
			},
		});
    });  
};
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