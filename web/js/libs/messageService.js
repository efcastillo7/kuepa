function MessageService(params){
	var onError = function(e){
		console.log(e);
	}

	this.send = function (values){
		$.ajax({
			url: '/kuepa_api.php/message',
			type: 'POST',
			dataType: 'json',
			data: {recipients: values.recipients, subject: values.subject, content: values.content},
			success: values.onSuccess,
			error: values.onError
		});
	}

	this.reply = function(values){
		$.ajax({
			url: '/kuepa_api.php/message/' + values.message_id,
			type: 'POST',
			dataType: 'json',
			data: {content: values.content},
			success: values.onSuccess,
			error: values.onError
		});
	}

	this.getAll = function(values){
		$.ajax({
			url: '/kuepa_api.php/profile/friends',
			type: 'GET',
			dataType: 'json',
			success: values.onSuccess,
			error: values.onError
		});
	}

	this.getThread = function(values){
		$.ajax({
			url: '/kuepa_api.php/message/' + values.message_id,
			type: 'GET',
			data: {from_time: values.from_time},
			dataType: 'json',
			success: values.onSuccess,
			error: values.onError
		});
	}

	this.removeRecipients = function(values){
		$.ajax({
			url: '/kuepa_api.php/message/' + values.message_id,
			type: 'DELETE',
			dataType: 'json',
			success: values.onSuccess,
			error: values.onError
		});
	}

	//message_id
	this.getRecipientsFromMessage = function(values){}

	//message_id, recipients
	this.addRecipientsToMessage = function(values){}

}

