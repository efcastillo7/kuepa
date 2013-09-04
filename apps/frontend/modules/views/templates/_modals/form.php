<div class="md-modal" id="modal-form">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="data">
            	<form action="">
	            	<?php 
	            		$form = new CourseForm();
	            		echo $form;
	            	 ?>
	            	 <button type="submit" class="btn">Submit</button>
            	 </form>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->