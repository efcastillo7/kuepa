<?php use_stylesheet("/assets/video-js/video-js.css") ?>
<?php use_javascript("/assets/video-js/video.js") ?>
<?php include_partial("views/resources/video_" . $resource->getVideoType(), array('resource' => $resource)) ?>

