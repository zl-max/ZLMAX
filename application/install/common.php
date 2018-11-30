<?php
//检测环境变量
function check_env(){
	$items=array(
		'os'	=>	array('操作系统' , '不限制' , 'Unix' , PHP_OS , 'check'),
		'php'	=>  array('php版本'  , '5.5' , '5.5+' , PHP_VERSION , 'check'),
		'upload'=>	array('文件上传' , '不限制' , '2M+', '未知' , 'check'),
		'gd'	=>	array('GD库' , '2.0' , '2.0+' , '未知' ,'check'),
		'disk'	=>  array('磁盘空间' , '100MB' , '100MB+' , '未知' , 'check')
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
 		$disk_free=disk_free_space(ROOT_PATH)/(1024*1024).'MB';
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
function check_file(){
	
}