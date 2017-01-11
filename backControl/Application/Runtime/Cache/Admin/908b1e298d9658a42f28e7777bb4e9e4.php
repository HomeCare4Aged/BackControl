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
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-fw fa-table"></i>
							员工列表
						</li>
					</ol>
				</div>
			</div>
            <div class="row zyn-div-search">
            	<div class="col-md-4">
	            	<form action="/home1/admin.php/Power/index" method="post" class="form-horizontal">
	            		<div class="input-group">
	            			<span class='input-group-addon'>搜索</span>
	            				<input type="text" name="search" id="" value="" placeholder="请输入员工姓名" style="line-height: 28px;width: 248px;"/>
	            			<div class="input-group-btn">
		            			<button type="submit" class="btn btn-primary">
		            				<span class='glyphicon glyphicon-search'></span>
		            			</button>
	            			</div>
	            			<div style="padding-left: 15px;"> 
					            <button type="button" class="btn btn-primary" onclick="location.href = '/home1/admin.php/Power/index'">刷新</button>
					        </div>
	            		</div>
	            	</form>
	            </div>
	            <div class="col-sm-4 col-sm-offset-1">
					<button type="button" class="btn btn-group btn-primary" id="zyn-btn-add">新增员工</button>
				</div>
            </div>
            <br/>
            <div class="row">
            	<div class="col-md-12">
            		<div class="table-responsive">
            			<form id="zyn-form-list">
            				<table class="table table-bordered table-hover zyn-table-list">
            					<thead>
            						<tr class="btn-primary">
            							<td>员工姓名</td>
            							<td>员工工号</td>
            							<td>重置密码</td>
            							<td>权限分配</td>
            							<td colspan="2">操作</td>
            						</tr>
            					</thead>
            					<tbody>
            						<?php if(is_array($acommunityinfos)): $i = 0; $__LIST__ = $acommunityinfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	            							<td style="display: none;"><?php echo ($vo["limit_id"]); ?></td>
	            							<td><?php echo ($vo["hospital_user_name"]); ?></td>
	            							<td><?php echo ($vo["hospital_user_no"]); ?></td>
	            							<td>
	            								<input id="zyn-span-psw" attr-id="<?php echo ($vo["hospital_user_id"]); ?>" value="重置密码" type="button" class="btn btn-default btn-xs"/>
	            							</td>
	            							<td>
	            							    <input attr-id="<?php echo ($vo["hospital_user_id"]); ?>" value="权限分配" type="button" class="btn btn-default btn-xs" onclick="assign11(this)" data-toggle="modal" data-target="#xx-modal-assign"/>
	            							</td>
	            							<td>
	            								<input data-toggle="modal" data-target="#Modal" value="编辑" attr-id="<?php echo ($vo["hospital_user_id"]); ?>" type="button" class="btn btn-default btn-xs" onClick="editClick(this)"/>
	            							</td>
	            							<td>	
												<input id="zyn-span-trash" attr-id="<?php echo ($vo["hospital_user_id"]); ?>" value="删除" type="button" class="btn btn-default btn-xs"/>
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
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">请输入修改员工姓名</h4>
			</div>
			<div class="modal-body">
				<form id="zyn-form-submit" class="form-horizontal">
					<div class="form-group">
						<label for="zh-input-video_type_name" class="control-label col-sm-3">员工姓名:</label>
						<div class="col-sm-7">
							<input id="zh-video_type_name" class="form-control" type="text" 
							    name="video_type_name" placeholder="请输入员工姓名"/>
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
<div class="col-sm-10">
	<!-- 模态框（Modal） -->
	<div class="modal fade" id="xx-modal-assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
									</button>
					<h4 class="modal-title" id="myModalLabel">
										分配权限
									</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<form id="zyn-form-assign-auth" class="form-inline">
								<table>
									<tr>
										<?php if(is_array($menus)): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pvo): $mod = ($k % 2 );++$k; if($pvo['limit_num'] == 0): ?><td>
													<label>
														<input type="checkbox"  value="<?php echo ($pvo["limit_tyoe_id"]); ?>" name="limit_tyoe_id[<?php echo ($k); ?>]"/>
														<?php echo ($pvo["limit_event"]); ?>
													</label>
												</td>
												<tr class="nav nav-second-level">
													
												</tr><?php endif; ?>
											<?php if($pvo['limit_num'] == 1): ?><td>
													<label>
														<input type="checkbox"  value="<?php echo ($pvo["limit_tyoe_id"]); ?>" name="limit_tyoe_id[<?php echo ($k); ?>]"/>
														<?php echo ($pvo["limit_event"]); ?>
													</label>
												</td>
												<tr class="nav nav-second-level">
													<?php if(is_array($menus)): $k = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($vo['limit_num'] == $pvo['limit_tyoe_id']): ?><td>
																<label>
																	<input type="checkbox"  value="<?php echo ($vo["limit_tyoe_id"]); ?>" name="limit_tyoe_id[<?php echo ($k); ?>]"/>
																	<?php echo ($vo["limit_event"]); ?>
																<label>
															</td><?php endif; endforeach; endif; else: echo "" ;endif; ?>
												</tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
									</tr>
								</table>
								<input name="hospital_user_id" type="hidden" value="" id="user-id-quanxian"/>
							</form>
						</div>
					</div><!--.row表单-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
										关闭
									</button>
					<button type="button" class="btn btn-primary" id="zyn-btn-assign-auth">
										提交更改
									</button>
					</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal -->
	</div>
</div>
<script>
	var SCOPE = {
		'add_url':'/home1/admin.php/Power/add',
		'set_status_url':'/home1/admin.php/Power/setStatus',
		'set_password_url':'/home1/admin.php/Power/setPsw',
		'success_jump_url':'/home1/admin.php/Power/index',
		'addn_url':'/home1/admin.php/Power/addn',
		'assign_auth_url':'/home1/admin.php/Power/assignAuth',
	};
	function editClick(obj){
	var id = $(obj).attr("attr-id");
	var tds = $(obj).parent().parent().find('td');
	$('#zh-input-id').val(id);
    $('#zh-video_type_name').val(tds.eq(1).text());  
	$().modal('show');
}
 function update1() {  
    //获取模态框数据  
    var id = $('#zh-input-id').val();
    var name = $('#zh-video_type_name').val();
    Dialog.confirm('是否确定提交数据',function(){
    $.ajax({  
        type: "post",  
        url:SCOPE.addn_url,  
        data: "id=" + id + "&video_type_name=" + name,  
        dataType: 'json',  
        contentType: "application/x-www-form-urlencoded; charset=utf-8",  
        success: function(result){  
				//链接服务器其成功
//				console.log(typeof result);
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

function assign11(obj){
		$("input:checkbox").prop('checked',false);
		var objpp = obj.parentNode.parentNode;
		var id = $(obj).attr('attr-id');
//		var objpp = obj.parentNode.parentNode;
		var msg = {};
		var postData = {};
		for (var i=0 ; i<objpp.children.length;i++){
				msg[i] = objpp.children[i].innerText;
			}
		postData['hospital_user_id'] = id;
		postData['limit_id'] = msg[0];
		var limit_ids = postData['limit_id'].split(',');
		for (var i in limit_ids){
			$("input:checkbox[value='"+limit_ids[i]+"']").prop('checked',true);
		}
		$('#user-id-quanxian').val(id);
		console.log(id);
	}
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