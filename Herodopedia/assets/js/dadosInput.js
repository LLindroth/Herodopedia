function main(){
	$('.dadosInput').hide();
	$('#inputPassword').on('focus', function(){
		$('.dadosInput').slideToggle(400);
		$(this).toggleClass('active');
	});
	$('#inputPassword').on('focusout', function(){
		$('.dadosInput').slideToggle(400);
		$(this).toggleClass('active');
	});
}

$(document).ready(main);