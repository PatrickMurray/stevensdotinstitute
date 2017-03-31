$(document).ready(function() {
	$(".board header a.start_thread").click(function() {
		$(".board header noscript").toggleClass("start_thread");
	});

	$(".thread figure img, .post figure img").click(function() {
		$(this).parent().toggleClass("expanded");
	});
});
