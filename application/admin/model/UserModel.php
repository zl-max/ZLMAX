<?php
// +----------------------------------------------------------------------
// | ZL [ WE CAN DO IT！！！]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2018 Z.L All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( NO )
// +----------------------------------------------------------------------
// | Author: Z.L <582152734@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\model;
use think\Model;
use think\Db;

class UserModel extends Model{

	public function saveAdmin($arr=''){
		if(!empty($arr)){
			Db::query("insert into ".$arr['prefix']."user(username,userpwd,useremail) select '".$arr['manager']."','".md5($arr['manager_pwd'])."','".$arr['manager_email']."'");
			return true;
		}
		return false;
	}
}