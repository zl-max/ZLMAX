<?php
namespace app\admin\controller;
use app\index\controller\Base;
use think\Session;
class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    function login(){
    	if($this->request->isPost())
    	{  
            //return input('valicate');
    		$arr['validate']=input('valicate');
    		if(captcha_check($arr['validate'])==true){
    			$data=["code"=>"0","msg"=>"验证码正确"];
    		}else{
    			$data=["code"=>"1","msg"=>"验证码错误"];
    		}
            return json_encode($data);
    	}
    	return 'Request Need:POST';
    }
}
