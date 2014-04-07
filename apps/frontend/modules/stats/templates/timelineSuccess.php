<?php use_stylesheet("/assets/timeline/css/default.css") ?>
<?php use_stylesheet("/assets/timeline/css/component.css") ?>
<?php use_stylesheet("/styles/css/bootstrap-pres.css") ?>
<h1>Camino de Aprendizaje</h1>
<div class="row-fluid">
	<div class="main span10">
		<ul class="cbp_tmtimeline">
			<?php include_partial("timeline_points", array('logs' => $logs)) ?>
		</ul>
		<a id="more" href="javascript:void(0)">Ver más</a>
	</div>
	<div class="span2">
		<a href="#" id="hide-skim">Ocultar/Mostrar Lecturas Rápidas</a>
	</div>
</div>

<script>
	var last_date = null;
	var reached_last = false;
	var loading = false;

	$(document).ready(function(){
		$("#hide-skim").click(function(){
			$(".skim-resource").toggle();
		});

		function loadHistory(){
			if(reached_last || loading){
				return;
			}

			loading = true;

			$.ajax({
				url: '<?php echo url_for("stats/timeline") ?>',
				data: {count: 10, to: last_date},
				dataType: 'json',
				success: function(data, textStatus, jqXHR){
					console.log(data);
					loading = false;

					if(data.template != ""){
						$(".cbp_tmtimeline").append(data.template);	
					}else{
						reached_last = true;
						$("#more").hide();
					}
					
					last_date = data.last_date;
				},
				error: function(data, textStatus, jqXHR){
					$("#more").hide();
				}
			});
		}

		// loadHistory();

		$(window).scroll(function () {
		   if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
		      loadHistory();
		   }
		});

		$("#more").click(loadHistory);

	});
</script>
