$(document).ready(function() {
	$(".thread figure img, .post figure img").click(function() {
		$(this).parent().toggleClass("expanded");
	});
});
