<?php use_stylesheet("http://vjs.zencdn.net/4.1/video-js.css") ?>
<?php use_javascript("http://vjs.zencdn.net/4.1/video.js") ?>
<h4><?php echo $resource->getType() ?></h4>
<video id="example_video_1" class="video-js vjs-default-skin"
  controls preload="auto" width="640" height="264"
  poster="http://video-js.zencoder.com/oceans-clip.png"
  data-setup='{"example_option":true}'>
 <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
 <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
 <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
</video>