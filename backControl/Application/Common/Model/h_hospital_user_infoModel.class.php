<?php
namespace Common\Model;
use Think\Model;

class h_hospital_user_infoModel extends Model{
	//设置表单验证规则
	protected $_validate = array(
	array('hospital_user_name','require','管理员名称不能为空！'),
	array('hospital_user_no','require','账号不能为空！'),
	array('hospital_user_psw','require','密码不能为空！'),
	);
	
	// 是否批处理验证
    protected $patchValidate = true;
	
	
	public function findAdminByName($adminName){
		if (!$adminName){
			throw_exception('管理员账号不合法');
		}
		$condition['hospital_user_no'] = $adminName;
		$res = $this->where($condition)->find();
		return $res;
	}
	//按照id查询
	public function findHospitalUserById($id,$cond){
		if ($id === null){
			throw_exception('管理员ID不合法');
		}
		return $this->where($cond)->find();
	}
	
	public function getAdminInfo($cond=array(),$page,$pageSize){
			//处理分页的业务
			if ($page === null || $pageSize === null){
				$page = $page !== null  ? $page : 1 ;
				$pageSize = $pageSize !== null  ? $pageSize : 10 ;
				$offset = ($page-1) * $pageSize; //每页的起点(偏移量)
				$this->limit($offset,$pageSize);	 //查询条数
			}
			$list = M('h_hospital_user_info')
			->where($cond)
			->limit($offset,$pageSize)
			->join('h_user_limit_info on h_hospital_user_info.hospital_user_id=h_user_limit_info.hospital_user_id')
//			->order('community_hospital_numbers desc,hospital_user_no asc'); 
			->select();
		return $list;
	}
	
	public function getAdminInfoCount($cond=array()){
		return $this->where($cond)->count();
	}
	
	
	//新增管理员
	public function insert($data){
	if (!$data || !is_array($data)){
			throw_exception('新增管理员信息不合法');
		}
	
		//如果新增成功，会返回新增记录的主键值
		return $this->add($data);
	}
	
	
	//按照ID去更新数据
	public function updateAVideoInfoById($id,$data){
		if($id===null){
			throw_exception('管理员ID不合法');
		}
		if($data===null||!is_array($data)){
			throw_exception('管理员不合法');
		}
		$cond['hospital_user_id']=$id;
		return $this->where($cond)->save($data);
	}
	
	public function getHospitalAccountInfo($cond=array(),$page,$pageSize){
			
			if ($page === null || $pageSize !== null){
				$page = $page !== null  ? $page : 1 ;
				$pageSize = $pageSize !== null  ? $pageSize : 10 ;
				$offset = ($page-1) * $pageSize; //每页的起点(偏移量)
			}
			
			$list=M('h_hospital_user_info')
			->order('community_hospital_numbers desc')
			->limit($offset,$pageSize)
			->join('h_hospitals_info on h_hospital_user_info.community_hospitals_id=h_hospitals_info.community_hospitals_id')
			->where($cond)
			->select();
		return $list;
	}
	
	public function getMenuCount(){
		return $this->count();
	}
	
	//获取权限信息
	public function getMenus($cond=array()){
			$list = M('a_limit_type_info')->where($cond)->select();
		return $list;
	}
	public function getAssign($data){
		$list = M('h_hospital_user_info')
		->where($data)
		->join('h_user_limit_info on h_hospital_user_info.hospital_user_id=h_user_limit_info.hospital_user_id')
		->select();
		return $list;
	}
	//存路径
	function saveAuth($role_id,$data){
		if($role_id === null){
			throw_exception('员工ID不合法');
		}
		if($data === null || !is_array($data)){
			throw_exception('员工数据不合法');
		}
		$role_menu_ids = implode(',',$data);
		$menus = D('h_user_limit_info')->select($role_menus_ids);
		$role_menu_path = rtrim($role_menu_path,',');
		$updateData = array(
			'limit_id' => $role_menu_ids,
		);
		$cond = array(
			'hospital_user_id' => $role_id,
		);
		return M('h_user_limit_info')->where($cond)->save($updateData);
		
	}
}
?>