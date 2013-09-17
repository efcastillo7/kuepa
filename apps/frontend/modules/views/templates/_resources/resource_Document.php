<?php if($resource->getDocumentType() == ResourceDataDocument::PDF): ?>
    <embed type='application/pdf' src="<?php echo $resource->getFile() ?>">
<?php elseif($resource->getDocumentType() == ResourceDataDocument::IMAGE): ?>
    <img src="<?php echo $resource->getFile() ?>">
<?php endif; ?>