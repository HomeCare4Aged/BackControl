<?php
namespace Common\Model;
use Think\Model;

class s_store_shop_infoModel extends Model{
	//获取商户信息
	public function getStoreShopInfos($cond=array(),$page,$pageSize){
		//处理分页的业务
		if ($page!== null || $pageSize !== null){
			$page = $page !== null ? $page : 1;
			$pageSize = $pageSize !== null ? $pageSize : 15;
			//每页的起点（偏移量）
		    $offset = ($page-1) * $pageSize;
		}   
		$list=M('s_store_shop_info')
			->limit($offset,$pageSize)
//			->join('s_store_check_state on s_store_shop_info.store_check_state_id=s_store_check_state.store_check_state_id')
			->order('send_datetime asc')
			->where($cond)
			->select();
		return $list;
	}
	
	//获取商户总数
	public function getStoreShopInfoCount($cond=array()){
		return $this->where($cond)->count();
	}

//按照id查询
	public function findMenuById($id){
		if ($id === null){
			throw_exception('店铺ID不合法');
		}
		$cond['store_shop_id'] = intval($id);
		return $this->where($cond)->find();
	}
}
?>