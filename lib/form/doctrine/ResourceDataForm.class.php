<?php

/**
 * ResourceData form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceDataForm extends BaseResourceDataForm
{
  public function configure()
  {
  	unset($this['deleted_at'], 
		  $this['updated_at'], 
		  $this['created_at'],
		  $this['parents_list'],
		  $this['children_list'],
		  $this['profiles_list'],
		  $this['parent_id']
		  );

  	$this->setWidget("profile_id", new sfWidgetFormInputHidden());
  	$this->setWidget("position", new sfWidgetFormInputHidden());
  	$this->setWidget("type", new sfWidgetFormInputHidden());
  	$this->setWidget("path", new sfWidgetFormInputHidden());
  	$this->setWidget("tags", new sfWidgetFormInputText());
  	$this->setWidget("resource_id", new sfWidgetFormInputHidden());

    $this->setValidator("content", new sfValidatorPass(array('required' => false)));
        
  	$this->widgetSchema['duration']->setAttribute("class","spinner");
  }
}
