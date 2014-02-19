<ul>
	
		<li>
			<?php echo $course ?>
			<ul>
				<?php $chapters = $course->getChapter(); ?>
				<?php foreach ($chapters as $chapter): ?>
					<li><?php echo $chapter->getName() ?>
						<ul>
							<?php $lessons = $chapter->getLesson(); ?>
							<?php foreach ($lessons as $lesson): ?>
								<li><?php echo $lesson->getName() ?></li>
								<ul>
								<?php foreach ($lesson->getResource() as $resource): ?>
									<li><?php echo $resource->getName() ?></li>
								<?php endforeach ?>
								</ul>
							<?php endforeach ?>
						</ul>
					</li>
				<?php endforeach ?>
			</ul>
		</li>
	
</ul>