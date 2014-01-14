<?php

/**
 * ResourceDataDocument
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ResourceDataDocument extends BaseResourceDataDocument {

    const TYPE = 'Document';
    const PDF = 'pdf';
    const IMAGE = 'image';
    const PPT = 'ppt';

    public function getFile() {
        return '/uploads/documents/' . $this->getPath();
    }

    public function getFilePath() {
        $file_path = $this->getPath();
        $root_path = sFConfig::get('sf_upload_dir');
        $full_path = $root_path.'/documents/'.$file_path;
        return $full_path;
    }

}
