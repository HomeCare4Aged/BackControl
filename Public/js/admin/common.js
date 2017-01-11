$(document).ready(function(){
	
	//为模块首页的新增按钮添加事件
	$('#zyn-btn-add').click(function(){
		location.href = SCOPE.add_url;
	});

	//为提交新增数据按钮添加事件
	$('#zyn-btn-add-submit').click(function(){
		var formData = $('#zyn-form-add').serializeArray();
		var postData = {};
		$(formData).each(function(i){
			postData[this.name] = this.value;
		});
		Dialog.confirm('是否确定提交数据',function(){
		$.ajax({
			type:"post",
			url:SCOPE.add_url,
			data:postData,
			dataType:'json',
			success:function(result){
				//链接服务器其成功
				if(result.status == SUCCESS){
					//成功
					return result.msg,location.href =SCOPE.success_jump_url;
				}else if (result.status == VALIDATE_ERROR){
					//表单验证出错
					var errors = result.msg;
					$('.zyn-p-validate-result').each(function(){
						var errorMsg = errors[$(this).attr('attr-validate')];
						$(this).html(errorMsg != undefined ? '*'+errorMsg : '').css({color:'red'});
					});
				}else{
					return Dialog.error(result.msg);
				}
				
			},
			
		});
	});
	});
	//点击详情按钮事件
	$('.zyn-table-list #zyn-span-edit').click(function(){
		var id = $(this).attr('attr-id');
		location.href = SCOPE.edit_url+'?id='+id;
	});
	//点击删除按钮事件
	$('.zyn-table-list #zyn-span-trash').click(function(){
		var id = $(this).attr('attr-id');
		var url = SCOPE.set_status_url;
		var postData = {};
		postData['id']=id;
		postData['status']= -1;
		Dialog.confirm('是否确定删除数据',function(){
			$.ajax({
				type:"post",
				url:url,
				async:true,
				data:postData,
				dataType:'json',
				success:function(result){
					if(result.status == SUCCESS){
						return result.msg,location.href =SCOPE.success_jump_url;
					}
					return Dialog.error(result.msg);
				},
			});
		});
	});
////	
//////	//排序按钮的事件
//	$('#zyn-btn-list_order').click(function(){
//		var formData = $('#zyn-form-list').serializeArray();
//		var postData = {};
//		$(formData).each(function(i){
//			postData[this.name] = this.value;
//		});
//		var url = SCOPE.list_order_url;
//		$.ajax({
//			type:"post",
//			url:url,
//			async:true,
//			data:postData,
//			dataType:'json',
//			success:function(result){
//				return Dialog.success(s=result.msg,SCOPE.success_refresh_url);
//			}
//			
//		});
//	});
//	
//////	
////	//跳转分配权限按钮事件
	$('.zyn-table-list #zyn-span-assign-auth').click(function(){
		var id = $(this).attr('attr-id');
		location.href = SCOPE.assign_auth_url+'?id='+id;
		
	});
//	
	//点击分配权限事件
	$('#zyn-btn-assign-auth').click(function(){
		var formData = $('#zyn-form-assign-auth').serializeArray();
		var postData = {};
		$(formData).each(function(i){
			postData[this.name] = this.value;
		});
		Dialog.confirm('是否确定提交数据',function(){
		var url = SCOPE.assign_auth_url;
		console.log(postData);
		$.ajax({
			type:"post",
			url:url,
			async:true,
			data:postData,
			dataType:'json',
			success:function(result){
				if(result.status == SUCCESS){
						return result.msg,location.href =SCOPE.success_jump_url;
				      }
				return Dialog.error(result.msg);
			}
			
		});
		});
	});
////	
////	//图片上传
	$('#zyn-input-uploader').uploadify({
		'swf':SCOPE.ajax_upload_swf,
		'uploader':SCOPE.ajax_upload_url,
		'buttonText':'上传图片',
		'fileTypeExts':'*.gif;*.png;*.jpg',
		'fileTypeDecs':'Image File',
		'fileObjName':'file',
		'onUploadSuccess':function(file,data,response){
			if(response){
				var res = JSON.parse(data);
				console.log(res.data.thumb_path);
				
				$('#zyn-image-show-thumb').attr('src',res.data.thumb_path).show();
				$('#zyn-input-image-path').attr('value',res.data.announcement_picture);
//				$('#zyn-input-thumb-path').attr('value',res.data.thumb_path);
			}
		},
	});
	//视频上传
	$('#zh-input-video-uploader').uploadify({
		'fileSize' : '222121212',
		'swf':SCOPE.ajax_upload_swf,
		'uploader':SCOPE.ajax_upload_url,
		'buttonText':'上传视频',
		'fileTypeExts':'.RWVB;*.AVI;*.MP4;*.MOV',
		'fileTypeDecs':'Image File',
		'fileObjName':'file',
		'onUploadSuccess':function(file,data,response){
			if(response){
				var res = JSON.parse(data);
				$('#zh-image-show-thumb').attr('src',res.data).show();
				$('#zh-input-image-path').attr('value',res.data);
				//$('#zh-input-thumb-path').attr('value',res.data.thumb_path);
			}
		},
	});
	
	//---------------------------------------------------------------------
	$('#zyn-btn-add-submittwo').click(function(){
		var formData = $('#zyn-form-addtwo').serializeArray();
		var postData = {};
		$(formData).each(function(i){
			postData[this.name] = this.value;
		});
		Dialog.confirm('是否确定提交数据',function(){
		$.ajax({
			type:"post",
			url:SCOPE.add_url,
			data:postData,
			dataType:'json',
			success:function(result){
				//链接服务器其成功
				if(result.status == SUCCESS){
					//成功
					return result.msg,location.href =SCOPE.success_jump_url;
				}else if (result.status == VALIDATE_ERROR){
					//表单验证出错
					var errors = result.msg;
					$('.zyn-p-validate-result').each(function(){
						var errorMsg = errors[$(this).attr('attr-validate')];
						$(this).html(errorMsg != undefined ? '*'+errorMsg : '').css({color:'red'});
					});
				}else{
					return Dialog.error(result.msg);
				}
				
			},
			
		});
	});
	});
	
	//----------------------------------------------------------
	//为提交新增类型按钮添加事件
	$('#zyn-btn-submit').click(function(){
		var formData = $('#zyn-form-submit').serializeArray();
		var postData = {};
		$(formData).each(function(i){
			postData[this.name] = this.value;
		});
		Dialog.confirm('是否确定提交数据',function(){
		$.ajax({
			type:"post",
			url:SCOPE.type_url,
			data:postData,
			dataType:'json',
			success:function(result){
				//链接服务器其成功
				if(result.status == SUCCESS){
					//成功
					return result.msg,location.href =SCOPE.success_jump_url;
				}else if (result.status == VALIDATE_ERROR){
					//表单验证出错
					var errors = result.msg;
					$('.zyn-p-validate-result').each(function(){
						var errorMsg = errors[$(this).attr('attr-validate')];
						$(this).html(errorMsg != undefined ? '*'+errorMsg : '').css({color:'red'});
					});
				}else{
					return Dialog.error(result.msg);
				}
				
			},
			
		});
	});
	});
	
	//点击开启/关闭按钮事件
	$('.zyn-table-list #zyn-span-type').click(function(){
		
		var id = $(this).attr('attr-id');
		var url = SCOPE.set_status_url;
		var postData = {};
		postData['id']=id;
//		postData['status']= -1;
		Dialog.confirm('确认修改?',function(){
			$.ajax({
				type:"post",
				url:url,
				async:true,
				data:postData,
				dataType:'json',
				success:function(result){
					if(result.status == SUCCESS){
						return result.msg,location.href =SCOPE.success_jump_url;
					}
					return Dialog.error(result.msg);
				},
			});
		});
	});
	
	//点击重置密码按钮事件
	$('.zyn-table-list #zyn-span-psw').click(function(){
		var id = $(this).attr('attr-id');
		var url = SCOPE.set_password_url;
		var postData = {};
		postData['id']=id;
		Dialog.confirm('确认重置密码?',function(){
			$.ajax({
				type:"post",
				url:url,
				async:true,
				data:postData,
				dataType:'json',
				success:function(result){
					if(result.status == SUCCESS){
						return result.msg,location.href =SCOPE.success_jump_url;
					}
					return Dialog.error(result.msg);
				},
			});
		});
	});
});
//
//
