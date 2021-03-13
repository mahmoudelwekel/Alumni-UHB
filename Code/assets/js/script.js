var docHeight = $(window).height();
var footerHeight = $('#footer').height();
var footerTop = $('#footer').position().top + footerHeight;

if (footerTop < docHeight) {
	$('#footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');


}



$(document).ready(function () {
	var table = $('#example').DataTable({
		stateSave: true,
		responsive: {
			details: true
		}
	});
});





