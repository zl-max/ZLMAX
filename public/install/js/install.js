$(document).ready(check_msg);
// 检查是否通过环境验证
function check_msg(){
	var $href=$(".check_next").attr('href');
	if($href==''){
		$(".check_next").attr('disabled',true);
	}
	
}