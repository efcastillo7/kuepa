function LearningPathService(params){
	var onError = function(e){
		console.log(e);
	}

	this.add = function (values){
		$.ajax({
			url: '/kuepa_api.php/learningpath',
			type: 'POST',
			dataType: 'json',
			data: {course_id: values.course_id, lesson_id: values.lesson_id, chapter_id: values.chapter_id},
			success: values.onSuccess,
			error: values.onError
		});
	}

	this.refresh = function(values){
		$.ajax({
			url: '/kuepa_api.php/learningpath',
			type: 'GET',
			dataType: 'json',
			success: values.onSuccess,
			error: values.onError
		});
	}

	this.remove = function(values){
		$.ajax({
			url: '/kuepa_api_dev.php/learningpath/' + values.id,
			type: 'DELETE',
			dataType: 'json',
			success: values.onSuccess,
			error: values.onError
		});
	}
}

