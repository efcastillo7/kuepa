<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];
		slides[1] = function(){
			var obj = $(".eg-grid .subject-item:first .subject-link");
			obj.css("position","relative");
			obj.css("z-index","9999");
			obj.delay(500).effect("shake");
		};
		slides[2] = function(){
			var obj = $(".eg-grid .subject-item:first .subject-link");
			obj.css("z-index","");
			classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","9999");
		};
		slides[3] = function(){
			classie.removeClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","");
			$("#eg-grid").delay(500)
					.animate({'opacity':0},250).animate({'opacity':1},250)
					.animate({'opacity':0},250).animate({'opacity':1},250);

		};

		magnificPopup.open({
	      alignTop: true,
	      closeOnBgClick: false,
		  items: {
		    src: '#popup', // can be a HTML string, jQuery object, or CSS selector
		    type: 'inline',
		  }
		});

		$(".slide:first").show();

		$(".slide").click(function(){
			var actual = $(this).data('slide'),
				actual_i = parseInt(actual),
				next_i = actual_i + 1,
				next = $("[data-slide='" + next_i + "']");


			$(this).hide();
			if(next.length > 0){
				next.show();
				if(slides[actual_i] !== undefined){
					slides[actual_i]();
				}
			}else{
				magnificPopup.close();
			}

		});
	});


</script>

<style>
	.white-popup {
	  position: relative;
	  background: #FFF;
	  padding: 20px;
	  width: auto;
	  max-width: 500px;
	  margin: 20px auto;
	}

	.slide{
		/*width: 100%;*/
		/*height: 100%;*/
		display: none;
		color: white;
		font-size: 22px;
		position: relative;
		margin: 280px auto;
		width: 300px;
	}

	.close{
		position: absolute;
		right: -10px;
		top: 0px;
		/*top: -10px;*/
		color: white;
	}
</style>

<div class="hidden">
	<div id="popup">
		<div class="close">
			Cerrar	
		</div>
	  <div class="slide" data-slide="1">
	  	Hola <?php echo $profile->getFirstName() ?>, bienvenido al Preicfes Kuepa. En este demo podrás ver el funcionamiento del curso para una materia de las 8 que evalúa el ICFES.
	  	<br><br>
	  	<a href="javascript:void(0)" class="btn">Seguir </a>
	  </div>
	  <div class="slide" data-slide="2">
	  	Para empezar contesta el simulacro que encontrarás en el cuadro Simulacros y cuando termines obtendrás tus resultados.
	  	<br><br>
	  	<a href="javascript:void(0)" class="btn">Seguir </a>
	  </div>
	  <div class="slide" data-slide="3">
	  	Con tus resultados te asignaremos las lecciones que debes tomar para estar listo para la prueba, siempre podrás ver cuáles te faltan aquí.
	  	<br><br>
	  	<a href="javascript:void(0)" class="btn">Seguir </a>
	  </div>
	  <div class="slide" data-slide="4">
	  	Si quieres explorar las lecciones disponibles y conocer todo el contenido de Kuepa ve a cada materia y navega libremente
	  	<br><br>
	  	<a href="javascript:void(0)" class="btn">Seguir </a>
	  </div>
	  <div class="slide" data-slide="5">
	  	Y listo, basta de historias. Ya puedes empezar a estudiar, recuerda que siempre podrás tener la versión completa del Preicfes haciendo clic aquí 
	  	<br><br>
	  	<a href="javascript:void(0)" class="btn">Comprar </a>
	  </div>
	</div>
</div>