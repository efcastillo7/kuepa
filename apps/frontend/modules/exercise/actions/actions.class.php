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

    //get exercise
  	$exercise = Exercise::getRepository()->find($exercise_id);

    //evaluate
  	$correct_values = $exercise->evaluate($answers);

    //save response
    ExerciseService::getInstance()->saveAttemp($user_id, $exercise_id, 0, $correct_values['score'], $values);

    //get attemps
    $attemps = ExerciseService::getInstance()->getAttemps($user_id, $exercise_id);

    $r_attemps = array();

    foreach($attemps as $attemp){
      $r_attemps[] = $attemp->getValue();
    }

  	$ar_response = array(
  		'exercise' => array(
  			'id' => $exercise_id, 
  			'questions' => array('count' => $exercise->getQuestions()->count()),
  			'score'  => array('total' => $exercise->getTotalScore(), 'value' => $correct_values['score']),
  		),
  		'answers' => $correct_values['answers'],
      'attemps' => $r_attemps
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
