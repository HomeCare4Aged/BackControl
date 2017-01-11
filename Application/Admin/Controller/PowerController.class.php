<?php
namespace Admin\Controller;
//use Think\Controller;
//import("ZHKit.Constants");
class PowerController extends CommonController {
    public function index(){
 
 		//模糊搜索逻辑
    	if(isset($_POST['search']) && ($_POST['search']) != NULL){
    		$cond['hospital_user_name'] = array('like','%'.$_POST['search'].'%');
    		$cond['hospital_user_id'] = array('like','%'.$_POST['search'].'%');
			$this->assign('search',$_POST['search']);
    	}
    	//加载管理员列表
       $cond = array(
    	
    	//筛选掉已经删除的数据
    	    'state' => array('neq',-1),
    	    'community_hospitals_id' => array('eq',9999),
    	);
 		
    	//分页逻辑
    	$page = $_REQUEST['p'] ? $_REQUEST['p'] : 1 ;
    	$pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10 ;
    	$acommunityinfos = D('h_hospital_user_info')->getAdminInfo($cond,$page,$pageSize);
    	$acommunityinfoCount = D('h_hospital_user_info')->getAdminInfoCount($cond);
    	//获取全部权限信息
		$menus = D('h_hospital_user_info')->getMenus(array('state' => array('neq',-1)));
		if($_POST){
			$id = I('hospital_user_id');
    		if($id === null || $id == ''){
	    		return ajaxReturn(\ARGUMENT_ERROR,'未获取员工ID');
	    	}
	    	//获取当前角色权限信息
	    	$role = D('h_user_limit_info')->where($_POST)->find();
	    	//获取当前角色拥有的权限ID
	    	$role_menu_ids = explode(',', $role['limit_id']);
			$this->assign('role',$role);
	    	$this->assign('role_menu_ids',$role_menu_ids);
		}
    	//分页控件
    	$pageObj = new \Think\Page($communityhospitalsinfoCount,$pageSize);
    	
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	
    	//绑定模板变量        
    	$this->assign('acommunityinfos',$acommunityinfos);
    	$this->assign('pageRes',$pageRes);
    	$this->assign('menus',$menus);
    	//输出模板
    	$this->display();
    }
    
    //获取员工权限
    public function assignAuth(){
    	$admin = session(C(('ADMIN_SESSION')));
    	$user = $admin['community_hospitals_id'];
		$data = array(
			'community_hospitals_id' => intval($user),
			'hospital_user_id' => intval($_POST['hospital_user_id']),
		);
    	if($_POST){
    		try{
    			$res = D('h_hospital_user_info')->saveAuth(I('hospital_user_id'),I('limit_tyoe_id'));
    			if($res === false){
    				return ajaxReturn(\DATABASE_ERROR,'权限更新失败');
    			}
    				return ajaxReturn(\SUCCESS,'权限更新成功');
    			}catch(exception $e){
    				return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
    		}
    		
    	}
    }
    
    //加载新增管理员页面
    public function add(){
    	if($_POST){
			$validData = D('h_hospital_user_info')->create();
    		if($validData){
    			$hospital_user_id = get_uuid();
    			$validData['community_hospitals_id']='9999';
    			$validData['hospital_user_psw']='0000';
    			$validData['hospital_user_id'] = $hospital_user_id;
    			$res = D('h_hospital_user_info')->order('hospital_user_no desc')->select();
				$num = $res[1]['hospital_user_no'] + 1;
				$validData['hospital_user_no']=sprintf("%04d", $num);
    			//执行新增操作
    			$res = D('h_hospital_user_info')->add($validData);
    			$res1 = D('h_user_limit_info')->add($validData);
    			if($res === FALSE){
    				return ajaxReturn(\DATABASE_ERROR,'账号申请失败！');
    			}
    			return ajaxReturn(\SUCCESS,'账号申请成功！');
    		}
    			return ajaxReturn(\VALIDATE_ERROR,D('h_hospitals_info')->getError());
		}
		$res = D('h_hospital_user_info')->order('hospital_user_no desc')->select();
		$num = $res[1]['hospital_user_no'] + 1;
		$num=sprintf("%04d", $num);
		$this->assign('num',$num);
		$this->display();
	}

