$(document).ready(function(){
	$("#input_add_note").live('keyup', function(e){
		container = $(this);
		if (e.keyCode == 13) {
			e.preventDefault();

			var resource_id = $(this).attr('resource-id');
			var content = $(this).val();
			
			$.ajax('note/add', {
				data: { resource_id: resource_id, content: content },
				dataType: 'json',
				type: 'POST',
				success: function(data){
					if(data.code === 201){
						$("#notes_list").prepend(data.template);	
						container.val('');
						triggerModalSuccess({id: "modal-success", title: "Ha enviado su nota", text: "Test", effect: "md-effect-10"});
					}else{
						alert('error al enviar el comentario');
					}
					
				}
			})
		}
	});
});