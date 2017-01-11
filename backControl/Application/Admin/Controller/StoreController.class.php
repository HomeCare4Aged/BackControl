<?php
	//商户管理
namespace Admin\Controller;
import("ZHKit.ImageUploader");
import('ZHKit.Constants');
use Think\Controller;
use ZHKit\ImageUploader;
//use ZHKit\constants;
class StoreController extends CommonController{
	public function index(){
//  	$cond['store_check_state_id']=array('neq','关闭');
    	if(isset($_POST['search']) && ($_POST['search']) != NULL){
    		$cond['store_shop_name'] = array('like','%'.$_POST['search'].'%');
			$this->assign('search',$_POST['search']);
    	}
    		$shop_info = M('s_store_shop_info')->where($cond)->select();
    		if($shop_info === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    		}
    	$this->assign('shop_info',$shop_info);
    	$this->display();
    }
	public function add(){
		if($_POST){
			if($_POST['id']){
				if(!$_POST['error_message'] || $_POST['error_message'] == ''){
					return ajaxReturn(\UPLOAD_FAILURE,'请填写驳回原因');
				}
					$data['id'] = $_POST['id'];
					$data['store_check_retroaction'] = $_POST['error_message'];
					$data['num'] = intval($_POST['num']);
					$data['store_check_state_id']='未通过';
					return $this->save($data);
				}
			if($_POST['idtwo']){
//				cDebug($_POST);
				$data['id'] = $_POST['idtwo'];
				$data['num'] = intval($_POST['numtwo']);
				$data['store_check_state_id']='已通过';
				return $this->save($data);
			}
		}
		return ajaxReturn(\DATABASE_ERROR,'操作失败');
	}
    function edit(){
    	$store['store_shop_id']= I('id');
//  	cDebug($announcement);
    	$store['store_version_number'] = I('num');
    	try{
    		$store = D('s_store_shop_info')->where($store)->find();
//  		cDebug($announcement);
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	
//  	$cond = array(
//  		'announcement_type_id' => array('eq',$announcement['announcement_type_id'],),
//  	);
//  	$res = D('a_announcement_type')->where($cond)->find();
//  	$announcement['announcement_type_name'] = $res['announcement_type_name'];
//  	if($announcement === false){
//  		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
//  	}
    	$this->assign('store',$store);
    	$this->display();
    }
//  
    public function save($data){
    	$announcement_id=$data['id'];
    	$announcement_num = $data['num'];
    	unset($data['id']);
    	unset($data['num']);
    	$admin = session(C('ADMIN_SESSION'));
    	$data['store_checker_id'] = $admin['hospital_user_id'];
    	$cond['store_shop_id'] = $announcement_num;
    	$cond['store_shop_id'] = $announcement_id ;
    	$data['store_check_time'] = date('Y-m-d H:i:s');
//  	cdebug($cond);
    	$res = M('s_store_shop_info')->where($cond)->save($data);
    	if(!$res){
    		return ajaxReturn(\DATABASE_ERROR,'修改失败');
    	}
    	return ajaxReturn(\SUCCESS,'操作成功！');
//  
    }
//  
    //商铺审核
    public function check(){
    	$cond=array(
		    'store_check_state_id'=>array('eq','未审核'),
			);
		$where=array(
		    'store_check_state_id'=>array('neq','未审核'),
			);
    	 //分页
        $page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:10;
    	$store=D('s_store_shop_info')->getStoreShopInfos($cond,$page,$pageSize);
    	
    	$store2=D('s_store_shop_info')->getStoreShopInfos($where,$page,$pageSize);
    	$ancheckstatesCount=D('s_store_shop_info')->getStoreShopInfoCount($cond);
    	$ancheckstatesCount2=D('s_store_shop_info')->getStoreShopInfoCount($where);
    	//分页控件
    	$pageObj = new \Think\Page($ancheckstatesCount,$pageSize);
    	$pageObj2 = new \Think\Page($ancheckstatesCount2,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	$pageRes2 = $pageObj2->show();
    	$this->assign('pageRes',$pageRes);
    	$this->assign('pageRes2',$pageRes2);
        $this->assign('store',$store);
        $this->assign('store2',$store2);
    	$this->display();
    }
//  
//  function typeName(){
//  	if($_POST['type-name']){
//  		$data['announcement_type_id'] = get_uuid();
//  		$data['announcement_type_name'] = $_POST['type-name'];
//  		$res = D('a_announcement_type')->add($data);
//  		if($res){
//  			return ajaxReturn(\SUCCESS,'添加类型成功！');
//  		}
//  		return ajaxReturn(\DATABASE_ERROR,'添加失败');
//  	}
//  	return ajaxReturn(\DATABASE_ERROR,'请填写公告类型');
//  }
//  
//  
// 
    public function getData(){
    	$selectedValue = I('selectedValue');
    	if($selectedValue == 0){
    		$map = '';
    	}
    	if($selectedValue == 1){
    		$map['store_check_state_id'] = '未审核';
    	}
    	if($selectedValue == 2){
    		$map['store_check_state_id'] = '已通过';
    	}
    	if($selectedValue == 3){
    		$map['store_check_state_id'] = '未通过';
    	}
    	$shop_info = M('s_store_shop_info')->where($map)->select();
    	echo json_encode($shop_info);
    }
//   public function getSourse(){
//   	$selectedValue = I('selectedValue');
////   	$cond['status']=array('neq',-1);
//  	$announcement = D('AAnnouncementInfo')->where($cond)->select();
//  	if($announcement === false){
//  		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
//  	}
//  	
//  	$sender_id = session(C('ADMIN_SESSION'))['hospital_user_id'];
//  	if($selectedValue == 0){
//  		$map['state']=array('neq','关闭');
//  		$map['announcement_sender_id'] = $sender_id;
//  		$announcement = M('a_announcement_info')->where($map)->select();
////  		cDebug($announcement);
//  	}
//  	if($selectedValue == 1){
//  		$map['state']=array('neq','关闭');
//  		$announcement = M('a_announcement_info')->where($map)->select();
////  		cDebug($announcement);
//  	}
//  	
//  	echo json_encode($announcement);
//  }
//  public function modelShow(){
//  	$showID = I('id');
//  	$cond['announcement_id'] = $showID;
//  	$announcement = M('a_announcement_info')->join('a_announcement_type on a_announcement_info.announcement_type_id=a_announcement_type.announcement_type_id')->where($cond)->select();
//  	echo json_encode($announcement);
//  }
     public function history(){
//   	$cond['state']=array('neq','关闭');
		$showID = I('id');
    	$cond['store_shop_id'] = $showID;
    	$store = M('s_store_shop_info')->where($cond)->select();
    	$this->assign('store',$store);
    	$this->display();
    }
//  
//  
//  public function setStatus(){
//		if($_POST){
//			try{
//				$res = D('a_announcement_info')->updateMenuById($_POST['id'],$_POST['num'],$_POST);
//				if($res === FALSE){
//					return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
//				}
//				return ajaxReturn(\SUCCESS,'更新菜单成功');
//			}catch(Exception $e){
//				return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
//			}
//		}
//		return ajaxReturn(\ARGUMENT_ERROR,'未获取更多数据');
//	}
//	
//	
	public function details(){
		$store['store_shop_id']= I('id');
    	$store['store_version_number'] = I('num');
    	try{
    		$store = D('s_store_shop_info')->where($store)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
//  	$where = array(
//  	'announcement_type_id' => array('eq',$announcement['announcement_type_id']),
//  	);
//  	$res = D('a_announcement_type')->where($where)->find();
//  	$announcement['announcement_type_name'] = $res['announcement_type_name'];
//  	if($announcement === false){
//  		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
//  	}
//  	$announcement['hospital_user_name']=session(C('ADMIN_SESSION'))["hospital_user_name"];
//  	$hospital_id = session(C('ADMIN_SESSION'))["community_hospitals_id"];
//  	$res = D('h_hospitals_info')->where('community_hospitals_id='.$hospital_id)->find();
//  	$announcement['community_hospitals_name']=$res['community_hospitals_name'];
//  	cdebug($announcement);
//		$res = M('a_announcement_type')->select();
//  	$this->assign('type',$res);
    	$this->assign('store',$store);
    	$this->display();
	}
//	
//	
//	public function update(){
//		if($_POST){
//			if($_POST['announcement_check_state'] == '未审核'){
//				if($_POST['announcement_picture'] == ''){
//					$where = array(
//						'announcement_id'=>array('eq',$_POST['announcement_id']),
//					);
//					$date['send_datetime'] = date('Y-m-d H:i:s');
//					$date['announcement_title'] = $_POST['announcement_title'];
//					$date['announcement_type_id'] = $_POST['announcement_type_id'];
//					$date['announcement_content'] = $_POST['announcement_content'];
//					$date['announcement_end_date'] = $_POST['announcement_end_date'];
//					$res = D('a_announcement_info')->where($where)->save($date);
//				}else{
//					$where = array(
//						'announcement_id'=>array('eq',$_POST['announcement_id']),
//					);
//					$_POST['send_datetime'] = date('Y-m-d H:i:s');
//					$res = D('a_announcement_info')->where($where)->save($_POST);
//				}
//				if(!$res){
//					return ajaxReturn(\UPDATE_ERROR,'数据更新失败');
//				}
//				return ajaxReturn(\SUCCESS,'数据更新成功');
//			}
//			if($_POST['announcement_check_state'] == '未通过'){
////				cdebug($_POST);
//				if($_POST['announcement_picture'] == ''){
//					$where = array(
//						'announcement_id'=>array('eq',$_POST['announcement_id']),
//						'announcement_version_number'=>array('eq',$_POST['announcement_version_number']),
//					);
//					$res=D('a_announcement_info')->where($where)->find();
//					$_POST['announcement_picture'] = $res['announcement_picture'];
//					
//				}
//				$_POST['send_datetime'] = date('Y-m-d H:i:s');
//				$_POST['announcement_sender_id'] = session(C('ADMIN_SESSION'))["hospital_user_id"];
//				$_POST['announcement_hospital_id'] = session(C('ADMIN_SESSION'))["community_hospitals_id"];
//				$_POST['announcement_check_state'] ='未审核';
//				$where = array(
//						'announcement_id'=>array('eq',$_POST['announcement_id']),
//					);
//				$res = D('a_announcement_info')->where($where)->order('announcement_version_number desc')->select();
//				$_POST['announcement_version_number'] = $res[0]['announcement_version_number']+1;
////				cDebug($_POST);
//				$res = D('a_announcement_info')->insert($_POST);
//				if(!$res){
//					return ajaxReturn(\UPDATE_ERROR,'数据更新失败');
//				}
//				return ajaxReturn(\SUCCESS,'数据更新成功');
//			}
//			
//		}
//		return ajaxReturn(\UPDATE_ERROR,'未获取更新数据');
//	}
    
}
?>