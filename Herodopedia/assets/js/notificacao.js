function main(){
	$('.nots').hide();
	$('.nots-button').on('click', function(){
		$('.nots').slideToggle(400);
		$(this).toggleClass('active');
	});
}

$(document).ready(main);