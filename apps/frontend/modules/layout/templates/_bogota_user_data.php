<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];

		magnificPopup.open({
	      alignTop: true,
	      closeOnBgClick: false,
	      showCloseBtn: false,
	      enableEscapeKey: false,
		  items: {
		    src: '#popup', // can be a HTML string, jQuery object, or CSS selector
		    type: 'inline',
		  }
		});

		$(".slide:first").show();

		$("#send_data").click(function(){
			var phone = $("#phone").val();
			var celphone = $("#celphone").val();
			$.ajax('/kuepa_api_dev.php/profile/0', { 
				type: 'POST', 
				success: function(response){ 
					$.ajax('/kuepa_api_dev.php/profile/flashmessage',{
						data: { id: <?php echo $message->getId() ?> },
						success: function(){
							magnificPopup.close();
						},
						type: 'POST'
					});
				}, 
				data: { profile: { phone: phone, celphone: celphone } },
				error: function(response){
					alert(response.responseText)
				},
				dataType: 'json'
			});
		});

		$("#cancel").click(function(){
			$.ajax('/kuepa_api_dev.php/profile/flashmessage',{
				data: { id: <?php echo $message->getId() ?> },
				success: function(){
					magnificPopup.close();
				},
				type: 'POST'
			});
		});
	});


</script>

<div class="hidden">
	<div id="popup">
		<div class="container">
			<div class="row">
				<div class="slide" data-slide="1">
					<p class="slide-title">
				  		4. ¡A estudiar!
				  	</p>
				  	<p class="slide-main">
				  		Y listo, basta de historias, ya puedes comenzar. <br><br>
				  		Para que te mantengamos al tanto de los concursos y premios por usar y estudiar en la plataforma, déjanos los siguientes datos:
				  	</p>
				  	<div class="slide-main">
				  		<p>
				  			<form action="">
								Email: <br>
				  				<input id="phone" type="text" class="input-big">
				  				<br>
				  				<div>Celular:</div>
				  				<input id="celphone" type="text" class="input-big">
				  				<br>
				  				<input id="send_data" type="button" class="btn btn-warning btn-large" value="¡Vale, quiero participar!">
				  				<input id="cancel" type="button" class="btn btn-primary btn-large" value="No, gracias">
				  			</form>
				  		</p>
				  	</div>
				</div>
			</div>
		</div>
	</div>
</div>