<h4><?php echo $course->getName() ?></h4>

<script src="http://code.highcharts.com/highcharts.js"></script>
<div id="container" style="width:100%; height:400px;"></div>

<script>
	$(function () { 
    $('#container').highcharts({
    	plotOptions: {
		    line: {
		        dataLabels: {
		            enabled: true
		        }
		    }
		},
        chart: {
            type: 'line'
        },
        title: {
            text: ''
        },
        xAxis: {
            title: {
            	text: 'Fecha'
            },
			gridLineWidth: 0,
			categories: ['<?php echo implode("','",$days['estimated']->getRaw('y')) ?>']
        },
        yAxis: {
            title: {
                text: 'Horas de Estudio Restantes'
            },
            min: 0,
            gridLineWidth: 1
        },
        series: [{
        	name: "Horas Restantes Estimadas",
            data: [
            	<?php echo implode(",",$days['estimated']->getRaw('x')) ?>
            ],
            dashStyle: 'longdash'
        },{
            name: "Horas Proyección",
            data: [
                <?php echo implode(",",$days['proyect']->getRaw('x')) ?>
            ],
            dashStyle: 'longdash'
        	
        },{
            name: "Horas Dedicadas",
            data: [
                <?php echo implode(",",$days['real']->getRaw('x')) ?>
            ]
        },
        ]
    });
});
</script>

<h2>Unidades</h2>

<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Porcentaje de Avance</th>
			<th>Tiempo Dedicado</th>
			<th>Duración de la lección</th>
			<th>Último Recurso Visto</th>
		</tr>
	</thead>
	<?php foreach ($chapters as $chapter): ?>
		<tr>
			<td><a href="<?php echo url_for("stats/chapter?course=" . $course->getId() . "&chapter=" . $chapter->getId()) ?>"><?php echo $chapter->getName() ?></a></td>
			<td><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $chapter->getId()) ?> %</td>
			<td><?php echo gmdate("H:i:s", $chapter->getTotalTime($sf_user->getProfile()->getId())) ?></td>
			<td><?php echo gmdate("H:i:s", $chapter->getDuration()) ?></td>
			<td><?php echo $chapter->getLastResourceViewed($sf_user->getProfile()->getId())?></td>
		</tr>
	<?php endforeach ?>
</table>