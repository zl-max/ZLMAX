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

//环境检测合并
function total_env(){
	return array_merge(check_env(),check_dirfile(),check_func());
}
//检测环境变量
function check_env(){
	$items=array(
		'envir' =>array('环境检测','推荐配置','最低要求','当前状态',''),
		'os'	=>	array('操作系统','不限制','Unix/WIN',PHP_OS,'check'),
		'php'	=>  array('php版本','5.5','5.5+',PHP_VERSION,'check'),
		'upload'=>	array('文件上传','不限制','2M+','未知','check'),
		'gd'	=>	array('GD库','2.0','2.0+','未知','check'),
		'disk'	=>  array('磁盘空间','100MB','100MB+','未知','check')
 	);

	//php版本不满足
 	if($items['php'][1]>$items['php'][3])
 	{
 		$items['php'][4]='times text-warning';
 		session('error',true);
 	}
 	//文件上传是否打开
 	if(@ini_get('file_uploads'))
 	{
 		$items['upload'][3]=ini_get('upload_max_filesize');
 	}

 	//检查gd库
 	$gd=function_exists('gd_info')?gd_info():array();
 	if(empty($gd['GD Version']))
 	{
 		$items['gd'][3]='未安装';
 		$items['gd'][4]='times text-warning';
 		session('error',true);
 	}else{
 		$items['gd'][3]=$gd['GD Version'];
 	}
 	unset($gd);

 	//检查磁盘空间
 	if(function_exists('disk_free_space'))
 	{
 		$disk_free=floor(disk_free_space(ROOT_PATH)/(1024*1024)).'MB';
 		if(rtrim($items['disk'][1],'MB')>rtrim($disk_free,'MB'))
 		{
 			$items['disk'][4]='times text-warning';
 			session('error',ture);
 		}
 		$items['disk'][3]=$disk_free;
 	}
 	return $items;
}

//文件读写检测
function check_dirfile(){
	$files=array(
		array('文件名称','文件要求','文件类型','当前状态',''),
		array('application','可读写','dir','可读写','check'),
		array('public/static','可读写','dir','可读写','check'),
		array('public/upload','可读写','dir','可读写','check'),
		array('data/backup','可读写','dir','可读写','check')
	);

	foreach ($files as  &$value) {
		// 取出路径
		$dir=ROOT_PATH.$value[0];
		if($value[2]=='dir') //文件夹检查
		{
			if(!is_writable($dir))  //存在并且可写返回true
			{
				if(is_dir($dir)){
					$value[3]='不可写';
				}else{
					$value[3]='不存在';
				}
				$value[4]='times text-warning';
				session('error',true);
			}
		}elseif($value[2]=='file'){
			if(file_exists($dir)){
				if(!is_writable($dir)){
					$value[3]='不可写';
					$value[4]='times text-warning';
					session('error',true);
				}
			}else{
					$value[3]='不存在';
					$value[4]='times text-warning';
					session('error',true);
			}
		}
	}
	return  $files;
}
//检测类和函数等是否可用
function check_func(){
	$funcs=array(
		array('函数名称','函数要求','函数类型','当前状态',''),
		array('PDO','开启','类','开启','check'),
		array('pdo_mysql','开启','模块','开启','check'),
		array('fileinfo','开启','模块','开启','check'),
		array('mb_strlen','开启','函数','开启','check'),
		array('file_get_contents','开启','函数','开启','check'),
		array('session','开启','其他','开启','check')
	);

	foreach ($funcs as &$value) {
		if(($value[2]=='类'&& !class_exists($value[0]))||
		($value[2]=='模块'&& !extension_loaded($value[0]))||
		($value[2]=='函数'&& !function_exists($value[0]))||
		($value[0]=='session'&& !session_status()))
		{
			$value[3]='未开启';
			$value[4]='times text-warning';
			session('error',true);
		}

	}
	return $funcs;
}

/**
 * 执行脚本
 * @param  [db] $db     [数据库连接]
 * @param  [sql] file_sql  [执行sql的文件名]
 * @param  [type] $table_pre [表名前缀]
 * @return ['']            [description]
 */
function execute_sql($db,$filename,$table_pre){
	$sql_content=file_get_contents(APP_PATH.'install/data/'.$filename);
	//获取的sql换行代替回车
	$sql_content=str_replace("\r","\n",$sql_content);

	//将字符串变成数组
	$sql_content=explode(";\n", $sql_content);

	//将语句中现在的前缀换成设置的前缀
	$default_pre='zl_';

	$sql_content=str_replace($default_pre,$table_pre,$sql_content);
	showmsg('开始安装数据库，请等待.....');
	foreach ($sql_content as $value) {
		$value=trim($value);
		if(empty($value)){continue;}
		preg_match('/CREATE TABLE `([^ ]*)`/', $value, $matches);
		if($matches){
			$table_name=$matches[1];
			showmsg($table_name.' 正在创建.....');
			$msg="创建数据库表{$table_name}";
			if($db->exec($value)!==false)
			{
				showmsg($msg.'成功！');
			}else{
				showmsg($msg.'失败！','error');
			}
		}else{
			$db->exec($value);
		}
	}
	complete();
}



