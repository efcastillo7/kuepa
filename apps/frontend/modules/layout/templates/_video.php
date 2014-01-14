<?php use_javascript("/assets/magnific-popup/jquery.magnific-popup.min.js") ?>
<?php use_stylesheet("/assets/magnific-popup/magnific-popup.css") ?>

<script type="text/javascript">
	$(document).ready(function(){
		$.magnificPopup.open({
		  items: {
		    src: 'http://www.youtube.com/watch?v=7wTYDXXnj7A',
		    type: 'iframe'
		  }
		});
	});
</script>