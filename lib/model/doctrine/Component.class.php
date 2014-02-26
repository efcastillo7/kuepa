<?php

/**
 * Component
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Component extends BaseComponent {

    /**
     * 
     * @return ComponentTable
     */
    public static function getRepository() {
        return Doctrine_Core::getTable('Component');
    }
    
    public function preSave($event)   {
        $this->clearCache($event);
    }
    
    public function preDelete($event) {
        $this->clearCache($event);
    }
    
    public function clearCache($event)
    {
        CacheHelper::getInstance()->delete('Component_getById_' . $this->getId() );
    }

    public function getThumbnailPath() {
        return sfConfig::get('app_image_path_component') . $this->getThumbnail();
    }

    public function getChildren($onlyEnabled = true) {
        $query = Component::getRepository()->createQuery('c')
                ->innerJoin('c.LearningPath lp ON c.id = lp.child_id')
                ->where('lp.parent_id = ?', $this->getId())
                ->orderBy("lp.position asc");

        if($onlyEnabled){
            $query->andWhere("lp.enabled = true");
        }

        return $query->execute();
    }

    public function __toString() {
        return get_called_class();
    }

    public function getNameSlug() {
        return self::slugify($this->name);
    }

    public static function slugify($text) {
        // replace all non letters or digits by -
        $text = preg_replace('/\W+/', '-', $text);

        // trim and lowercase
        $text = strtolower(trim($text, '-'));

        return $text;
    }

    public function getNextChild($previous_child_id) {
        
        return Component::getRepository()->createQuery("c")
                                         ->select('c.*')
                                         ->innerJoin("c.LearningPath lp on c.id = lp.child_id")
                                         ->innerJoin("c.LearningPath lpc on ? = lpc.child_id", $previous_child_id)
                                         ->where("lp.parent_id = ?", $this->getId())
                                         ->andWhere("lp.position > lpc.position")
                                         ->orderBy("lp.position ASC")
                                         ->limit(1)
                                         ->fetchOne();        
    }

    public function getPreviousChild($following_child_id) {
        
        return Component::getRepository()->createQuery("c")
                                         ->select('c.*')
                                         ->innerJoin("c.LearningPath lp on c.id = lp.child_id")
                                         ->innerJoin("c.LearningPath lpc on ? = lpc.child_id", $following_child_id)
                                         ->where("lp.parent_id = ?", $this->getId())
                                         ->andWhere("lp.position < lpc.position")
                                         ->orderBy("lp.position DESC")
                                         ->limit(1)
                                         ->fetchOne();
    }

    public function isEnabled(){
        //TODO: Check because is returning first row
        $lp = $this->getLearningPath()->getFirst();
        if($lp){
            return $lp->getEnabled();
        }

        return true;
    }

}
