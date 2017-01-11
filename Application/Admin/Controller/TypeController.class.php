<?php
namespace Admin\Controller;
class TypeController extends CommonController {
	//加载视频类型管理模块的首页
    public function index(){
    	$cond=array(
    		//筛选掉已经删除的数据
    		'type_state'=>array('neq',-1),
    	);
    	
    	//模糊搜索逻辑
    	if(isset($_POST['search']) && ($_POST['search']) != NULL){
    		$cond['video_type_name'] = array('like','%'.$_POST['search'].'%');
			$this->assign('search',$_POST['search']);
    	}
    	
    	//分页逻辑
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:10;
    	$type=D('a_video_type')->getType($cond,$page,$pageSize);
    	$typeCount=D('a_video_type')->getTypeCount($cond);
    	//分页控件
    	$pageObj = new \Think\Page($typeCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	//绑定模板变量
    	$this->assign('type',$type);
    	$this->assign('pageRes',$pageRes);
    	
      	//输出模板
        $this->display();
    }
    
    //视频类型新增、编辑页面
     public function videoadd(){
    	if($_POST){
    		//表单验证
    		$validData = D('a_video_type')->create();
    		if($validData){
    			$video_type_id = get_uuid();
    			$validData['video_type_id'] = $video_type_id;
    			//编辑的逻辑
    			if($_POST['id']){
    				return $this->save($_POST);
    			}
    			//执行新增操作
    			$where = array(
						'type_state'=>array('neq',-1),
						'video_type_name' => $_POST['video_type_name'],
					);
				$res1 = D('a_video_type')->where($where)->select();
    			if(empty($res1)){
    				$res = D('a_video_type')->insert($validData);
    			}else{
    				return ajaxReturn(\DATABASE_ERROR,'已有该视频类型！');
    			}
    			if($res === FALSE){
    				return ajaxReturn(\DATABASE_ERROR,'数据库新增失败！');
    			}
    			return ajaxReturn(\SUCCESS,'数据库新增成功！');
    		}
    		else{
    			return ajaxReturn(\VALIDATE_ERROR,D('a_video_type')->getError());
    		}
    	}
    }
     //视频类型更新数据API
    public function save($data){
    	$video_type_id = $data['id'];
    	unset($data['id']);
    	try{
				$where = array(
						'type_state'=>array('neq',-1),
						'video_type_name' => $_POST['video_type_name'],
					);
				$res1 = D('a_video_type')->where($where)->select();
    		if(!empty($res1)){
    			return ajaxReturn(\DATABASE_ERROR,'已有该视频类型！');
    		}
    		$res = D('a_video_type')->updateAVideoInfoById($video_type_id,$data);
    	}catch(Exception $e){
    		return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
    	}
    	if ($res === fales){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}
    	return ajaxReturn(\SUCCESS,'更新视频类型信息成功！');
    }
    
     //视频类型修改状态API
    public function setStatus(){
    	if ($_POST){
    		$video_type_id = I('id');
    		$data['type_state'] = intval(I('status'));
    		//到数据库中更新字段
    		try{
    			$cond = array(
						'state'=>array('neq','关闭'),
					);
				$res1 = D('a_video_info')->where($cond)->select();
				foreach($res1 as $k=>$v){
					$a[$k] = $v['video_type_id'];
				}
				if(in_array($video_type_id,$a)){
					return ajaxReturn(\DATABASE_ERROR,'该类型下有已发布视频！');
				}
    			$res = D('a_video_type')->updateAVideoInfoById($video_type_id,$data);
    			if ($res === fales){
    		        return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	        }
    	        return ajaxReturn(\SUCCESS,'更新状态成功！');
    		}catch(Exception $e){
    		    return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
    	    }	
    	}
    	return ajaxReturn(\ARGUMENT_ERROR,'未获取更新数据！');
    }
    
    
    //加载公告类型管理模块的首页
    public function notice(){
    	$cond=array(
    		//筛选掉已经删除的数据
    		'type_state'=>array('neq',-1),
    	);
    	
    	//模糊搜索逻辑
    	if(isset($_POST['search']) && ($_POST['search']) != NULL){
    		$cond['announcement_type_name'] = array('like','%'.$_POST['search'].'%');
			$this->assign('search',$_POST['search']);
    	}
    	
    	//分页逻辑
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:10;
    	$type=D('a_announcement_type')->getType($cond,$page,$pageSize);
    	$typeCount=D('a_announcement_type')->getTypeCount($cond);
    	//分页控件
    	$pageObj = new \Think\Page($typeCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	//绑定模板变量
    	$this->assign('type',$type);
    	$this->assign('pageRes',$pageRes);
      	//输出模板
        $this->display();
    }
    
     //公告类型编辑页面
     public function annadd(){
    	if($_POST){
    		//表单验证
    		$validData = D('a_announcement_type')->create();
    		if($validData){
    			$announcement_type_id = get_uuid();
    			$validData['announcement_type_id'] = $announcement_type_id;
    			//编辑的逻辑
    			if($_POST['id']){
    				return $this->save1($_POST);
    			}
    			//执行新增操作
    			$where = array(
						'type_state'=>array('neq',-1),
						'announcement_type_name' => $_POST['announcement_type_name'],
					);
				$res1 = D('a_announcement_type')->where($where)->select();
    			if(empty($res1)){
    				$res = D('a_announcement_type')->insert1($validData);
    			}else{
    				return ajaxReturn(\DATABASE_ERROR,'已有该公告类型！');
    			}
    			if($res === FALSE){
    				return ajaxReturn(\DATABASE_ERROR,'数据库新增失败！');
    			}
    			return ajaxReturn(\SUCCESS,'数据库新增成功！');
    		}
    		else{
    			return ajaxReturn(\VALIDATE_ERROR,D('a_announcement_type')->getError());
    		}
    	}
    }
     //公告类型更新数据API
    public function save1($data){
    	$hospital_user_id = $data['id'];
    	unset($data['id']);
    	try{
				$where = array(
						'type_state'=>array('neq',-1),
						'announcement_type_name' => $_POST['announcement_type_name'],
					);
				$res1 = D('a_announcement_type')->where($where)->select();
    		if(!empty($res1)){
    			return ajaxReturn(\DATABASE_ERROR,'已有该公告类型！');
    		}
    		$res = D('a_announcement_type')->updateAVideoInfoById($hospital_user_id,$data);
    	}catch(Exception $e){
    		return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
    	}
    	if ($res === fales){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}
    	return ajaxReturn(\SUCCESS,'更新公告类型信息成功！');
    }
    
     //公告类型修改状态API
    public function setStatus1(){
    	if ($_POST){
    		$menu_id = I('id');
    		$data['type_state'] = intval(I('status'));
    		//到数据库中更新字段
    		try{
    			$cond = array(
						'state'=>array('neq','关闭'),
					);
				$res1 = D('a_announcement_info')->where($cond)->select();
				foreach($res1 as $k=>$v){
					$a[$k] = $v['announcement_type_id'];
				}
				if(in_array($menu_id,$a)){
					return ajaxReturn(\DATABASE_ERROR,'该类型下有已发布视频！');
				}
    			$res = D('a_announcement_type')->updateAVideoInfoById($menu_id,$data);
    			if ($res === fales){
    		        return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	        }
    	        return ajaxReturn(\SUCCESS,'更新状态成功！');
    		}catch(Exception $e){
    		    return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
    	    }	
    	}
    	return ajaxReturn(\ARGUMENT_ERROR,'未获取更新数据！');
    }
}