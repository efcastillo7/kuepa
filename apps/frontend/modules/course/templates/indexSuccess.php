<?php  use_javascript('http://code.jquery.com/jquery-1.10.2.min.js') ?>
<?php  use_javascript('course.js'); ?>

<ul>
<?php foreach($courses as $course): ?>
    <li class="coso" data-content-url="<?php echo url_for('course/expanded?course_id=' . $course->getId()) ?>"><?php echo $course->getName() ?><br/><img src="<?php echo $course->getThumbnailPath() ?>"/></li>
<?php endforeach; ?>
</ul>