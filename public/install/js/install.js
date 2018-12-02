$(document).ready(check_msg);
// 检查是否通过环境验证
function check_msg(){
	if($(".check_next").attr('href')==''){
		$(".check_next").hide();
	}

}