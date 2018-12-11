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
        if(session('step')!=2 && session('step')!=3 && session('step')!=4)
        {
            $this->redirect($this->request->baseFile());
        } 
        
        session('step',3);     
        return $this->fetch('step3');
    }

    function step4(){
        if(session('step')!=3&&session('step')!=4)
        {
            $this->redirect($this->request->baseFile());
        }
        // 接收post传来的值进行处理
        if($this->request->isPost()){
            session('step',4);
            $dbconfig['type']='mysql';
            $dbconfig['hostname']=input('dbhost');
            $dbconfig['username']=input('dbuser');
            $dbconfig['password']=input('dbpwd');
            $dbconfig['hostport']=input('dbport');   
            $dbconfig['manager']=input('manager'); 
            $dbconfig['manager_pwd']=input('manager_pwd'); 
            $dbconfig['manager_email']=input('manager_email');       
            // 连接数据库
            $dsn="{$dbconfig['type']}:host={$dbconfig['hostname']};port={$dbconfig['hostport']};charset=utf8";
            try{
                $db=new  \PDO($dsn,$dbconfig['username'],$dbconfig['password']);
            }catch(\PDOException $e){
                $this->error('数据库连接错误，请检查',url('install/Index/step3'));
            }

            $dbname=strtolower(input('dbname'));
            $dbconfig['database']=$dbname;

            //先检查数据库是否存在
            $exist_db_sql="CREATE DATABASE if not exists {$dbname} default character set utf8;";
        
            $db->exec($exist_db_sql)||$this->error('数据库已存在');
            
            $dsn="{$dbconfig['type']}:host={$dbconfig['hostname']};port={$dbconfig['hostport']};dbname={$dbname};charset=utf8";
            try{
                $db=new  \PDO($dsn,$dbconfig['username'],$dbconfig['password']);
            }catch(\PDOException $e){
                $this->error('数据库连接错误，请检查',url('install/Index/step3'));
            }
            
            $dbconfig['prefix']=strtolower(trim(input('dbprefix')));
            $dbprefix=strtolower(trim(input('dbprefix')));

            echo $this->fetch('step4');
            write_config($dbconfig);
            execute_sql($db,'zlmax.sql',$dbprefix);
            create_admin($dbconfig);
        }
    }

    function step5(){

        if(session('step')!==4){
            $this->redirect($this->request->baseFile());
        }
$msg=<<<EO
alreay inclock:
The sys is completed,if you want to repeat the sys. please delete the 
file,but the database is important,plwase backup; 
EO;
        file_put_contents(APP_PATH.'install/data/install.lock', $msg);
        return $this->fetch('step5');
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
           exit("数据库连接成功");
        }else{
            exit("post方式传数据!");
        }
    }
}
