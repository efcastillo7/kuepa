<?php if ($seted_deadline): ?>
    
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
<?php endif ?>