<?php use_javascript("/assets/video-js/plugins/vjs.vimeo.js") ?>
<video id="vid1" src="" class="video-js vjs-default-skin" controls preload="auto" width="auto" height="360" data-setup='{ "techOrder": ["vimeo"], "src": "<?php echo $resource->getContent() ?>", "loop": true, "autoplay": false }'>
  <p>Video Playback Not Supported</p>
</video>