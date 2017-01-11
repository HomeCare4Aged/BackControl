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
		if($_GET['type']){
			$_REQUEST['p'] = $_GET['p'];
				if(session('selectedValue1') == 1){
					$cond['announcement_check_state'] = '未审核';
				}
				if(session('selectedValue1') == 2){
					$cond['announcement_check_state'] = '通过';
				}
				if(session('selectedValue1') == 3){
					$cond['announcement_check_state'] = '未通过';
				}
		}
		else{
			session('selectedValue1',null);
		}
		//------------------------
		$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:2;
    	
    	$schedule=D('s_store_shop_info')->getStoreShopInfos($cond,$page,$pageSize);
//		cDebug($cond);	
    	
    	$scheduletateCount=D('s_store_shop_info')->getStoreShopInfoCount($cond);
    	//分页控件
    	$pageObj = new \Think\Page($scheduletateCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
		$this->assign('pageRes',$pageRes);
    	$this->assign('shop_info',$schedule);   	
       	$this->display();
		//-------------------------
//  	if(isset($_POST['search']) && ($_POST['search']) != NULL){
//  		$cond['store_shop_name'] = array('like','%'.$_POST['search'].'%');
//			$this->assign('search',$_POST['search']);
//  	}
//  		$shop_info = M('s_store_shop_info')->where($cond)->select();
//  		if($shop_info === false){
//  		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
//  		}
//  	$this->assign('shop_info',$shop_info);
//  	$this->display();
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
    	$store['store_version_number'] = I('num');
    	try{
    		$store = D('s_store_shop_info')->where($store)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
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
    public function getData(){
    	$selectedValue = I('selectedValue');
    	session('selectedValue1',$selectedValue);
		if($_GET){
			$this->redirect('Store/index',array('p'=>$_GET['p'],'type'=>'true'));
		}
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
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:2;
    	$schedule=D('s_store_shop_info')->getStoreShopInfos($map,$page,$pageSize);	
    	$scheduletateCount=D('s_store_shop_info')->getStoreShopInfoCount($map);
    	//分页控件
    	$pageObj = new \Think\Page($scheduletateCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	$res['pageRes'] = $pageRes;
    	$res['schedule'] = $schedule;
    	echo json_encode($res);
    }

     public function history(){
		$showID = I('id');
    	$cond['store_shop_id'] = $showID;
    	$store = M('s_store_shop_info')->where($cond)->select();
    	$this->assign('store',$store);
    	$this->display();
    }

	public function details(){
		$store['store_shop_id']= I('id');
    	$store['store_version_number'] = I('num');
    	try{
    		$store = D('s_store_shop_info')->where($store)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	$this->assign('store',$store);
    	$this->display();
	}

    //搜索
	 public function getSearch(){
	 	$search = $_POST['search'];
    	$cond['state']=array('neq','关闭');
    	$admin = session(C('ADMIN_SESSION'));
//  	array('like','%'.$_POST['search'].'%');
    	$cond['store_shop_name'] = array('like','%'.$search.'%');
    	
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:2;
    	$schedule=D('s_store_shop_info')->getStoreShopInfos($cond,$page,$pageSize);	
//  	cdebug($schedule);
    	$scheduletateCount=D('s_store_shop_info')->getStoreShopInfoCount($cond);
    	//分页控件
    	$pageObj = new \Think\Page($scheduletateCount,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	$res['pageRes'] = $pageRes;
    	$res['schedule'] = $schedule;
//  	cdebug($res['pageRes']);
    	echo json_encode($res);
    	
    	
    	
    }
    
    function checkInfo(){
    	if(I('id')){
	    	$where = array(
	    		'store_shop_id' => array('eq',I('id')),
	    	);
	    	$res = D('s_store_checkpic_list')->where()->select();
    	}else{
    		return ajaxReturn(\DATABASE_ERROR,'未获取数据');
    	}
    	$this->assign('res',$res);
    	$this->display();
    }
}
?>