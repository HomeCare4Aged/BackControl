<?php
namespace Common\Model;
use Think\Model;

class a_announcement_typeModel extends Model{
	
	public function getType($cond=array(),$page,$pageSize){
		 $this->where($cond) //查询条件
			->order('announcement_type_id desc') ;     //排序规则
			//处理分页的业务
			if ($page === null || $pageSize === null){
				$page = $page !== null  ? $page : 1 ;
				$pageSize = $pageSize !== null  ? $pageSize : 10 ;
				$offset = ($page-1) * $pageSize; //每页的起点(偏移量)
				$this->limit($offset,$pageSize);	 //查询条数
			}
			$list=$this->select();
		return $list;
	}
	
	public function getTypeCount($cond=array()){
		return $this->where($cond)->count();
	}
	//设置表单验证规则
	protected $_validate = array(
	array('announcement_type_name','require','公告类型不能为空！'),
	);
	
	//新增公告类型数据
	public function insert1($data1){
	if (!$data1 || !is_array($data1)){
			throw_exception('新增公告类型信息不合法');
		}
		
		//如果新增成功，会返回新增记录的主键值
		return $this->add($data1);
	}
	
	//按照id查询
	public function findHospitalUserById($id,$cond){
		if ($id === null){
			throw_exception('公告类型ID不合法');
		}
		return $this->where($cond)->find();
	}
	
	//按照ID去更新数据
	public function updateAVideoInfoById($id,$data){
		if($id===null){
			throw_exception('公告类型ID不合法');
		}
		if($data===null||!is_array($data)){
			throw_exception('公告类型信息不合法');
		}
		$cond['announcement_type_id']=$id;
		return $this->where($cond)->save($data);
	}
}
?>