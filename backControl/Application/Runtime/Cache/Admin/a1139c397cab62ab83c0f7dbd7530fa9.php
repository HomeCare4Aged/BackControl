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
	

<style>
	td{
		text-align: center;
	}
</style>
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
				<div class="col-sm-12">
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-fw fa-table"></i>
							视频浏览
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal" action="/home1/admin.php/Video/index" method="post">
						<div class="form-group">
							<div class="col-sm-2">
								<select name="zyn-select-user" id="zyn-select-choosse" class="form-control">
									<option value="0" selected="selected">我的视频</option>
									<option value="1" >全部</option>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="zyn-select-type" id="zyn-select-type" style="display:auto ;" class="form-control">
									<option value="0" selected="selected">全部状态</option>
									<option value="1">未审核</option>
									<option value="2">已通过</option>
									<option value="3">未通过</option>
								</select>
							</div>
							<div class="col-md-4">
				            	<form action="/home1/admin.php/Video/index" method="post" class="form-horizontal">
				            		<div class="input-group">
				            			<span class='input-group-addon'>搜索</span>
				            				<input type="text" name="search" id="" value="" placeholder="请输入视频标题" style="line-height: 28px;width: 248px;"/>
				            			<div class="input-group-btn">
					            			<button type="submit" class="btn btn-primary">
					            				<span class='glyphicon glyphicon-search'></span>
					            			</button>
				            			</div>
				            			<div style="padding-left: 15px;">
				            				<button type="button" class="btn btn-primary" onclick="location.href = '/home1/admin.php/Video/index'">刷新</button>
				            			</div>
				            		</div>
				            	</form>
				            </div>
				            <div class="col-sm-2 col-sm-offset-1">
								<button type="button"  id="zyn-btn-add" class="btn btn-primary">发布视频</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-12">
					<div class="table-responsive">
						<form id="zh-form-list">
							<table width="100%" class="table table-bordered table-hover zyn-table-list" id="tableID">
								<thead>
									<tr class="btn-primary">
										<td width="200px" align="left">视频标题<span class="glyphicon glyphicon-sort"></span></td>
										<td>版本号</td>
										<td>发布时间<span class="glyphicon glyphicon-sort"></span></td>
										<td>审核状态</td>
										<td width="200px" align="left">驳回原因</td>
										<td colspan="3">操作</td>
									</tr>
								</thead>
								<tbody>
									<?php if(is_array($articles)): $i = 0; $__LIST__ = $articles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
									    	<td style="display: none;"><?php echo ($vo["video_id"]); ?></td>
									    	<td><?php echo ($vo["video_title"]); ?></td>
											<td><?php echo ($vo["video_num"]); ?></td>
											<td><?php echo ($vo["send_datetime"]); ?></td>
											<td><?php echo ($vo["video_check_state"]); ?></td>
											<td><?php echo ($vo["error_message"]); ?></td>
											<td>
												<input id="zyn-span-history" onclick="clickHistory(this)" value="所有版本" type="button" class="btn btn-default btn-xs"/>
											</td>
											<td>
											    <input id="zyn-span-edit" attr-id="<?php echo ($vo["video_id"]); ?>&num=<?php echo ($vo["video_num"]); ?>" value="详情" type="button" class="btn btn-default btn-xs"/>
											 </td>
											 <td>
												<input id="zyn-span-delete1" onclick="clickDelete(this)" value="删除" type="button" class="btn btn-default btn-xs"/>
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
<script>
	var SCOPE = {
		'add_url':'/home1/admin.php/Video/add',
		'edit_url':'/home1/admin.php/Video/edit1',
		'set_status_url':'/home1/admin.php/Video/setStatus',
		'success_refresh_url':'/home1/admin.php/Video/index',
	};
	$("#zyn-select-type").on('change',function(){
		var selectedValue = $(this).val();
		$.ajax({
			type:"post",
			url:"/home1/admin.php/Video/getData",
			async:true,
			data:{'selectedValue':selectedValue},
			dataType:'json',
			success:function(data){
				console.log(data);
				$('#tableID tbody').remove();
				var sRows = '';
				for( var i in data ){
					var sRow = '<tr>'+
									'<td style="display: none;">'+data[i].video_id+'</td>'+
									'<td>'+data[i].video_title+'</td>'+
									'<td>'+data[i].video_num+'</td>'+
									'<td>'+data[i].send_datetime+'</td>'+										
									'<td>'+data[i].video_check_state+'</td>'+
//									'<td>'+data[i].check_user_id+'|'+getRoleById+'</td>'+
									'<td>'+data[i].error_message+'</td>'+
									'<td>'+
										'<input id="zyn-span-history" onclick="clickHistory(this)" value="所有版本" type="button" class="btn btn-default btn-xs"/>'+
									'</td>'+	
									'<td>'+	
									    '<input id="zyn-span-edit" onclick="clickCheck(this)" value="详情" type="button" class="btn btn-default btn-xs"/>'+
									'</td>'+    
									'<td>'+    
										'<input id="zyn-span-delete1" onclick="clickDelete(this)" value="删除" type="button" class="btn btn-default btn-xs"/>'+
									'</td>'+
								'</tr>';
					sRows += sRow;
				}
				$('#tableID').append('<tbody></tbody>');
				$('#tableID tbody').html(sRows);
				sortList()
			}
		});
	});
	$('#zyn-select-choosse').click(function(){
        if(($(this).val()) == 0){
        	$('#zyn-select-type').attr('style','display:auto');
     	    $('#zyn-select-type').val(0);
        }
        if(($(this).val()) == 1){	
        	$('#zyn-select-type').attr('style','display:none');
        }
    });
    $("#zyn-select-choosse").on('change',function(){
		var selectedValue = $(this).val();
		$.ajax({
			type:"post",
			url:"/home1/admin.php/Video/getSourse",
			async:true,
			data:{'selectedValue':selectedValue},
			dataType:'json',
			success:function(data){
				console.log(data);
				$('#tableID tbody').remove();
				var sRows = '';
				for( var i in data ){
					var sRow = '<tr>'+
									'<td style="display: none;">'+data[i].video_id+'</td>'+
									'<td>'+data[i].video_title+'</td>'+
									'<td>'+data[i].video_num+'</td>'+
									'<td>'+data[i].send_datetime+'</td>'+											
									'<td>'+data[i].video_check_state+'</td>'+
//									'<td>'+data[i].check_user_id+'|'+getRoleById+'</td>'+
									'<td>'+data[i].error_message+'</td>'+	
									'<td>'+
										'<input id="zyn-span-history" onclick="clickHistory(this)" value="所有版本" type="button" class="btn btn-default btn-xs"/>'+
									'</td>'+	
									'<td>'+	
									    '<input id="zyn-span-edit" onclick="clickCheck(this)" value="详情" type="button" class="btn btn-default btn-xs"/>'+
									'</td>'+    
									 '<td>'+   
										'<input id="zyn-span-delete1" onclick="clickDelete(this)" value="删除" type="button" class="btn btn-default btn-xs"/>'+
									'</td>'+
								'</tr>'
					sRows += sRow;
				}
				$('#tableID').append('<tbody></tbody>');
				$('#tableID tbody').html(sRows);
				sortList()
			}
		});
	});
	function clickEdit(obj){
		if($("#zyn-select-choosse").find("option:selected").val() == 1){
			Dialog.error('全部视频无法编辑和删除');
				return;
		}
		else {
			var objpp = obj.parentNode.parentNode;
			var msg = [];
			for (var i=0 ; i<objpp.children.length;i++){
				msg[i] = objpp.children[i].innerText;
			}
			if(msg[3] == '已通过'){
				Dialog.error('通过后的视频无法编辑和删除');
				return;
			}
			var id = msg[0];
		location.href = SCOPE.edit_url+'?id='+id;	
		}
	}
	function clickDelete(obj){
	if($("#zyn-select-choosse").find("option:selected").val() == 1){
		Dialog.error('全部视频无法编辑和删除');
			return;
	}
	else {
			var objpp = obj.parentNode.parentNode;
			var msg = [];
			for (var i=0 ; i<objpp.children.length;i++){
				msg[i] = objpp.children[i].innerText;
			}
			if(msg[4] != '未审核'){
				Dialog.error('不是未审核的视频无法删除');
				return;
			}
			var id = msg[0];
			var num = msg[2];
		var url = SCOPE.set_status_url;;
		var postData = {};
		postData['id'] = id;
		postData['num'] = num;	
		postData['state'] = '关闭';
		Dialog.confirm('是否确认删除数据？',function(){
			$.ajax({
				type:"post",
				url:url,
				async:true,
				data:postData,
				dataType:'json',
				success:function(result){
					if(result.status == SUCCESS){
						return result.msg,location.href =SCOPE.success_refresh_url;
					}
					return Dialog.error(result.msg);
				}
			});
		});	
	}
	}
	function clickCheck(obj){
		var objpp = obj.parentNode.parentNode;
		var id = objpp.children[0].innerText;
		var num = objpp.children[2].innerText;
		location.href = '/home1/admin.php/Video/edit1'+'?id='+id+'&num='+num;
	}
	function clickHistory(obj){
		var objpp = obj.parentNode.parentNode;
		var id = objpp.children[0].innerText;
		var postData={};
		location.href = '/home1/admin.php/Video/history'+'?id='+id;	
	}
	function sortList(){
  		$("#tableID").trigger("updateCache");
  		$("#tableID").tablesorter({headers:{8:{sorter:false},7:{sorter:false},6:{sorter:false},5:{sorter:false},4:{sorter:false},2:{sorter:false}}});
	};
	$(function(){
	$("#tableID").tablesorter({headers:{8:{sorter:false},7:{sorter:false},6:{sorter:false},5:{sorter:false},4:{sorter:false},3:{sorter:false},1:{sorter:false}}});
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