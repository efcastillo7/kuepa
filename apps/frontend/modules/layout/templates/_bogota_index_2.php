<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		var slides = [];

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

		$("#goto-sim").click(function(){
			// location.href = "/lesson/view/1/328/329";
			var obj = $(".eg-grid .subject-item:first .subject-link");
			obj.css("z-index","");
			classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
			$("#cbp-spmenu-s2").css("z-index","9000");
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
				  		Y listo, basta de historias, ya puedes comenzar. 
				  	</p>
				  	<div><a href="" id="goto-sim" class="btn btn-primary btn-large">Comienza tu camino de aprendizaje</a></div>
				  	<div class="margintop"><a href="javascript:void(0)" class="btn btn-large">Navega libremente</a></div>
				</div>
			</div>
		</div>	
	</div>
</div>