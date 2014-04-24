<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];
		slides[1] = function(){
			// ads
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

		$("#goto-home").click(function(){
			location.href = "/";
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
				  		Ahora estás mirando la pantalla de lecciones :)
				  	</p>
				  	<a href="javascript:void(0)" id="goto-home" class="btn btn-primary btn-large">¡Bien! Última...</a>
				</div>
			</div>
		</div>
	</div>
</div>