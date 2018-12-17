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
    		$arr['validate']=input('valicate');
    		if(captcha_check($arr['validate'])==true){
    			return '验证码正确！';
    		}else{
    			return '验证码错误！';
    		}
    	}
    	return '没成功啊！';
    }
}
