<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<style>
	.slide.slide2{
		margin: 100px 0 0 200px;
		position: absolute;
		left: 130px;
		top: 10px;
	}

	.menu-container > section{
		z-index: 9999;
	}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];
		slides[1] = function(){
			// $(".menu-container > section").css("z-index","9999");
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

		slides[1]();

		setTimeout(function(){
			$(".arrow-hover-left.navigation-menu").click();
		}, 3000);

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

		$("#goto-home").click(function(){
			location.href = "/";
		});
	});


</script>

<div class="hidden">
	<div id="popup">
		<div class="container">
			<div class="row">
				<div class="slide slide2 slide-small" data-slide="1">
					<div class="arrow"></div>
					<p class="slide-title">
				  		3. Viaja de lección en lección
				  	</p>
				  	<p class="slide-main">
				  		Dentro de las lecciones podrás ver los pasos que has tomado y que te faltan a tu izquierda.
				  	</p>
				  	<a href="javascript:void(0)" class="btn btn-primary" id="goto-home">¡Listo! Próxima...</a>
				</div>
			</div>
		</div>
	</div>
</div>