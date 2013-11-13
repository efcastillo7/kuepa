<?php use_stylesheet("/assets/timeline/css/default.css") ?>
<?php use_stylesheet("/assets/timeline/css/component.css") ?>
<h1>Camino de Aprendizaje</h1>
<div class="row-fluid">
	<div class="main span10">
		<ul class="cbp_tmtimeline">
			<?php include_partial("timeline_points", array('logs' => $logs)) ?>
		</ul>
		<div id="more">Ver más</div>
	</div>
	<div class="span2">
		<a href="#" id="hide-skim">Ocultar/Mostrar Lecturas Rápidas</a>
	</div>
</div>

<script>
	var last_date = null;
	$(document).ready(function(){
		$("#hide-skim").click(function(){
			$(".skim-resource").toggle();
		});

		$.ajax({
			url: '<?php echo url_for("stats/timeline") ?>',
			data: {count: 10, to: last_date},
			dataType: 'json',
			success: function(data, textStatus, jqXHR){
				$(".cbp_tmtimeline").append(data.template);
				last_date = data.last_date;
			}
		});

		$("#more").click(function(){
			$.ajax({
				url: '<?php echo url_for("stats/timeline") ?>',
				data: {count: 10, to: last_date},
				dataType: 'json',
				success: function(data, textStatus, jqXHR){
					$(".cbp_tmtimeline").append(data.template);
					last_date = data.last_date;
				}
			});
		});

	});
</script>
