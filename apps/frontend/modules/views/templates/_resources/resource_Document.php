<h4><?php echo $resource->getType() ?></h4>

<?php if($resource->getDocumentType() == ResourceDataDocument::PDF): ?>
    <embed type='application/pdf' src="<?php echo $resource->getFile() ?>" style="width:100%; height:500px;">
<?php elseif($resource->getDocumentType() == ResourceDataDocument::IMAGE): ?>
    <img src="<?php echo $resource->getFile() ?>" style="width:100%; height:500px;">
<?php endif; ?>