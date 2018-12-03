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
        return $this->fetch('step1');
    }

    function step2(){
    	// 按顺序安装       
    	if(session('step')!=1&&session('step')!=3&&session('step')!=2)
    	{
    		$this->redirect($this->request->baseFile());
    	}
        session('error',false);
        session('step',2);
        //检测环境
        $env=total_env();
        $this->assign('env',$env);
        return $this->fetch('step2');
    }

    function step3(){
        //请按步骤安装
        if(session('step')!=2 && session('step')!=3)
        {
            $this->redirect($this->request->baseFile());
        } 
             
        return $this->fetch('step3');
    }

    // 验证数据库连接是否正确
    function testdb(){
        if(request()->isPost()){
            $dbconfig=input("post.");
            $dsn = "mysql:host={$dbconfig['hostname']};port={$dbconfig['hostport']};charset=utf8";
            try {
                $db = new \PDO($dsn, $dbconfig['username'], $dbconfig['password']);
            } catch (\PDOException $e) {
                die("");
            }
            try{
                $db->query("show databases;");
            }catch (\PDOException $e){
                die("");
            }
           exit("1");
        }else{
            exit("need post!");
        }
    }
}
