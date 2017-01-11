<?php
namespace Admin\Controller;
class HospitalRegisterController extends CommonController {
	public function index(){
    	//分页逻辑
    	if($_POST['search'] != null){
			$cond['community_hospitals_name'] = array('like','%'.$_POST['search'].'%');
			
		}
    	$page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:10;
    	$hai=D('h_hospital_user_info')->getHospitalAccountInfo($cond,$page,$pageSize);
//  	$hai = D('h_hospital_user_info')->where($cond)->select();
    	$Count=D('h_hospital_user_info')->getMenuCount($cond);
    	//分页控件
    	$pageObj = new \Think\Page($Count,$pageSize);
    	//获取分页结果
    	$pageRes = $pageObj->show();
    	//绑定模板变量
    	$this->assign('hai',$hai);
    	$this->assign('pageRes',$pageRes);
    	//输出模板
        $this->display();
	}
	public function add(){
		if($_POST){
			$validData1 = D('h_hospitals_info')->create();
    		if($validData1){
    			$community_hospitals_id = get_uuid();
    			$hospital_user_id = get_uuid();
    			$res = D('h_hospitals_info')->order('community_hospital_numbers desc')->select();
				$num = $res[1]['community_hospital_numbers'] + 1;
				$validData1['community_hospital_numbers']=sprintf("%04d", $num);
    			$validData1['community_hospitals_id']=$community_hospitals_id;
    			$validData2['community_hospitals_id']=$community_hospitals_id;
    			$validData2['hospital_user_id'] = $hospital_user_id;
//  			cdebug($validData2);
    			//执行新增操作
    			$res['chi'] = D('h_hospitals_info')->add($validData1);
    			$res['hai'] = D('h_hospital_user_info')->add($validData2);
    			if($res === FALSE){
    				return ajaxReturn(\DATABASE_ERROR,'账号申请失败！');
    			}
    			return ajaxReturn(\SUCCESS,'账号申请成功！');
    		}
    			return ajaxReturn(\VALIDATE_ERROR,D('h_hospitals_info')->getError());
		}
		$res = D('h_hospitals_info')->order('community_hospital_numbers desc')->select();
		$num = $res[1]['community_hospital_numbers'] + 1;
		$num=sprintf("%04d", $num);
		$this->assign('num',$num);
		$this->display();
	}
	
	public function setState(){
		if($_POST){
			$where = array(
				'community_hospitals_id' => array(
					'eq',$_POST['id'],
				),
			);
	    		$res =D('h_hospitals_info')->where($where)->select();
//	    		cDebug($res);
	    		if($res[0]['state'] == '开启'){
	    			$date['state'] = '关闭';
	    		}
	    		if($res[0]['state'] == '关闭'){
	    			$date['state'] = '开启';
	    		}
	    		$state = D('h_hospitals_info')->where($where)->save($date);
//	    		cDebug($state);
	    		if($state==false){
	    			return ajaxReturn(\DATABASE_ERROR,"更改失败");
	    		}
	    		return ajaxReturn(\SUCCESS,'更改成功！');
    	}
    	return ajaxReturn(\ARGUMENT_ERROR,'未获取更新数据');
	}
	
	public function setPsw(){
		if($_POST){
//			cDebug($_POST);
			$where = array(
				'community_hospitals_id' => array(
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
	
	
}
?>