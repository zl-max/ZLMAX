<?php		
// +----------------------------------------------------------------------
// | ZL [ WE CAN DO IT!!!]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2018 Z.L All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( NO )
// +----------------------------------------------------------------------
// | Author: Z.L <582152734@qq.com>
// +----------------------------------------------------------------------
namespace app\index\controller;
//引入模板控制器类
use think\Controller;

class Base extends Controller{	
	protected function _initialize(){
		//先安装
		if(!is_file(APP_PATH.'install/data/install.lock'))
		{
			header('Location:'.url('install/Index/index'));
			exit();
		}
	}
}