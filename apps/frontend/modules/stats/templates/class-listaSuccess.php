<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<?php use_helper("Stats") ?>
<?php 
	$groups = $sf_data->getRaw('groups_ids'); 
	$params = $sf_data->getRaw('params'); 
?>

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
	.menu-list{
		position: absolute;
		left: 30px;
		top: 55px;
	}
	.count-results{
		position: relative;
		top: -33px;
		left: 10px;
	}
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

<div class="tbdata-title-hd">
	<h3 class="HelveticaLt">Reportes: <span class="HelveticaMd"><?php echo $course->getName() ?></span></h3>

	<div class="container clearpadding menu-list">
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

			        <?php if(count($group_categories)): ?>
			        <div class="order">
						<form action="">
							<div class="btn-group">
							<?php foreach($group_categories as $category): ?>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<?php echo $category ?>
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<!-- <li><a href=""><input type="text"></a></li> -->
									<?php foreach ($category->getGroups() as $group): ?>
									<li><a href="#"><input type="checkbox" name="groups[<?php echo $category->getId() ?>][]" value="<?php echo $group->getId() ?>" <?php echo isset($groups[$category->getId()]) && in_array($group->getId(), $groups[$category->getId()]) ? "checked" : "" ?>> <?php echo $group->getName() ?></a></li>
									<?php endforeach ?>
								</ul>
							</div>
							<?php endforeach; ?>
							<input type="submit" class="btn btn-primary btn-xs" value="Actualizar">
							</div>
						</form>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container clearpadding margintop140">
	<div class="row">
		<div class="col-xs-7">
			<div class="dashboard-left">
				
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
							<span><?php if ($student->getLastAccess()): ?>
								<?php echo stdDates::day_diff($student->getLastAccess(),strtotime("now")) ?> <small>Dias</small>
								<?php else: ?>
								-
								<?php endif ?>
							</span>
							<span><?php echo isset($chapterAproved[$student->getId()]) ? $chapterAproved[$student->getId()] : 0; ?>
								/
								<?php echo $course->getChapters()->count() ?></span>
							<span><?php echo isset($notes[$student->getId()]) && isset($notes[$student->getId()][$course->getId()]) ? $notes[$student->getId()][$course->getId()][0] : "-" ?></span>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div><!-- /dashboard-left -->

			<!-- Paginator -->
			<?php if ($pager->haveToPaginate()): ?>
			<ul class="pagination">
			  <li><a href="?page=1&count=<?php echo $count_per_page ?>">&laquo;</a></li>
			  <li><a href="?page=<?php echo $pager->getPreviousPage() ?>&count=<?php echo $count_per_page ?>">&laquo;</a></li>
			  <?php foreach ($pager->getLinks() as $page): ?>
			    <?php if ($page == $pager->getPage()): ?>
			      <li class="active"><a href="#"><?php echo $page ?></a></li>
			    <?php else: ?>
			      <li><a href="?page=<?php echo $page ?>&count=<?php echo $count_per_page ?>"><?php echo $page ?></a></li>
			    <?php endif; ?>
			  <?php endforeach; ?>
			  
			  <li><a href="?page=<?php echo $pager->getNextPage() ?>&count=<?php echo $count_per_page ?>">&raquo;</a></li>
			  <li><a href="?page=<?php echo $pager->getLastPage() ?>&count=<?php echo $count_per_page ?>">&raquo;</a></li>
			</ul>


			<div class="btn-group count-results">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
					<?php echo $count_per_page ?>
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<?php foreach ($count_per_page_options as $cant): ?>
					<li><a href="?count=<?php echo $cant ?>"><?php echo $cant ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>

			<div class="pagination_desc">
			  Página <span class="badge"><?php echo $pager->getPage() ?></span> de <span class="badge"><?php echo $pager->getLastPage() ?></span>
			</div>
			<?php endif; ?>
		</div>

		<?php 
		$oneStudent = $students->getFirst(); 
		?>

		<div id="info-data">
			<?php include_partial("lista-student", array('student' => $oneStudent, 'status' => $status, 'course' => $course, 'chapterTimes' => $chapterTimes, 'courseTimes' => $courseTimes, 'notes' => $notes)) ?>
		</div>
	</div>
</div> <!-- /container -->
<script src="/js/dashboard.js"></script>
