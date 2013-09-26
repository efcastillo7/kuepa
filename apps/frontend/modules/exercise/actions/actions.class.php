<?php

/**
 * exercise actions.
 *
 * @package    kuepa
 * @subpackage exercise
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class exerciseActions extends sfActions
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

  public function executeValidate(sfWebRequest $request){
  	$exercise_id = $request->getParameter('exercise_id');
  	$user_id = $this->getUser()->getProfile()->getId();

  	$values = $request->getPostParameters();
  	$answers = $values['exercise'][$exercise_id];

  	$exercise = Exercise::getRepository()->find($exercise_id);

  	$correct_values = $exercise->evaluate($answers);

  	$ar_response = array(
  		'exercise' => array(
  			'id' => $exercise_id, 
  			'questions' => array('count' => $exercise->getQuestions()->count()),
  			'score'  => array('total' => $exercise->getTotalScore(), 'value' => $correct_values['score']),
  		),
  		'answers' => $correct_values['answers']
	);

    if ($request->isXmlHttpRequest()) {
        $response = Array(
            'status' => 'success',
            'data' => $ar_response
        );

        return $this->renderText(json_encode($response));
    }

    return $this->renderText(json_encode($ar_response));
  }
}
