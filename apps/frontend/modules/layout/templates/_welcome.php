<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		var magnificPopup = $.magnificPopup.instance; 

		magnificPopup.open({
	      alignTop: true,
	      closeOnBgClick: false,
		  items: {
		    src: '#popup', // can be a HTML string, jQuery object, or CSS selector
		    type: 'inline',
		  }
		});

		$(".slide").click(function(){
			var next = $(this).data('next');

			$(this).hide();
			if(next == "close"){
				magnificPopup.close();
			}else{
				$(".slide" + next).show();
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
		color: white;
		font-size: 22px;
	}

	.slide1{
		position: relative;
		margin: 280px auto;
		width: 300px;
	}

	.slide2{
		position: absolute;
		left: -10px;
		top: -10px;
		display: none;
	}

	.slide3{
		position: absolute;
		left: 221px;
		top: 160px;
		display: none;
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
	  <div class="slide slide1" data-next="2">
	  	HOLA <?php echo $profile->getFirstName() ?>! Bienvenido a Kuepa :)
	  	<br><br>
	  	<a href="javascript:void(0)" class="btn">Seguir </a>
	  </div>
	  <div class="slide slide2" data-next="3">
	  	<img src="/images/guide/slide1.png" alt="">
	  </div>
	  <div class="slide slide3" data-next="close">
	  	<img src="/images/guide/curse.png" alt="">
	  	<br>
		Aquí tienes todos tus cursos disponibles
	  </div>
	</div>
</div>