	//编辑逻辑
	 public function addn(){
    	if($_POST){
    		if($_POST['video_type_name'] == null || !$_POST['video_type_name']){
    			return ajaxReturn(\DATABASE_ERROR,'员工姓名不能为空！');
    		}else{
    			$where = array('hospital_user_id' => array('eq',$_POST['id']),);
    			$date['hospital_user_name'] = $_POST['video_type_name'];
    			$res = D('h_hospital_user_info')->where($where)->save($date);
    			if($res){
    				return ajaxReturn(\SUCCESS,'员工姓名修改成功！');
    			}
    			return ajaxReturn(\DATABASE_ERROR,'员工姓名修改失败！');
    		}
			$validData = D('h_hospital_user_info')->create();
    		if($validData){
    			$hospital_user_id = get_uuid();
    			$validData['community_hospitals_id']='9999';
    			$validData['hospital_user_psw']='0000';
    			$validData['hospital_user_id'] = $hospital_user_id;
    			$res = D('h_hospital_user_info')->order('hospital_user_no desc')->select();
				$num = $res[1]['hospital_user_no'] + 1;
				$validData['hospital_user_no']=sprintf("%04d", $num);
    			//执行新增操作
    			$res = D('h_hospital_user_info')->add($validData);
    			if($res === FALSE){
    				return ajaxReturn(\DATABASE_ERROR,'账号申请失败！');
    			}
    			return ajaxReturn(\SUCCESS,'账号申请成功！');
    		}
    			return ajaxReturn(\VALIDATE_ERROR,D('h_hospitals_info')->getError());
		}
		$res = D('h_hospital_user_info')->order('hospital_user_no desc')->select();
		$num = $res[1]['hospital_user_no'] + 1;
		$num=sprintf("%04d", $num);
		$this->assign('num',$num);
		$this->display();
	}


    //编辑页展示API
    public function edit(){
    	$hospital_user_id = I('id');
    	$cond =array(
		'hospital_user_id'=>array('eq',$hospital_user_id)
		);
    	try{
    		$user = D('h_hospital_user_info')->findHospitalUserById($hospital_user_id,$cond);
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	if ($user === fales){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}
    	$this->assign('user',$user);
    	$this->display();
    } 
    
     //修改状态API
    public function setStatus(){
    	if ($_POST){
    		$menu_id = I('id');
    		$data['state'] = intval(I('status'));
    		//到数据库中更新字段
    		try{
    			$res = D('h_hospital_user_info')->updateAVideoInfoById($menu_id,$data);
    	
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
    
    public function setPsw(){
		if($_POST){
			$where = array(
				'community_hospitals_id' => array(
					'eq',9999,
				),
				'hospital_user_id' => array(
					'eq',$_POST['id'],
				),
			);
				$res =D('h_hospital_user_info')->where($where)->find();
				if($res['hospital_user_psw'] == '0000'){
					return ajaxReturn(\SUCCESS,'更改成功！');
				};
				$date['hospital_user_psw'] = '0000';
	    		$res =D('h_hospital_user_info')->where($where)->save($date);
	    		if($res==false){
	    			return ajaxReturn(\DATABASE_ERROR,"更改失败");
	    		}
	    		return ajaxReturn(\SUCCESS,'更改成功！');
    	}
    	return ajaxReturn(\ARGUMENT_ERROR,'未获取更新数据');
	}
//	
//	//获取员工权限信息
//	public function assignAuth(){
//  	if ($_POST){
// 		try{
//  			$res = D('h_hospital_user_info')->saveAuth(intval(I('role_id')),I('menu_id'));
// 		    if ($res === false){
//  			return ajaxReturn(\DATABASE_ERROR,'权限更新失败');
//  		}
//  		return ajaxReturn(\SUCCESS,'权限更新成功');
//  		}catch(Exception $e){
//  			return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
//  		}
//  	}else{
//  		$id = I('id');
//  	if ($id === null || $id == ''){
//  		return ajaxReturn(\ARGUMENT_ERROR,'未获取角色ID');
//  	}
//  	//获取当前角色信息
//  	$role = D('h_hospital_user_info')->find(intval($id));
//  	//获取全部权限信息
//  	$menus = D('a_limit_type_info')->getMenus(array('state' => array('neq',-1)));
//  	//获取当前角色拥有的权限id
//  	$role_menu_ids = explode(',',$role['role_menu_ids']);
//  	$this->assign('menus',$menus);
//  	$this->assign('role',$role);
//  	$this->assign('role_menu_ids',$role_menu_ids);
//  	$this->display();
//  	}
//  } 
}