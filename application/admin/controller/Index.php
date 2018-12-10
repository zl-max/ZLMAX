<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\UserModel;

class Index extends Controller
{
    public function index()
    {
    	$arr=array('prefix'=>'zl_',
    		'username'=>'zhangsan'
    	);
    	$user=new UserModel();
    	$msg=$user->saveAdmin($arr);
        return $msg;
    }

    function login(){
    	return '登录了';
    }
}
