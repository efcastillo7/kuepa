<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];
		slides[1] = function(){
			//add lesson demo
			var data = '[{"id":"1","position":"1","course":{"id":"1791","name":"Biolog\u00eda I","color":"red","image":"\/uploads\/thumbnail\/82deb81a5c8c482876fd696bdd4fe96a4b521236.png"},"chapter":{"id":"3959","name":"Los seres vivos como sistemas abiertos: intercambios de materia y energ\u00eda"},"lesson":{"id":"3964","name":"Ciclo del agua"}},{"id":"2","position":"2","course":{"id":"2022","name":"Geograf\u00eda I","color":"violet","image":"\/uploads\/thumbnail\/6566912c4924ab110f2ac6c326b982dee9e834d1.png"},"chapter":{"id":"2055","name":"Ambientes en el mundo"},"lesson":{"id":"2064","name":"Problem\u00e1ticas ambientales"}},{"id":"3","position":"3","course":{"id":"684","name":"Historia I","color":"lightblue","image":"\/uploads\/thumbnail\/ede8a73b45b6b13a441c17903f58926575e844a0.png"},"chapter":{"id":"685","name":"El origen del Universo y del hombre"},"lesson":{"id":"686","name":"Inicios del universo y de la tierra"}}]';
			var json = JSON.parse(data);
			addItemsToPath(json);

			var obj = $(".eg-grid .subject-item:first .subject-link");
			obj.css("z-index","");
			classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","9000");
		};
		slides[2] = function(){
			classie.removeClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","");
			
			//remove demo items
			$("#cbp-spmenu-s2 .cbp-path-item").remove();

			var obj = $("#eg-grid");
			obj.css({"position": "relative", "z-index" : "9000", 'opacity': 0});
			obj.animate({'opacity':1},250);
		};
		slides[3] = function(){
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

		$("#goto-lesson").click(function(){
			location.href = "/lesson/view/11965/11966/11967";
		});
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
				  	<p class="slide-main">
				  		Bienvenido a la formación virtual del proyecto de Fortalecimiento de Estándares de Competencias 2014. En este tutorial podrás ver el funcionamiento de la plataforma. 
				  	</p>
				  	<a href="javascript:void(0)" class="btn btn-primary btn-large">Comenzar Tutorial</a>
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