<div class="span3 path-steps">
    <ul class="unstyled gray3">
        <li class="gray2">- <?php echo $parent->getName() ?></li>
        <?php foreach ($parent->getChildren() as $child): ?>
            <li class="active"><?php echo $child->getName() ?></li>
        <?php endforeach; ?>
    </ul>
</div>