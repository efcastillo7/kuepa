//recipients, subject, content, on_success, on_error
function sendMessage(values){
	$.ajax({
		url: '/kuepa_api.php/message',
		type: 'POST',
		dataType: 'json',
		data: {recipients: values.recipients, subject: values.subject, content: values.content},
		success: values.on_success,
		error: values.on_error
	});
}

//message_id, content
function replyMessage(values){
	$.ajax({
		url: '/kuepa_api.php/message/' + values.message_id,
		type: 'POST',
		dataType: 'json',
		data: {content: values.content},
		success: values.on_success,
		error: values.on_error
	});
}

function getMessages(values){
	$.ajax({
		url: '/kuepa_api.php/message',
		type: 'GET',
		dataType: 'json',
		success: values.on_success,
		error: values.on_error
	});
}

//message_id
function getThread(values){
	$.ajax({
		url: '/kuepa_api.php/message/' + values.message_id,
		type: 'GET',
		dataType: 'json',
		success: values.on_success,
		error: values.on_error
	});
}

//message_id
function getRecipientsFromMessage(values){}

//message_id, recipients
function addRecipientsToMessage(values){}

//message_id, recipients
function removeRecipientFromMessage(values){
	$.ajax({
		url: '/kuepa_api.php/message/' + values.message_id,
		type: 'DELETE',
		dataType: 'json',
		success: values.on_success,
		error: values.on_error
	});
}

