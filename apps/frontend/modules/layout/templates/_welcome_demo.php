<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];
		slides[1] = function(){
			var obj = $(".eg-grid .subject-item:first .subject-link");
			obj.css("position","relative");
			obj.css("z-index","9000");
			obj.delay(500).effect("shake");
		};
		slides[2] = function(){
			var obj = $(".eg-grid .subject-item:first .subject-link");
			obj.css("z-index","");
			classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","9000");
		};
		slides[3] = function(){
			classie.removeClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","");
			var obj = $("#eg-grid");
			obj.css({"position": "relative", "z-index" : "9000", 'opacity': 0});
			obj.animate({'opacity':1},250);
		};
		slides[4] = function(){
			var obj = $("#eg-grid");
			obj.animate({'opacity':0},250, function(){
						obj.css({"z-index" : "", 'opacity': 1});
					});

		}

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
</style>

<div class="hidden">
	<div id="popup">
		<div class="container">
			<div class="row">
				<div class="slide" data-slide="1">
				  	<p class="slide-title">
				  		¡Hola <?php echo $profile->getFirstName() ?>! 
				  	</p>
				  	<p class="slide-main">
				  		Bienvenido al PreICFES Kuepa. En este demo podrás ver el funcionamiento del curso para una materia de las 8 que evalúa el ICFES.
				  	</p>
				  	<a href="javascript:void(0)" class="btn btn-primary btn-large">Comenzar Demo</a>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="slide slide2 slide-small" data-slide="2">
					<div class="arrow"></div>
					<p class="slide-title">
				  		1. Para comenzar 
				  	</p>
				  	<p class="slide-main">
						Antes que nada, contesta la prueba que encontrarás en el cuadro Simulacros y cuando termines obtendrás tus resultados.
					</p>
				  	<a href="javascript:void(0)" class="btn btn-primary">¡Entendido! Sigamos...</a>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="slide slide3 slide-small" data-slide="3">
					<div class="arrow"></div>
					<p class="slide-title">
				  		2. Tu camino de aprendizaje
				  	</p>
				  	<p class="slide-main">
				  		Con tus resultados te asignaremos las lecciones que debes tomar para estar listo para la prueba, siempre podrás ver cuáles te faltan aquí.
				  	</p>
				  	<a href="javascript:void(0)" class="btn btn-primary">¡Listo! Próxima...</a>
				</div>
			</div>
		</div>
		<div class="slide slide4 slide-small" data-slide="4">
					<p class="slide-title">
				  		3. Explora por ti mismo
				  	</p>
				  	<p class="slide-main">
				  		Si quieres ver las lecciones disponibles y conocer todo el contenido de Kuepa ve a cada materia y navega libremente.
				  	</p>
				  	<a href="javascript:void(0)" class="btn btn-primary">¡Bien! Última...</a>
		</div>
		<div class="container">
			<div class="row">
				<div class="slide" data-slide="5">
					<p class="slide-title">
				  		4. ¡A estudiar!
				  	</p>
				  	<p class="slide-main">
				  		Y listo, basta de historias, ya puedes comenzar. Recuerda que siempre podrás acceder a todas las lecciones comprando la versión completa del Preicfes. 
				  	</p>
				  	<div><a href="javascript:void(0)" class="btn btn-primary btn-large">Comienza con tu simulacro</a></div>
				  	<div class="margintop"><a href="javascript:void(0)" class="btn btn-large">Navega libremente</a></div>
				</div>
			</div>
		</div>	
	</div>
</div>