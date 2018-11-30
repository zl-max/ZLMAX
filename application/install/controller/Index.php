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
namespace app\install\controller;
use think\Controller;

class Index extends Controller
{
	// 判断是否已经安装过
	protected function _initialize()
	{
		if(is_file(ROOT_PATH.'data/install.lock'))
		{
			header('Location:'.url('index'));
			exit();
		}
	}

    public function index()
    {
    	session('step',1);
    	session('error',false);
        return $this->fetch('step1');
    }

    function step2(){
    	// 按顺序安装
    	if(session('step')!==1&&session('step')!==3&&session('step')!==2)
    	{
    		header('Location:'.url('install'));
    	}
        session('error',false);
        session('step',2);
        //检测环境
        $env=check_env();
        $this->assign('env',$env);
        return $this->fetch('step2');
    }
}
