<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @param  [string] 显示的内容 
 * @param  [string] 是否出错   
 * @return [string] 2秒循环显示        
 */
function showmsg($content,$class=''){
	echo "<script type=\"text/javascript\">showmsg(\"{$content}\",\"{$class}\")</script>";
	ob_flush();
	flush();
	sleep(2);
}

function complete()
{
	echo "<script type=\"text/javascript\">complete()</script>";
}