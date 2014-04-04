<?php use_javascript("/assets/video-js/plugins/vjs.youtube.js") ?>
<div class="hidden" id="resource-video-link-container">
	Link YouTube: <input id='resource-video-link' type='text' value='<?php echo $resource->getContent() ?>'>
</div>
<video id="resource-video-youtube" class="video-js vjs-default-skin" preload="none" width="auto" height="500"
    data-setup='{"techOrder":["youtube"],"ytcontrols":true}'>
  <source src="<?php echo $resource->getContent() ?>" type='video/youtube' />
</video>