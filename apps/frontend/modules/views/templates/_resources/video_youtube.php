<?php use_javascript("/assets/video-js/plugins/vjs.youtube.js") ?>
<video id="resource-video-youtube" class="video-js vjs-default-skin" preload="none" width="auto" height="500"
    data-setup='{"techOrder":["youtube"],"ytcontrols":true}'>
  <source src="<?php echo $resource->getContent() ?>" type='video/youtube' />
</video>