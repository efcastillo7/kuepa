<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		$.magnificPopup.open({
		  items: {
		    src: '#popup', // can be a HTML string, jQuery object, or CSS selector
		    type: 'inline'
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

<div id="popup" class="white-popup">
  Hola <?php echo $profile->getFirstName() ?>! Bienvenido a Kuepa :)
</div>