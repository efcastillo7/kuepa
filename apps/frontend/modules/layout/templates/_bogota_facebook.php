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
	});
</script>
<style>
	.slide{
		width: 700px;
		margin: 80px auto;
	}

	.slide img{
		position: relative;
		z-index: 2;
	}

	.content{
		position: absolute;
	}

	.fb-like{
		position: absolute;
		z-index: 3;
		top: 290px;
		left: 315px;
	}
</style>

<div class="hidden">
	<div id="popup">
		<div class="container">
			<div class="row">
				<div class="slide" data-slide="1">
					<div class="content">
						<img src="/bogota/bogota_facebook.jpg" alt="">
						<div class="fb-like" data-href="https://www.facebook.com/Fortalecimientoestandaresdecompetencias" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>