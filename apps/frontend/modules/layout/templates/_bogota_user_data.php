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
			$.ajax('/kuepa_api_dev.php/profile/1', { 
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
				data: { profile: { phone: phone, cellphone: celphone } },
				error: function(response){
					alert(response.responseText)
				},
				dataType: 'json'
			});
		})
	});


</script>

<div class="hidden">
	<div id="popup">
		<div class="container">
			<div class="row">
				<div class="slide" data-slide="1">
				  	<p class="slide-title">
				  		¡Hola <?php echo $profile->getFirstName() ?>! 
				  	</p>
				  	<div class="slide-main">
				  		<p>
				  		Bienvenido a la formación virtual del proyecto de Fortalecimiento de Estándares de Competencias 2014. En este tutorial podrás ver el funcionamiento de la plataforma. 
				  		</p>
				  		<p>
				  			Para continuar te pedimos que completes los siguientes campos:
				  			<form action="">
								Teléfono: <br>
				  				<input id="phone" type="text" class="input-big">
				  				<br>
				  				<div>Celular:</div>
				  				<input id="celphone" type="text" class="input-big">
				  				<br>
				  				<input id="send_data" type="button" class="btn btn-primary btn-large" value="Confirmar">
				  			</form>
				  		</p>
				  	</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="slide slide3 slide-small" data-slide="2">
					<div class="arrow"></div>
					<p class="slide-title">
				  		1. Tu camino de aprendizaje
				  	</p>
				  	<p class="slide-main">
				  		Con tus resultados te asignaremos las lecciones que debes tomar para estar listo para la prueba, siempre podrás ver cuáles te faltan aquí.
				  	</p>
				  	<a href="javascript:void(0)" class="btn btn-primary">¡Listo! Próxima...</a>
				</div>
			</div>
		</div>
		<div class="slide slide4 slide-small" data-slide="3">
					<p class="slide-title">
				  		2. Explora por ti mismo
				  	</p>
				  	<p class="slide-main">
				  		Si quieres ver las lecciones disponibles y conocer todo el contenido ve a cada materia y navega libremente.
				  	</p>
				  	<a href="" id="goto-lesson" class="btn btn-primary">¡Listo! Próxima...</a>
		</div>
	</div>
</div>