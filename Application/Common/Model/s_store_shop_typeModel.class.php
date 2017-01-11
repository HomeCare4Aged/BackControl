<?php
namespace Common\Model;
use Think\Model;

class s_store_shop_typeModel extends Model{
	
	public function getType($cond=array(),$page,$pageSize){
		 $this->where($cond) //查询条件
			->order('store_type_id desc') ;     //排序规则
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
	
	//按照ID去更新数据
	public function updateAVideoInfoById($id,$data){
		if($id===null){
			throw_exception('店铺类型ID不合法');
		}
		if($data===null||!is_array($data)){
			throw_exception('店铺类型信息不合法');
		}
		$cond['store_type_id']=$id;
		return $this->where($cond)->save($data);
	}
}
?>