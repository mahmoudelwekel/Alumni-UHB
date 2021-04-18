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
			renderStars();
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
			console.log(result);
			render_comments();
			renderStars();
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

function renderStars() {
	$('.kv-ltr-theme-fas-star').rating({
		//hoverOnClear: false,
		theme: 'krajee-fas',
		containerClass: 'is-star',
		showCaption: false,
		stars: 5
	});
}

renderStars();

function rate_course(input) {
	var data = {
		type: "put_rate_course",
		course_id: input.name.replace("rate-", ""),
		rate_value: input.value
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function( result ) {
			result = JSON.parse( result );
			if ( result['type'] === "failed" ) {
				alert(result['details']);
			} else if ( result['type'] === "succeeded" ) {
				alert("Thanks for Your Rating, Course Rating now is: " + result['details']);
				$("#rate-" + data["course_id"]).html(
					'<input name="rate-' + data['course_id'] + '"\n' +
					'class="kv-ltr-theme-fas-star rating-loading" value="' + result['details'] +'" dir="ltr"\n' +
					'data-size="xs" onchange="rate_course(this)">'
				);

				renderStars();
			}
		}
	});
}

function rate_workshop(input) {
	var data = {
		type: "put_rate_workshop",
		workshop_id: input.name.replace("rate-", ""),
		rate_value: input.value
	};

	$.ajax({
		url: "../api.php",
		type: "get",
		data: data,
		success: function( result ) {
			result = JSON.parse( result );
			if ( result['type'] === "failed" ) {
				alert(result['details']);
			} else if ( result['type'] === "succeeded" ) {
				alert("Thanks for Your Rating, Workshop Rating now is: " + result['details']);
				$("#rate-" + data["workshop_id"]).html(
					'<input name="rate-' + data['workshop_id'] + '"\n' +
					'class="kv-ltr-theme-fas-star rating-loading" value="' + result['details'] +'" dir="ltr"\n' +
					'data-size="xs" onchange="rate_workshop(this)">'
				);
				renderStars();
			}
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

