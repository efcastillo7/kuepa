<?php

/**
 * component actions.
 *
 * @package    kuepa
 * @subpackage component
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class componentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeReorder(sfWebRequest $request) {
        if (!$request->isXmlHttpRequest()) {
            $this->forward404();
        }

        //falta validar que este logueado y tenga permisos para hacer esto?

        $parent_id = $request->getParameter('parent_id');
        $new_ordered_childs = $request->getParameter('ordered_children_ids');

        $new_ordered_childs_array = explode(",", $new_ordered_childs);
        $new_ordered_childs_hash = array();
        $order = 1;
        foreach ($new_ordered_childs_array as $child_id) {
            $new_ordered_childs_hash[$order] = Component::getRepository()->find($child_id);
            $order++;
        }

        ComponentService::getInstance()->reOrderComponentChildren($parent_id, $new_ordered_childs_hash);

        $response = Array(
            'status' => 'success'
        );

        return $this->renderText(json_encode($response));
    }

    public function executeRemove(sfWebRequest $request) {
        $parent_id = $request->getParameter("parent_id");
        $child_id = $request->getParameter("child_id");

        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        if($return = ComponentService::getInstance()->removeChildFromComponent($parent_id, $child_id)){
            $response['status'] = "success";
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }
}
