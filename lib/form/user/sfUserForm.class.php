<?php

/**
 * sfGuardUser form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     kibind
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfUserForm extends sfGuardUserForm
{
  public function configure()
  {
  	unset($this['algorithm'], $this['created_at'], 
  		  $this['updated_at'], $this['salt'], 
  		  $this['permissions_list'],
  		  $this['last_login'], $this['is_super_admin']
  	);

    $decorator = new sfWidgetFormSchemaFormatterLocal($this->getWidgetSchema(), $this->getValidatorSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');

  	$this->setWidget("password", new sfWidgetFormInputPassword());

  	$this->widgetSchema['groups_list']->addOption('expanded', true);

    // if($this->isNew()){
    //   $nprof = new Profile();
    //   $nprof->setSfGuardUserId($this->getObject()->getId());
    //   $nform = new ProfileForm($nprof);
    //   $this->embedForm('new', $nform);
    // }else{
      $this->embedRelation('Profile');  
    // }
  	
  }
}
