jQuery(function($){
	$(window).scroll(function() {
	if($(window).scrollTop() == 0){
		$('#scrollToTop').fadeOut("fast");
	} else {
		if($('#scrollToTop').length == 0){
			$('body').append('<div id="scrollToTop">'+
			'<a href="#">\u25B2</a>'+
			'</div>');
		}
		$('#scrollToTop').fadeIn("fast");
	}
});
$('#scrollToTop a').live('click', function(event){
		event.preventDefault();
		$('html,body').animate({scrollTop: 0}, 'slow');
	})
});