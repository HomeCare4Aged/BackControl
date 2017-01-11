<?php
namespace Admin\Controller;
use Think\Controller;
import("ZHKit.Constants");
import("ZHKit.ImageUploader");
class VideoController extends Controller {
	public function index(){
		//模糊搜索逻辑
    	if(isset($_POST['search']) && ($_POST['search']) != NULL){
    		$cond['video_title'] = array('like','%'.$_POST['search'].'%');
			$this->assign('search',$_POST['search']);
    	}
    	
	$admin = session(C('ADMIN_SESSION'));
	$sender_id = $admin['hospital_user_id'];
	$cond['sender_id'] = $sender_id;
	$cond['state']=array('neq','关闭');
    	$articles = M('a_video_info')->where($cond)->select();
    	if($articles === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}	
    //分页逻辑
    $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1 ;
    $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10 ;
    $articles = D('a_video_info')->getArticles($cond,$page,$pageSize);
    $articleCount = D('a_video_info')->getArticleCount($cond);
    	
    //分页控件
    $pageObj = new \Think\Page($articleCount,$pageSize);
    	
    //获取分页结果
    $pageRes = $pageObj->show();
    	
    //绑定模板变量        
    $this->assign('articles',$articles);
    $this->assign('pageRes',$pageRes);
    	
    //输出模板
    $this->display();
    }
     //展示新增页面&新增数据
    public function add(){
    	if($_POST){
    		if($_POST['id']){
				if(!$_POST['error_message'] || $_POST['error_message'] == ''){
					return ajaxReturn(\UPLOAD_FAILURE,'请填写驳回原因');
				}
					$data['id'] = $_POST['id'];
					$data['num'] = intval($_POST['num']);
					$data['error_message'] = $_POST['error_message'];
					$data['video_check_state']='未通过';
					$admin = session(C('ADMIN_SESSION'));
    				$data['check_user_id'] = $admin['hospital_user_no'];
					return $this->save($data);
				}
			if($_POST['idtwo']){
//				cDebug($_POST);
				$data['id'] = $_POST['idtwo'];
				$data['num'] = intval($_POST['numtwo']);
				$data['video_check_state'] ='已通过';
				$admin = session(C('ADMIN_SESSION'));
    			$data['check_user_id'] = $admin['hospital_user_no'];
				return $this->save($data);
			}
    		//表单验证
    		$validData = D('a_video_info')->create();
    		if($validData){
    			//执行新增操作
    			$add_data['video_id'] = get_uuid();
    			$validData['send_datetime']=date('Y-m-d H:i:s');
    			$validData['video_id'] = $add_data['video_id'];
    			$admin = session(C('ADMIN_SESSION'));
    			$validData['sender_id'] = $admin['hospital_user_id'];
    			$res = D('a_video_info')->insert($validData);
    			
    			if($res === FALSE){
    				return ajaxReturn(\DATABASE_ERROR,'数据库新增失败！');
    			}
    			return ajaxReturn(\SUCCESS,'数据库新增成功！');
    		}else{
    			return ajaxReturn(\VALIDATE_ERROR,D('a_video_info')->getError());
    		}
    	}else{
    		$admin = session(C('ADMIN_SESSION'));
    		$user = $admin['hospital_user_name'];
    		$sent_time = date('Y-m-d H:i:s');
    		$type = D('a_video_type')->select();
    		$this ->assign('type',$type);
			$this ->assign('user',$user);
			$this ->assign('sent_time',$sent_time);
    		$this->display();
    	}
    }
    
