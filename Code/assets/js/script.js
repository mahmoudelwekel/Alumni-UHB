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

$('.SeeMore').simpleLoadMore({
	count: 0,
	itemsToLoad: 2,
	item: '.item',
	btnHTML: '<h4 class="text-center"><i class="fas fa-chevron-down"></i></h4>'

});


$("#college").change(function(  ) {
	var college_id =  $("#college").find(":selected").val();
	getDepartments( college_id );
});

function getDepartments( college_id ) {
	var data = {
		type: "get_departments_by_college",
		college_id: college_id
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function (result) {
			$("#department").html(result);
		}
	});
}