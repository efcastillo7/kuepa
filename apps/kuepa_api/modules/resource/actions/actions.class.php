<?php

/**
 * resource actions.
 *
 * @package    kuepa
 * @subpackage resource
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class resourceActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeEdit(sfWebRequest $request){
  	try {
		$id = $request->getParameter("id");
		$name = $request->getParameter("name", null);
  		$resource = Resource::getRepository()->find($id);

  		//get first resource (only available for now)
  		$resource_data = $resource->getResourceData()->getFirst();

  		//get content
  		$content = $request->getParameter("content");

  		//update content
  		$resource_data->setContent($content)
  					  ->save();

  		//update title
  		if($name){
	  	    $resource->setName($name)
	  	    		 ->save();
  		}

		return $this->renderText(json_encode($resource->toArray()));
	} catch (ComponentNotFound $e) {
		$this->getResponse()->setStatusCode(404);

		return $this->renderText(json_encode(Array('status' => 'error')));
	} catch (Exception $e) {
		$this->getResponse()->setStatusCode(500);

		return $this->renderText(json_encode(Array('status' => 'error')));
	}

  }
}
