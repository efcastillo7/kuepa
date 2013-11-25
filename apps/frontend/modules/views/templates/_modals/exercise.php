<?php use_javascript("/assets/highcharts/js/highcharts.js") ?>
<?php use_javascript("/assets/highcharts/js/modules/exporting.js") ?>

<div class="md-modal" id="modal-exercise">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
        	<div class="row">
            	<div class="span2 text-center">
            		<h4>Su resultado</h4>
            		<input type="text" value="0" class="dial">
            	</div>
            	<div class="span3">
            		<h4>Estadísticas</h4>
            		<div id="graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            		
            	</div>
        	</div>
            <div id="text" class="row">
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->