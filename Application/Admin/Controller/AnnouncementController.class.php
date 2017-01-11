<?php
	//公告管理
namespace Admin\Controller;
import("ZHKit.ImageUploader");
import('ZHKit.Constants');
use Think\Controller;
use ZHKit\ImageUploader;
//use ZHKit\constants;
class AnnouncementController extends CommonController{
	public function index(){
		if($_GET['type']){
//			cDebug(session('selectedValue1'));
			$_REQUEST['p'] = $_GET['p'];
			if(session('selectedValue1') == 1){
//				cDebug('123');
				$cond['announcement_check_state'] = '通过';
			}
			if(session('selectedValue1') == 0){
				if(session('selectedValue1') == 0){
				}
				else{
					$cond['announcement_sender_id'] = $admin['hospital_user_id'];
				}
				if(session('selectedValue2') == 1){
					$cond['announcement_check_state'] = '未审核';
					
				}
				if(session('selectedValue2') == 2){
					$cond['announcement_check_state'] = '通过';
				}
				if(session('selectedValue2') == 3){
					$cond['announcement_check_state'] = '未通过';
				}
			}
		}
		else{
//			cDebug('123');
			
			session('selectedValue1',null);
			session('selectedValue2',null);
		}
		$cond['state']=array('neq','关闭');
    	$admin = session(C('ADMIN_SESSION'));
    	
    	$announcement = M('a_announcement_info')->order(array('announcement_version_number'=>'desc'))->where($cond)->select();
    	if($announcement === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}
    	
    	
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:2;
    	
    	$schedule=D('a_announcement_info')->getAncheckstates($cond,$page,$pageSize);
//		cDebug($cond);	
    	
    	$scheduletateCount=D('a_announcement_info')->getAncheckstatesCount($cond);
    	//分页控件
    	$pageObj = new \Think\Page($scheduletateCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
		$this->assign('pageRes',$pageRes);
    	$this->assign('announcement',$schedule); 
//  	cDebug($schedule); 	
       	$this->display();
    }
	public function add(){
		if($_POST){
			if($_POST['id']){
				if(!$_POST['error_message'] || $_POST['error_message'] == ''){
					return ajaxReturn(\UPLOAD_FAILURE,'请填写驳回原因');
				}
					$data['id'] = $_POST['id'];
					$data['error_message'] = $_POST['error_message'];
					$data['num'] = intval($_POST['num']);
					$data['announcement_check_state']='未通过';
					return $this->save($data);
				}
			if($_POST['idtwo']){
//				cDebug($_POST);
				$data['id'] = $_POST['idtwo'];
				$data['num'] = intval($_POST['numtwo']);
				$data['announcement_check_state']='已通过';
				return $this->save($data);
			}
			$validData = D('a_announcement_info')->create();
			if($validData){
				if(!$_POST['announcement_picture'] || $_POST['announcement_picture'] = ''){
					$validData['announcement_picture'] = "http://127.0.0.1/homecare1/UploadImages/DontShow/small_585be1be0e167.jpg";
				}
				$admin = session(C('ADMIN_SESSION'));
				$validData['announcement_sender_id'] = $admin["hospital_user_id"];
				$hospital = $admin['community_hospitals_id'];
				$validData['announcement_hospital_id'] = $hospital;
				$validData['announcement_id'] = get_uuid();
				$validData['send_datetime']=date('Y-m-d H:i:s');
				$res = D('a_announcement_info')->insert($validData);
				if($res){
					return ajaxReturn(\SUCCESS,'公告发布成功');
				}else{
					return ajaxReturn(\UPLOAD_FAILURE,'公告发布失败');
				}
			}else{
				return ajaxReturn(\VALIDATE_ERROR,D('a_announcement_info')->getError());
			}
		}
		$admin = session(C('ADMIN_SESSION'));
		$res = D('h_hospitals_info')->where('community_hospitals_id='.$admin['community_hospitals_id'])->find();
		$community_hospitals_name = $res['community_hospitals_name'];
		$sent_time = date('Y-m-d H:i:s');
		$type = D('a_announcement_type')->select();
		$this ->assign('type',$type);
		$this ->assign('name',$admin['hospital_user_name']);
		$this ->assign('community_hospitals_name',$community_hospitals_name);
		$this ->assign('sent_time',$sent_time);
		$this->display();
	}
	
	function ajaxUploadImage(){
    	$uploader = new ImageUploader();
    	
    	$res = $uploader->imageUpload();
    	if($res === false){
    		return ajaxReturn(\UPLOAD_FAILURE,'图片上传失败');
    	}
    	return ajaxReturn(\SUCCESS,'图片上传成功',$res);
    }
    
    function edit(){
    	$announcement['announcement_id']= I('id');
//  	cDebug($announcement);
    	$announcement['announcement_version_number'] = I('num');
    	try{
    		$announcement = D('a_announcement_info')->where($announcement)->find();
//  		cDebug($announcement);
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	$cond = array(
    		'announcement_type_id' => array('eq',$announcement['announcement_type_id'],),
    	);
    	$res = D('a_announcement_type')->where($cond)->find();
    	$announcement['announcement_type_name'] = $res['announcement_type_name'];
    	if($announcement === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
    	}
    	$res = D('h_hospitals_info')->find($announcement['announcement_hospital_id']);
    	$announcement['community_hospitals_name'] = $res['community_hospitals_name'];
    	$this->assign('announcement',$announcement);
    	$this->display();
    }
    
    public function save($data){
    	$announcement_id=$data['id'];
    	$announcement_num = $data['num'];
    	unset($data['id']);
    	unset($data['num']);
    	$admin = session(C('ADMIN_SESSION'));
    	$data['announcement_checker_id'] = $admin['hospital_user_id'];
    	$cond['announcement_version_number'] = $announcement_num;
    	$cond['announcement_id'] = $announcement_id ;
    	$data['announcement_check_time'] = date('Y-m-d H:i:s');
//  	cdebug($cond);
    	$res = M('a_announcement_info')->where($cond)->save($data);
    	if(!$res){
    		return ajaxReturn(\DATABASE_ERROR,'修改失败');
    	}
    	return ajaxReturn(\SUCCESS,'操作成功！');
    
    }
    
    //公告审核
    public function check(){
    	$cond=array(
		    'announcement_check_state'=>array('eq','未审核'),
			);
		$where=array(
		    'announcement_check_state'=>array('neq','未审核'),
		    'announcement_checker_id'=>array('eq',session(C('ADMIN_SESSION'))['hospital_user_id']),
			);
		$data=array(
		    'announcement_check_state'=>array('neq','未审核'),
			);
    	 //分页
        $page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:10;
    	$ancheckstate=D('a_announcement_info')->getAncheckstates($cond,$page,$pageSize);
    	$ancheckstate2=D('a_announcement_info')->getAncheckstates($where,$page,$pageSize);
    	$ancheckstate3=D('a_announcement_info')->getAncheckstates($data,$page,$pageSize);
    	$ancheckstatesCount=D('a_announcement_info')->getAncheckstatesCount($cond);
    	$ancheckstatesCount2=D('a_announcement_info')->getAncheckstatesCount($where);
    	$ancheckstatesCount3=D('a_announcement_info')->getAncheckstatesCount($data);
    	//分页控件
    	$pageObj = new \Think\Page($ancheckstatesCount,$pageSize);
    	$pageObj2 = new \Think\Page($ancheckstatesCount2,$pageSize);
    	$pageObj3 = new \Think\Page($ancheckstatesCount3,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	$pageRes2 = $pageObj2->show();
    	$pageRes3 = $pageObj3->show();
    	$this->assign('pageRes',$pageRes);
    	$this->assign('pageRes2',$pageRes2);
    	$this->assign('pageRes3',$pageRes3);
        $this->assign('ancheckstate',$ancheckstate);
        $this->assign('ancheckstate2',$ancheckstate2);
         $this->assign('ancheckstate3',$ancheckstate3);
    	$this->display();
    }
    
    function typeName(){
    	if($_POST['type-name']){
    		$data['announcement_type_id'] = get_uuid();
    		$data['announcement_type_name'] = $_POST['type-name'];
    		$res = D('a_announcement_type')->add($data);
    		if($res){
    			return ajaxReturn(\SUCCESS,'添加类型成功！');
    		}
    		return ajaxReturn(\DATABASE_ERROR,'添加失败');
    	}
    	return ajaxReturn(\DATABASE_ERROR,'请填写公告类型');
    }
    
    
   
    public function getData(){
    	$selectedValue = I('selectedValue');
    	session('selectedValue2',$selectedValue);
		if($_GET){
			$this->redirect('Announcement/index',array('p'=>$_GET['p'],'type'=>'true'));
		}
    	
    	$admin = session(C('ADMIN_SESSION'));
    	$sender_id = $admin['hospital_user_id'];
    	if($selectedValue == 0){
    		$map['state']=array('neq','关闭');
    		$map['announcement_sender_id'] = $sender_id;
//  	
    	}
    	if($selectedValue == 1){
    		$map['state']=array('neq','关闭');
    		$map['announcement_check_state'] = '未审核';
    		$map['announcement_sender_id'] = $sender_id;
    	}
    	if($selectedValue == 2){
    		$map['state']=array('neq','关闭');
    		$map['announcement_check_state'] = '已通过';
    		$map['announcement_sender_id'] = $sender_id;
    	}
    	if($selectedValue == 3){
    		$map['state']=array('neq','关闭');
    		$map['announcement_check_state'] = '未通过';
    		$map['announcement_sender_id'] = $sender_id;
    	}
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:2;
    	$schedule=D('a_announcement_info')->getAncheckstates($map,$page,$pageSize);	
    	$scheduletateCount=D('a_announcement_info')->getAncheckstatesCount($map);
    	//分页控件
    	$pageObj = new \Think\Page($scheduletateCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	$res['pageRes'] = $pageRes;
    	$res['schedule'] = $schedule;
//  	cdebug($res);
    	echo json_encode($res);
//  	echo json_encode($announcement);
    }
     public function getSourse(){
     	$admin = session(C('ADMIN_SESSION'));
     	$selectedValue = I('selectedValue');
     	session('selectedValue1',$selectedValue);
     	
		if($_GET){
			$this->redirect('Announcement/index',array('p'=>$_GET['p'],'type'=>'true'));
		}
     	$map['state']=array('neq','关闭');
//   	$cond['announcement_hospital_id']=$admin['community_hospitals_id'];
    	$announcement = D('a_announcement_info')->where($map)->select();
    	if($announcement === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}
    	$admin = session(C('ADMIN_SESSION'));
    	$sender_id = $admin['hospital_user_id'];
    	if($selectedValue == 0){
//  		$map['state']=array('neq','关闭');
    		$map['announcement_sender_id'] = $sender_id;
//  		$announcement = M('a_announcement_info')->where($map)->select();
//  		cDebug($announcement);
    	}
    	if($selectedValue == 1){
//  		$map['state']=array('neq','关闭');
    		$map['announcement_check_state'] = '已通过';
//  		$announcement = M('a_announcement_info')->where($map)->select();
//  		cDebug($announcement);
    	}
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:2;
    	$schedule=D('a_announcement_info')->getAncheckstates($map,$page,$pageSize);	
    	$scheduletateCount=D('a_announcement_info')->getAncheckstatesCount($map);
    	//分页控件
    	$pageObj = new \Think\Page($scheduletateCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	$res['pageRes'] = $pageRes;
    	
    	foreach($schedule as $key => $value){
    		$schedule[$key]['announcement_sender_name'] = M('h_hospital_user_info')->where(array('hospital_user_id'=>$value['announcement_sender_id']))->getField('hospital_user_name');
    	}
    	
    	$res['schedule'] = $schedule;

    	echo json_encode($res);
//  	echo json_encode($announcement);
    }
    public function modelShow(){
    	$showID = I('id');
    	$cond['announcement_id'] = $showID;
    	$announcement = M('a_announcement_info')->join('a_announcement_type on a_announcement_info.announcement_type_id=a_announcement_type.announcement_type_id')->where($cond)->select();
    	echo json_encode($announcement);
    }
     public function history(){
     	$cond['state']=array('neq','关闭');
		$showID = I('id');
    	$cond['announcement_id'] = $showID;
    	$announcement = M('a_announcement_info')->join('a_announcement_type on a_announcement_info.announcement_type_id=a_announcement_type.announcement_type_id')->where($cond)->order('announcement_version_number desc')->select();
    	$this->assign('announcement',$announcement);
    	$this->display();
    }
    
    
    public function setStatus(){
		if($_POST){
			try{
				$res = D('a_announcement_info')->updateMenuById($_POST['id'],$_POST['num'],$_POST);
				if($res === FALSE){
					return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
				}
				return ajaxReturn(\SUCCESS,'更新菜单成功');
			}catch(Exception $e){
				return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
			}
		}
		return ajaxReturn(\ARGUMENT_ERROR,'未获取更多数据');
	}
	
	
	public function details(){
		$announcement['announcement_id']= I('id');
    	$announcement['announcement_version_number'] = I('num');
    	try{
    		$announcement = D('a_announcement_info')->where($announcement)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
//  	cDebug(session(C('ADMIN_SESSION'))["hospital_user_id"]);
        $admin = session(C('ADMIN_SESSION'));
    	if($announcement['announcement_sender_id'] == $admin["hospital_user_id"]){
    		$announcement['res'] = 1 ;
    	}else{
    		$announcement['res'] = 0 ;
    	}
    	$where = array(
    	'announcement_type_id' => array('eq',$announcement['announcement_type_id']),
    	);
    	$res = D('a_announcement_type')->where($where)->find();
    	$announcement['announcement_type_name'] = $res['announcement_type_name'];
    	if($announcement === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
    	}
    	$announcement['hospital_user_name']=$admin["hospital_user_name"];
    	$hospital_id = $admin["community_hospitals_id"];
    	$res = D('h_hospitals_info')->where('community_hospitals_id='.$hospital_id)->find();
    	$announcement['community_hospitals_name']=$res['community_hospitals_name'];
//  	cdebug($announcement);
		$res = M('a_announcement_type')->select();
    	$this->assign('type',$res);
    	$this->assign('announcement',$announcement);
    	$this->display();
	}
	
	
	public function update(){
		if($_POST){
			if($_POST['announcement_check_state'] == '未审核'){
				if($_POST['announcement_picture'] == ''){
					$where = array(
						'announcement_id'=>array('eq',$_POST['announcement_id']),
						'announcement_version_number'=>array('eq',$_POST['announcement_version_number']),
					);
					$date['send_datetime'] = date('Y-m-d H:i:s');
					$date['announcement_title'] = $_POST['announcement_title'];
					$date['announcement_type_id'] = $_POST['announcement_type_id'];
					$date['announcement_content'] = $_POST['announcement_content'];
					$date['announcement_end_date'] = $_POST['announcement_end_date'];
					$res = D('a_announcement_info')->where($where)->save($date);
				}else{
					$where = array(
						'announcement_id'=>array('eq',$_POST['announcement_id']),
					);
					$_POST['send_datetime'] = date('Y-m-d H:i:s');
					$res = D('a_announcement_info')->where($where)->save($_POST);
				}
				if(!$res){
					return ajaxReturn(\UPDATE_ERROR,'数据更新失败');
				}
				return ajaxReturn(\SUCCESS,'数据更新成功');
			}
			if($_POST['announcement_check_state'] == '未通过'){
				
				if($_POST['announcement_picture'] == ''){
					$where = array(
						'announcement_id'=>array('eq',$_POST['announcement_id']),
						'announcement_version_number'=>array('eq',$_POST['announcement_version_number']),
					);
					$res=D('a_announcement_info')->where($where)->find();
					$_POST['announcement_picture'] = $res['announcement_picture'];
					
				}
				$_POST['send_datetime'] = date('Y-m-d H:i:s');
				$admin = session(C('ADMIN_SESSION'));
				$_POST['announcement_sender_id'] = $admin["hospital_user_id"];
				$_POST['announcement_hospital_id'] = $admin["community_hospitals_id"];
				$_POST['announcement_check_state'] ='未审核';
				$where = array(
						'announcement_id'=>array('eq',$_POST['announcement_id']),
					);
				$res = D('a_announcement_info')->where($where)->order('announcement_version_number desc')->select();
				
				if($res[0]['announcement_check_state'] == '未审核'){
					$where = array(
						'announcement_id'=>array('eq',$_POST['announcement_id']),
						'announcement_version_number'=>array('eq',$res[0]['announcement_version_number']),
					);
					
					$_POST['announcement_version_number'] = $res[0]['announcement_version_number'];
					$res = D('a_announcement_info')->where($where)->save($_POST);
				}elseif($res[0]['announcement_check_state'] == '已通过'){
					return ajaxReturn (\UPDATE_ERROR,'该公告已有通过版本');
				}else{
					$_POST['announcement_version_number'] = $res[0]['announcement_version_number']+1;
					$res = D('a_announcement_info')->insert($_POST);
				}
				if(!$res){
					return ajaxReturn(\UPDATE_ERROR,'数据更新失败');
				}
				return ajaxReturn(\SUCCESS,'数据更新成功');
			}
			
		}
		return ajaxReturn(\UPDATE_ERROR,'未获取更新数据');
	}
	
	//搜索
	 public function getSearch(){
    	$spanData = I('spanData');
    	cdebug($spanData);
    	$cond['state']=array('neq','关闭');
    	$admin = session(C('ADMIN_SESSION'));
    	$cond['announcement_title'] = array('like','%'.$search.'%');
    	if(I('select-user') == 0){
    		$cond['announcement_sender_id'] = $admin['hospital_user_id'];
    		if(I('select-type') == 0){
    			
    		}
    		if(I('select-type') == 1){
    			$cond['announcement_check_state'] = '未审核';
    		}
    		if(I('select-type') == 2){
    			$cond['announcement_check_state'] = '通过';
    		}
    		if(I('select-type') == 3){
    			$cond['announcement_check_state'] = '未通过';
    		}
    	}
    	if(I('select-user') == 1){
    		
    	}    	
    	$announcement = M('a_announcement_info')->order(array('announcement_version_number'=>'desc'))->where($cond)->select();
//  	cDebug($announcement);
    	echo json_encode($announcement);
    	
    }
    
}
?>