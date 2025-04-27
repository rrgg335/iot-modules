$(document).on('click','[confirm-href]',function(){
	if(confirm($(this).attr('confirm-text'))){
		window.location.href = $(this).attr('confirm-href');
	}
});
$(document).ready(function(){
	if(typeof feather != 'undefined'){
		feather.replace();
	}
});
$(document).ajaxComplete(function(){
	if(typeof feather != 'undefined'){
		feather.replace();
	}
});