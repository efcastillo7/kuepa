<li class="a-son-li" current_id="<?php echo $resource->getId()?>">
    <div class="lp-node">
        <div class="lp-bar-prev"></div>
        <div class="lp-bar-post"></div>
        <span class="lp-node-play"></span>
        <input class="knob knob-small" value="<?php echo $resource->getCacheCompletedStatus(); ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
    </div>
    <a href="#">
    	<?php echo $resource->getName() ?> <span class="gray4 italic">Contenido bloqueado por el docente.</span>
	</a>
    <span class="lp-time"><?php echo $resource->getDuration() ?></span>
</li>