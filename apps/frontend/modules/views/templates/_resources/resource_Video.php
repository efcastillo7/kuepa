<?php use_stylesheet("/assets/video-js/video-js.css") ?>
<?php use_javascript("/assets/video-js/video.js") ?>
<h4><?php echo $resource->getType() ?></h4>
<?php include_partial("views/resources/video_" . $resource->getVideoType(), array('resource' => $resource)) ?>

