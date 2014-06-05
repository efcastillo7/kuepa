<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];

		magnificPopup.open({
	      alignTop: true,
	      closeOnBgClick: false,
	      showCloseBtn: true,
	      enableEscapeKey: false,
		  items: {
		    src: '#popup', // can be a HTML string, jQuery object, or CSS selector
		    type: 'inline',
		  }
		});


		$("#btn-finish").click(function(){
			//magnificPopup.close();
			location.href = "/";

	  });

		$(".slide:first").show();

		$("#goto-diag").click(function(){
			location.href = "/course/details/id/18312";
		});

	});


</script>

<div class="hidden">
	<div id="popup">
		<div class="container">
			<div class="row">
				<div class="slide" data-slide="1">
					<p class="slide-title">
				  		¡A estudiar!
				  	</p>
				  	<p class="slide-main">
				  		Y listo, basta de historias, ya puedes comenzar.
				  	</p>
				  	<!--<div><a href="" id="goto-diag" class="btn btn-primary btn-large btn-orange">Comienza con un diagnóstico</a></div>-->
				  	<div class="margintop">
				  		<a href="javascript:void(0)"  id="btn-finish" class="btn btn-large btn-primary">Navega libremente</a>
				  	</div>
				</div>
			</div>
		</div>
	</div>
</div>