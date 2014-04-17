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

<script src="js/dashboard.js"></script>

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
								<li><a href="?">Todos</a></li>
								<li class="divider"></li>
								<?php foreach ($groups as $group): ?>
								<li><a href="?group=<?php echo $group->getId() ?>"><?php echo $group->getName() ?></a></li>
								<?php endforeach ?>
							</ul>
						</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container clearpadding margintop140">
	<div class="row">
		<div class="col-xs-7">
			<div class="dashboard-left">

				<?php for($i=0;$i<$students->count();$i++):?>
				<article class="student ficha-dashboard <?php if( ($i+2)%3 == 0 ){echo "middle";} ?>" data-profile="<?php echo $students[$i]->getId() ?>">
					<div class="grafica">
						<div class="grafica1 <?php echo isset($statics[$students[$i]->getId()]) && isset($statics[$students[$i]->getId()][$course->getId()]) ? getProgressNumber($statics[$students[$i]->getId()][$course->getId()][1]) : "one" ?>"></div>
						<div class="grafica2 <?php echo isset($statics[$students[$i]->getId()]) && isset($statics[$students[$i]->getId()][$course->getId()]) ? getProgressNumber($statics[$students[$i]->getId()][$course->getId()][6]) : "one" ?>"></div>
						<div class="grafica3 <?php echo isset($statics[$students[$i]->getId()]) && isset($statics[$students[$i]->getId()][$course->getId()]) ? getProgressNumber($statics[$students[$i]->getId()][$course->getId()][0]/100) : "one" ?>"></div>
						<i class="spr ico-ficha1"></i>
						<i class="spr ico-ficha2"></i>
						<i class="spr ico-ficha3"></i>

						<img src="<?php echo $students[$i]->getAvatarImage() ?>">
					</div>

					<p class="text"><?php echo $students[$i]->getFullName() ?></p>

					<section>
						<div>
							<p>Ultima conexión</p>
							<p>
								<?php if ($students[$i]->getLastAccess()): ?>
								<?php echo stdDates::day_diff($students[$i]->getLastAccess(),strtotime("now")) ?> <small>Dias</small>
								<?php else: ?>
								-
								<?php endif ?>
							</p>
						</div>
						<div class="middle">
							<p>Lecciones Completas</p>
							<p><?php echo isset($chapterAproved[$students[$i]->getId()]) ? $chapterAproved[$students[$i]->getId()] : 0; ?>
								/
								<?php echo $course->getChapters()->count() ?></p>
						</div>
						<div>
							<p>Nota Promedio</p>
							<p><?php echo isset($notes[$students[$i]->getId()]) && isset($notes[$students[$i]->getId()][$course->getId()]) ? $notes[$students[$i]->getId()][$course->getId()][0] : "-" ?></p>
						</div>
					</section>
				</article>
				<?php endfor; ?>
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

		<?php $oneStudent = $students->getFirst(); ?>

		<div id="info-data">
			<?php include_partial("lista-student", array('student' => $oneStudent, 'status' => $status, 'course' => $course, 'chapterTimes' => $chapterTimes, 'courseTimes' => $courseTimes, 'notes' => $notes)) ?>
		</div>
	</div>
</div> <!-- /container -->
