function main(){
	$('.error-button').on('click', function(){
		$('.error-box-r').slideToggle(400);
		$(this).hide();
	});
}

$(document).ready(main);