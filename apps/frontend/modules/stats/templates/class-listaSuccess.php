<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<?php use_helper("Stats") ?>


<style>
/*table{table-layout: fixed;}*/
/*table td{overflow: hidden;}*/
.unit {background-color: gainsboro;}
.bar { text-align: center}
.progress { margin-bottom: 0px; }
table td{ min-width: 100px;}
.bl { border-left: 1px solid #ddd;}
.br { border-right: 1px solid #ddd;}
.bt { border-top: 1px solid #ddd !important;}
.student{ cursor: hand; cursor:pointer;}
</style>

<script>
$(window).scroll(function(){
	$('#table-left').css({
	        'left': $(this).scrollLeft() //Use it later
	    });
	$('#table-hd').css({
	        'top': $(this).scrollTop() - 100 //Use it later
	    });
});
$(document).ready(function(){
	$(".student").click(function(){
	    var id = $(this).data("profile");
	    var obj = $("#info-data");

	    obj.hide();

	    $.ajax("/stats/getstudentstats",{
	    	dataType: 'html',
	    	data: {course_id: '<?php echo $course->getId() ?>', profile: id},
	    	success: function(data){
	    		// var obj = $("#info-data");

	    		obj.html(data);
	    		$(".knob", obj).knob({});
	    		obj.show();

	    	}
	    });
	});
});
</script>


<!-- //////////// DASHBOARD A   //////////// -->

<div class="container clearpadding">
	<div class="row">
		<div class="col-xs-7">
			<div class="dashboard-left">
				<nav class="nav-dashboard">
					<ul>
						<li><a href="<?php echo url_for("stats/class?type=lista&course_id=" . $course->getId()) ?>">Lista</a></li>
						<li><a href="<?php echo url_for("stats/class?type=ficha&course_id=" . $course->getId()) ?>">Fichas</a></li>
						<li><a href="<?php echo url_for("stats/class?type=comparativa&course_id=" . $course->getId()) ?>">Comparativa</a></li>
					</ul>
				</nav>
				<div class="order">
					<?php if ($groups->count() > 0): ?>
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<?php if ($group): ?>
							<?php echo $group->getName() ?>
						<?php else: ?>
						Todos 
						<?php endif; ?> 
						<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId()) ?>">Todos</a></li>
							<li class="divider"></li>
							<?php foreach ($groups as $group): ?>
							<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId() ."&group=" . $group->getId()) ?>"><?php echo $group->getName() ?></a></li>
							<?php endforeach ?>
						</ul>
					</div>
					<?php endif ?>
				</div>
<div class="clearfix"></div>
<div class="table-dashboard">
	<header>
		<ul>
			<li>
				<div>Progreso</div>
				<div>Ultima conexión</div>
				<div>Lecciones completadas</div>
				<div>Nota promedio</div>
			</li>
		</ul>
	</header>
	<ul class="body">
		<?php foreach ($students as $student): ?>
		<?php $sstatus = isset($status[$student->getId()]) ? $status[$student->getId()][$course->getId()] : 0; ?>
		<li rel="tooltip" class="student" data-placement="top" title="<?php echo $sstatus?>% completado" data-profile="<?php echo $student->getId() ?>">
			<div class="indicator" style="width: <?php echo $sstatus?>%;"></div>
			<span class="name"><span class="triangle <?php echo getStatusColor($sstatus)?>"></span><?php echo $student->getFullName() ?></span>
			<span><?php echo $sstatus?>%</span>
			<span><?php echo stdDates::day_diff($student->getLastAccess(),strtotime("now")) ?> <small>Dias</small></span>
			<span><?php echo isset($chapterAproved[$student->getId()]) ? $chapterAproved[$student->getId()] : 0; ?>
				/
				<?php echo $course->getChapters()->count() ?></span>
				<span>3.1</span>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
</div><!-- /dashboard-left -->
</div>

<?php 
$oneStudent = $students->getFirst(); 
?>

	<div id="info-data">
	<?php include_partial("lista-student", array('student' => $oneStudent, 'status' => $status, 'course' => $course, 'chapterTimes' => $chapterTimes, 'courseTimes' => $courseTimes)) ?>
	</div>
</div>

</div> <!-- /container -->
<script src="/js/dashboard.js"></script>
