<?php 
	$courseTime = isset($courseTimes[$student->getId()]) ? $courseTimes[$student->getId()][$course->getId()] : 0;
	$hs = gmdate("H", $courseTime);
	$statics = ProfileComponentCompletedStatusService::getInstance()->getStaticsForUser($student->getId(), $course->getId());
?>
<div class="col-xs-5">
	<div class="dashboard-right">
		<nav>
			<a class="active">Alumno</a>
			<a>Curso</a>
		</nav>

		<div class="header-summary">
			<?php echo $student->getFullName() ?>
			<span class="spr close-box"></span>
		</div>

		<div class="box-summary">
			<section class="circles-big">
				<div class="left">
					<hgroup>
						<h3><?php echo $hs ?><small>hs</small></h3>
						<h4>Dedicadas</h4>
					</hgroup>
					<input class="knob" value="<?php echo $hs ?>" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
				</div>

				<div class="right">
					<?php if ($statics && $statics->getSkillIndex()): ?>
					<hgroup>
						<h3><?php echo $statics->getSkillIndex()*100 ?><small>%</small></h3>
						<h4>Indice de aprendizaje</h4>
					</hgroup>
					<input class="knob" value="<?php echo $statics->getSkillIndex()*100 ?>" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
					<?php else: ?>
					<hgroup>
						<h3>-<small>%</small></h3>
						<h4>Indice de aprendizaje</h4>
					</hgroup>
					<input class="knob" value="0" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
					<?php endif ?>
				</div>
			</section>

			<section class="circles-small">
				<div class="left">
					<?php if ($statics && $statics->getEfficiencyIndex()): ?>
					<span class="inside"><?php echo $statics->getEfficiencyIndex()*100 ?>%</span>
					<input class="knob" value="<?php echo $statics->getEfficiencyIndex()*100 ?>" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
					<?php else: ?>
					<span class="inside">-</span>
					<input class="knob" value="0" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
					<?php endif ?>
					<span class="outside">Eficiencia</span>
				</div>

				<div class="right">
					<?php if ($statics && $statics->getEffortIndex()): ?>
					<span class="inside"><?php echo $statics->getEffortIndex()*100 ?>%</span>
					<input class="knob" value="<?php echo $statics->getEffortIndex()*100 ?>" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
					<?php else: ?>
					<span class="inside">-</span>
					<input class="knob" value="0" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
					<?php endif ?>
					<span class="outside">Esfuerzo</span>
				</div>
			</section>

			<section class="percents">
				<ul>
					<li>Velocidad <span><?php echo $statics && $statics->getVelocityIndex() ? $statics->getVelocityIndex() * 100 : 0 ?>%</span></li>
					<li>Completitud <span><?php echo $statics && $statics->getCompletitudIndex() ? $statics->getCompletitudIndex() * 100 : 0 ?>%</span></li>
					<li>Destreza <span><?php echo $statics && $statics->getSkillIndex() ? $statics->getSkillIndex() * 100 : 0 ?>%</span></li>
					<li>Persistencia <span><?php echo $statics && $statics->getPersistenceIndex() ? $statics->getPersistenceIndex() * 100 : 0 ?>%</span></li>
				</ul>
			</section>

		</div><!-- /box-summary -->


		<div class="box-list">

			<header>
				<ul>
					<li>
						<div class="text">Listado de unidades</div>
						<div class="percent">Progreso</div>
						<div class="time">Tiempo dedicado</div>
						<div class="date">Fecha de aprobación</div>
						<div class="note">Nota</div>
						<div class="note">Nota pro.</div>
					</li>
				</ul>
			</header>

			<ul class="list-units">
				<?php foreach ($course->getChapters() as $chapter): ?>
				<?php 
					$chapterTime = isset($chapterTimes[$student->getId()]) && isset($chapterTimes[$student->getId()][$course->getId()]) && isset($chapterTimes[$student->getId()][$course->getId()][$chapter->getId()]) ? $chapterTimes[$student->getId()][$course->getId()][$chapter->getId()] : 0;
					$cstatus = isset($status[$student->getId()]) && isset($status[$student->getId()][$chapter->getId()]) ? $status[$student->getId()][$chapter->getId()] : 0;
				?>
				<li class="level1" data-toggle="collapse" data-target="#sublesson<?php echo $chapter->getId() ?>">
					<div class="lp-bar-post"></div>
					<div class="lp-node">
						<div class="full-circle"></div>
						<div class="lp-bar-prev viewed"></div>

						<input class="knob knob-small" value="<?php echo $cstatus ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
					</div>

					<div class="text"><?php echo $chapter->getName() ?></div>
					<div class="percent"><?php echo $cstatus ?>%</div>
					<div class="time"><?php echo gmdate("H:i",$chapterTime) ?>hs</div>
					<div class="date">-</div>
					<div class="note"><?php echo isset($notes[$student->getId()]) && isset($notes[$student->getId()][$chapter->getId()]) ? $notes[$student->getId()][$chapter->getId()] : "-" ?></div>
					<div class="note">-</div>
				</li>
				<!-- lessons -->
				<div id="sublesson<?php echo $chapter->getId() ?>" class="collapse sublesson">
					<?php foreach ($chapter->getLessons() as $lesson): ?>
					<?php $lstatus = isset($status[$student->getId()]) && isset($status[$student->getId()][$lesson->getId()]) ? $status[$student->getId()][$lesson->getId()] : 0; ?>
					<li>
						<div class="lp-bar-post"></div>
						<div class="lp-node">
							<div class="full-circle"></div>
							<div class="lp-bar-prev"></div>
							<input class="knob knob-small" value="<?php echo $lstatus?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
						</div>

						<div class="text"><?php echo $lesson->getName() ?></div>
						<div class="percent"><?php echo $lstatus?> %</div>
						<div class="time"><?php echo gmdate("H:i",LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId(), 'chapter' => $chapter->getId(), 'lesson_id' => $lesson->getId()))) ?>hs</div>
						<div class="date">-</div>
						<div class="note"><?php echo isset($notes[$student->getId()]) && isset($notes[$student->getId()][$lesson->getId()]) ? $notes[$student->getId()][$lesson->getId()] : "-" ?></div>
						<div class="note">-</div>
					</li>
					<?php endforeach ?>
				</div>
			<?php endforeach ?>

			<?php /// SUBLECCION ?>

		</ul>

	</div>


</div><!-- /dashboard-right -->
</div>