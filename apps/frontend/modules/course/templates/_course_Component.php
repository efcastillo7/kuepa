<?php echo include_partial('course_' . $component, Array('component' => $component)); ?>

<?php if ($component->getChildren()->count()): ?>
    <ul>
        <?php foreach ($component->getChildren() as $child): ?>
            <?php echo include_partial('course_Component', Array('component' => $child)); ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
