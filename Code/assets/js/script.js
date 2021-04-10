var docHeight = $(window).height();
var footerHeight = $('#footer').height();
var footerTop = $('#footer').position().top + footerHeight;

if ( footerTop < docHeight ) {
	$('#footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
}

$(document).ready(function() {
	var table = $('#example').DataTable({
		stateSave: true,
		responsive: {
			details: true
		}
	});
});

function render_comments() {
	$('.SeeMore').simpleLoadMore({
		count: 0,
		itemsToLoad: 2,
		item: '.item',
		btnHTML: '<h4 class="text-center"><i class="fas fa-chevron-down"></i></h4>'
	});
}
render_comments();

$("#college").change(function() {
	var college_id = $("#college").find(":selected").val();
	getDepartments(college_id);
});

function getCourses( category_id ) {
	var data = {
		type: "get_courses_by_category",
		category_id: category_id
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function( result ) {
			$("#courses").html(result);
			render_comments();
		}
	});
}

function getWorkshops( category_id ) {
	var data = {
		type: "get_workshops_by_category",
		category_id: category_id
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function( result ) {
			$("#workshops").html(result);
			render_comments();
		}
	});
}

function getJobs( category_id ) {
	var data = {
		type: "get_jobs_by_category",
		category_id: category_id
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function( result ) {
			$("#jobs").html(result);
		}
	});
}

function getDepartments( college_id ) {
	var data = {
		type: "get_departments_by_college",
		college_id: college_id
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function( result ) {
			$("#department").html(result);
		}
	});
}

// change is-checked class on buttons
$('.button-group').each(function( i, buttonGroup ) {
	var $buttonGroup = $(buttonGroup);
	$buttonGroup.on('click', 'button', function() {
		$buttonGroup.find('.is-checked').removeClass('is-checked');
		$(this).addClass('is-checked');
	});
});

