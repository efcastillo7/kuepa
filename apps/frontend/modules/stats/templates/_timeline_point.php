<?php use_helper("Date") ?>
<?php 
$resource = $log->getComponent();
$lesson = $resource->getParents()->getFirst();
$chapter = $lesson->getParents()->getFirst();
$course = $chapter->getParents()->getFirst();
?>
<li class="<?php echo $log->isSkim() ? "skim-resource" : "" ?>">
	<time class="cbp_tmtime" datetime="<?php echo $log->getCreatedAt() ?>"><span><?php echo format_date($log->getCreatedAt(), "d") ?></span> <span><?php echo format_date($log->getCreatedAt(), "t") ?></span></time>
	<div class="cbp_tmicon cbp_tmicon-phone"></div>
	<div class="cbp_tmlabel bg-<?php echo $course->getColor()?>">
		<div class="row-fluid">
			<div class="span1"><img src="<?php echo $course->getThumbnailPath() ?>"/></div>
			<div class="span9">
				<span><?php echo $course->getName() ?> &gt; <?php echo $chapter->getName() ?> &gt; <?php echo $lesson->getName() ?> </span>
				<h2><?php echo $resource->getName() ?></h2>
			</div>
			<div class="span2">
				Dedicado: <br>
				<?php echo gmdate("H:i:s", $log->getLapse())?>
			</div>
		</div>				
	</div>
</li>