<div class="course">
    <ul>
        <?php foreach ($course->getChildren() as $child): ?>
            <?php include_partial('course_Component', Array('component' => $child)); ?>
        <?php endforeach; ?>
    </ul>
</div>