    //浏览详情页展示API
    public function edit1(){
    	$video['video_id'] = I('id');
    	$video['video_num'] = I('num');
    	try{
    		$menu = D('a_video_info')->where($video)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	$cond =array(
    	'video_type_id'=>array('eq',$menu['video_type_id'])
    	);
    	$res = D('a_video_type')->where($cond)->find();
    	$menu['video_type_name'] = $res['video_type_name'];
    	$where =array(
		'hospital_user_id'=>array('eq',$menu['sender_id']),
		'community_hospitals_id'=>array('eq',9999),
		);
    	$res1 = D('h_hospital_user_info')->where($where)->find();
    	$menu['hospital_user_name'] = $res1['hospital_user_name'];
    	if ($menu === fales){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
    	}
    	$this->assign('menu',$menu);
    	$this->display();
    } 
    
//   //上传视频
//  function ajaxUploadImage(){
//  $upload = new \Think\Upload();// 实例化上传类
//  $upload->maxSize   =     3145728 ;// 设置附件上传大小
//  $upload->exts      =     array('mov', 'mp4', 'avi', 'rmvb','jpg');// 设置附件上传类型
//  $upload->rootPath  =     './UploadAudios/'; // 设置附件上传根目录
//  $upload->savePath  =     ''; // 设置附件上传（子）目录
//  // 上传文件 
//  $info   =   $upload->upload();
//  cDebug($info);
//  if(!$info) {
//      return ajaxReturn(\UPLOAD_FAILURE,'视频上传失败');
//  }else{
//      $info = $upload->rootPath.$info['file']['savepath'].$info['file']['savename'];
//      $fullAudioPath = SITE_HOST.ltrim($info,'./');
//      return ajaxReturn(\SUCCESS,'视频上传成功',$fullAudioPath);
//  }
// }
    
   //审核页展示API
    public function edit(){
    	$video['video_id'] = I('id');
    	$video['video_num'] = I('num');
    	try{
    		$menu = D('a_video_info')->where($video)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	$cond =array(
    	'video_type_id'=>array('eq',$menu['video_type_id'])
    	);
    	$res = D('a_video_type')->where($cond)->find();
    	$menu['video_type_name'] = $res['video_type_name'];
    	$where =array(
		'hospital_user_id'=>array('eq',$menu['sender_id']),
		'community_hospitals_id'=>array('eq',9999),
		);
    	$res1 = D('h_hospital_user_info')->where($where)->find();
    	$menu['hospital_user_name'] = $res1['hospital_user_name'];
    	if ($menu === fales){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
    	}
    	$this->assign('menu',$menu);
    	$this->display();
    } 
   
    //添加视频类型
    function typeName(){
    	if($_POST['type-name']){
    		$data['video_type_id'] = get_uuid();
    		$data['video_type_name'] = $_POST['type-name'];
    		$res = D('a_video_type')->add($data);
    		if($res){
    			return ajaxReturn(\SUCCESS,'添加类型成功！');
    		}
    		return ajaxReturn(\DATABASE_ERROR,'添加失败');
    	}
    	return ajaxReturn(\DATABASE_ERROR,'请填写视频类型');
    }
   
   //视频审核
    public function check(){
    	$cond = array(
		    'video_check_state'=>array('eq','未审核'),
		    'state'=>array('neq','关闭'),
			);
		$admin = session(C('ADMIN_SESSION'));
	    $sender_id = $admin['hospital_user_id'];
//	    cDebug($sender_id);
		$where = array(
		    'video_check_state'=>array('neq','未审核'),
		    'check_user_id'=>array('eq',$sender_id),
			);
		$where1 = array(
		    'video_check_state'=>array('eq','已通过'),
			);
    	 //分页
        $page=$_REQUEST['p'] ?$_REQUEST['p']:1;
    	$pageSize=$_REQUEST['pageSize']?$_REQUEST['pageSize']:10;
    	$ancheckstate=D('a_video_info')->getAncheckstates($cond,$page,$pageSize);
    	$ancheckstate2=D('a_video_info')->getAncheckstates($where,$page,$pageSize);
    	$ancheckstate3=D('a_video_info')->getAncheckstates($where1,$page,$pageSize);
    	$ancheckstatesCount=D('a_video_info')->getAncheckstatesCount($cond);
    	$ancheckstatesCount2=D('a_video_info')->getAncheckstatesCount($where);
    	$ancheckstatesCount3=D('a_video_info')->getAncheckstatesCount($where1);
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
    
    //视频审核修改状态API
   public function setStatus(){
		if($_POST){
			try{
				$res = D('a_video_info')->updateMenuById($_POST['id'],$_POST['num'],$_POST);
				if($res === FALSE){
					return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
				}
				return ajaxReturn(\SUCCESS,'更新状态成功');
			}catch(Exception $e){
				return ajaxReturn(\UPDATE_ERROR,$e->getMessage());
			}
		}
		return ajaxReturn(\ARGUMENT_ERROR,'未获取更新数据');
	}
    
     public function getData(){
    	$selectedValue = I('selectedValue');
    	$admin = session(C('ADMIN_SESSION'));
  	    $sender_id = $admin['hospital_user_id'];
    	if($selectedValue == 0){
    		$map['state']=array('neq','关闭');
    		$map['sender_id'] = $sender_id;
    		$announcement = M('a_video_info')->where($map)->select();
    	}
    	if($selectedValue == 1){
    		$map['state']=array('neq','关闭');
    		$map['video_check_state'] = '未审核';
    		$map['sender_id'] = $sender_id;
    		$announcement = M('a_video_info')->where($map)->select();
    	}
    	if($selectedValue == 2){
    		$map['state']=array('neq','关闭');
    		$map['video_check_state'] = '已通过';
    		$map['sender_id'] = $sender_id;
    		$announcement = M('a_video_info')->where($map)->select();
    	}
    	if($selectedValue == 3){
    		$map['state']=array('neq','关闭');
    		$map['video_check_state'] = '未通过';
    		$map['sender_id'] = $sender_id;
    		$announcement = M('a_video_info')->where($map)->select();
    	}
    	
    	echo json_encode($announcement);
    }
     public function getSourse(){
     	$selectedValue = I('selectedValue');
     	$cond['state']=array('neq','关闭');
    	$announcement = D('a_video_info')->where($cond)->select();
    	if($announcement === false){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败！');
    	}
    	$admin = session(C('ADMIN_SESSION'));
  	    $sender_id = $admin['hospital_user_id'];
    	if($selectedValue == 0){
    		$map['state']=array('neq','关闭');
    		$map['sender_id'] = $sender_id;
    		$announcement = M('a_video_info')->where($map)->select();
    	}
    	if($selectedValue == 1){
    		$map['state']=array('neq','关闭');
    		$map['video_check_state']=array('eq','已通过');
    		$announcement = M('a_video_info')->where($map)->select();
    	}
    	
    	echo json_encode($announcement);
    }
   //所有版本展示页
   public function history(){
     	$cond=array(
     	    'state'=>array('neq','关闭'),
     	    );
		$showID = I('id');
    	$cond['video_id'] = $showID;
    	$announcement = M('a_video_info')->join('a_video_type on a_video_info.video_type_id=a_video_type.video_type_id')->where($cond)->order('video_num desc')->select();
    	$this->assign('announcement',$announcement);
    	$this->display();
    }
    
   //编辑页展示API
    public function add1(){
    	$video_id = I('id');
    	$video_num = I('num');
		$cond =array(
		'video_id'=>array('eq',$video_id),
		'video_num'=>array('eq',$video_num),
		);
    	try{
    		$menu = D('a_video_info')->where($cond)->find();
    	}catch(Exception $e){
    		return ajaxReturn(\QUERY_ERROR,$e->getMessage());
    	}
    	if ($menu === fales){
    		return ajaxReturn(\DATABASE_ERROR,'数据库查询失败');
    	}
    	$admin = session(C('ADMIN_SESSION'));
    	$user = $admin['hospital_user_name'];
		$community_hospitals_name = $res['community_hospitals_name'];
    	$sent_time = date('Y-m-d H:i:s');
    	$type = D('a_video_type')->select();
    	$this ->assign('type',$type);
		$this ->assign('user',$user);
		$this ->assign('sent_time',$sent_time);
    	$this->assign('menu',$menu);
    	$this->display();
    } 
    
    //更新数据API
    public function save($data){
    	$video_id = $data['id'];
    	$video_num = $data['num'];
    	unset($data['id']);
    	unset($data['num']);
    	$admin = session(C('ADMIN_SESSION'));
  	    $data['video_checker_id'] = $admin['hospital_user_id'];
    	$cond['video_num'] = $video_num;
    	$cond['video_id'] = $video_id ;
    	$data['video_check_time'] = date('Y-m-d H:i:s');
    	$res = M('a_video_info')->where($cond)->save($data);
    	
    		if($res===false){
    		return ajaxReturn(\DATABASE_ERROR,'修改失败');
    	}
    	return ajaxReturn(\SUCCESS,'操作成功！');
    }
    //编辑逻辑&“未通过”再次提交
    public function update(){
		if($_POST){
			if($_POST['video_check_state'] == '未审核'){
					$_POST['send_datetime'] = date('Y-m-d H:i:s');
					$res = D('a_video_info')->save($_POST);
				if(!$res){
					return ajaxReturn(\UPDATE_ERROR,'数据更新失败');
				}
				return ajaxReturn(\SUCCESS,'数据更新成功');
			}
			if($_POST['video_check_state'] == '未通过'){
				$_POST['send_datetime'] = date('Y-m-d H:i:s');
				$admin = session(C('ADMIN_SESSION'));
				$_POST['sender_id'] = $admin["hospital_user_id"];
				$_POST['video_check_state'] ='未审核';
				$where = array(
						'video_id'=>array('eq',$_POST['video_id']),
					);
				$res = D('a_video_info')->where($where)->order('video_num desc')->select();
				
				if($res[0]['video_check_state'] == '未审核'){
					$where = array(
						'video_id'=>array('eq',$_POST['video_id']),
						'video_num'=>array('eq',$res[0]['video_num']),
					);
					$_POST['video_num'] = $res[0]['video_num'];
					$res = D('a_video_info')->where($where)->save($_POST);
				}elseif($res[0]['video_check_state'] == '已通过'){
					return ajaxReturn (\UPDATE_ERROR,'该视频已有通过版本');
				}else{
					$_POST['video_num'] = $res[0]['video_num']+1;
					$res = D('a_video_info')->insert($_POST);
				}
				if(!$res){
					return ajaxReturn(\UPDATE_ERROR,'数据更新失败');
				}
				return ajaxReturn(\SUCCESS,'数据更新成功');
			}
			
		}
		return ajaxReturn(\UPDATE_ERROR,'未获取更新数据');
    }
     //所有版本展示页
   public function history1(){
     	$cond=array(
     	    'state'=>array('neq','关闭'),
     	    );
		$showID = I('id');
    	$cond['video_id'] = $showID;
    	$announcement = M('a_video_info')->join('a_video_type on a_video_info.video_type_id=a_video_type.video_type_id')->where($cond)->order('video_num desc')->select();
    	$this->assign('announcement',$announcement);
    	$this->display();
    }
}
?>