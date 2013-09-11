<?php use_javascript("/assets/video-js/plugins/vjs.youtube.js") ?>
<video id="example_video_1" class="video-js vjs-default-skin" preload="none" width="auto" height="360"
    data-setup='{"techOrder":["youtube"],"ytcontrols":false}'>
  <source src="<?php echo $resource->getContent() ?>" type='video/youtube' />
</video>