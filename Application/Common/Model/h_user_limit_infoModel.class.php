<?php
namespace Common\Model;
use Think\Model;

class h_user_limit_infoModel extends Model{
	//新增管理员
	public function insert($data){
	if (!$data || !is_array($data)){
			throw_exception('新增管理员信息不合法');
		}
	
		//如果新增成功，会返回新增记录的主键值
		return $this->add($data);
	}
	
	
}
?>