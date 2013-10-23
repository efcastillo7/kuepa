<?php use_stylesheet("/assets/timeline/css/default.css") ?>
<?php use_stylesheet("/assets/timeline/css/component.css") ?>
<?php use_helper("Date") ?>
<h1>Camino de Aprendizaje</h1>
<div class="row-fluid">
	<div class="main span10">
		<ul class="cbp_tmtimeline">
			<?php foreach ($logs as $log): 
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
			<!-- <li class="spacer">
				<div style="height: <?php echo $log->getLapse()?>px;"></div>
			</li> -->
			<?php endforeach ?>
		</ul>
	</div>
	<div class="span2">
		<a href="#" id="hide-skim">Ocultar/Mostrar Lecturas Rápidas</a>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#hide-skim").click(function(){
			$(".skim-resource").toggle();
		});
	});
</script>
