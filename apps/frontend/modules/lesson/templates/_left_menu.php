<div class="span3 path-steps">
    <ul class="unstyled gray3">
        <li class="gray2">- <?php echo $parent->getName() ?></li>
        <?php foreach ($parent->getChildren() as $key => $child): ?>
            <li class="<?php echo $key == 0 ? "active" : "" ?>"><a href="<?php url_for("lesson/index") ?>"><?php echo $child->getName() ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>