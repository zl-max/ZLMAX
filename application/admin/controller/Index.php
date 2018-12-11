<?php
namespace app\admin\controller;
use app\index\controller\Base;

class Index extends Base
{
    public function index()
    {
    	return $this->fetch();
    }

    function login(){
    	return '登录了';
    }
}
