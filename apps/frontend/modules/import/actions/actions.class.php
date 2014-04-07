<?php

/**
 * import actions.
 *
 * @package    kuepa
 * @subpackage import
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class importActions extends kuepaActions
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

  public function executeCourse(sfWebRequest $request)
  {
    $this->form = new ImportCourseForm();

    if($request->isMethod("POST")){
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid())
      {
        $file = $this->form->getValue('file');

        $filename  = $file->getOriginalName(); //or whatever name
        $extension = $file->getExtension($file->getOriginalExtension());
        $path = sfConfig::get('sf_upload_dir').'/tmp/'.$filename.$extension;
        $file->save($path);

        $data = unserialize(file_get_contents($path));
        //check for invalid data

        if(!is_array($data)){
          echo "error";
        }

        // echo var_dump($data);die();

        //create Course
        $data['name'] = $data['name'] . "-imp";
        // echo $data['name'];
        $course = CourseService::getInstance()->create($data);

        foreach($data['chapters'] as $chapter){
          //create chapter
          $nchapter = ChapterService::getInstance()->create($chapter);

          foreach ($chapter['lessons'] as $lesson) {
            //create lesson
            $nlesson = LessonService::getInstance()->create($lesson);

            foreach ($lesson['resources'] as $resource) {
              $nresource = ResourceService::getInstance()->create($resource);

              //resourceData
              foreach ($resource['data'] as $data) {
                $nresdata = new ResourceData();
                $nresdata->setResourceId($nresource->getId())
                         ->setPosition($data['position'])
                         ->setContent($data['content'])
                         ->setTags($data['tags'])
                         ->setEnabled($data['enabled'])
                         ->setDuration($data['duration'])
                         ->setLevel($data['level'])
                         ->setWordCount($data['word_count'])
                         ->setReadingTime($data['reading_time'])
                         ->setType($data['type'])
                         ->setDocumentType($data['document_type'])
                         ->setVideoType($data['video_type'])
                         ->setPath($data['path'])
                         ->setCreatedAt($data['created_at'])
                         ->setUpdatedAt($data['updated_at'])
                         ->save();

                if($data['type'] == ResourceDataExercise::TYPE){
                  $a_ex = $data['exercise'][0];
                  $exercise = new Exercise();
                  $exercise->setTitle($a_ex['title'])
                           ->setDescription($a_ex['description'])
                           ->setType($a_ex['type'])
                           ->setMaxAttemps($a_ex['max_attemps'])
                           ->setStartTime($a_ex['start_time'])
                           ->setEndTime($a_ex['end_time'])
                           ->setExpiredTime($a_ex['expired_time'])
                           ->setRandom($a_ex['random'])
                           ->setResultsDisabled($a_ex['results_disabled'])
                           ->save();

                  foreach ($a_ex['Questions'] as $a_que) {
                    $question = new ExerciseQuestion();
                    $question->setTitle($a_que['title'])
                             ->setDescription($a_que['description'])
                             ->setValue($a_que['value'])
                             ->setType($a_que['type'])
                             ->save();

                    $rel = new ExerciseHasExerciseQuestion();
                    $rel->setExercise($exercise)
                        ->setExerciseQuestion($question)
                        ->save();

                    foreach ($question['Answers'] as $a_ans) {
                      $answer = new ExerciseAnswer();
                      $answer->setTitle($a_ans['title'])
                             ->setComment($a_ans['comment'])
                             ->setValue($a_ans['value'])
                             ->setCorrect($a_ans['correct'])
                             ->setExerciseQuestion($question)
                             ->save();
                    }
                  }

                }

              }

              //add resource to lesson
              LessonService::getInstance()->addResourceToLesson($nlesson->getId(), $nresource->getId());
            }

            //add lesson to chapter
            ChapterService::getInstance()->addLessonToChapter($nchapter->getId(), $nlesson->getId());
          }

          //add chapter to course
          CourseService::getInstance()->addChapterToCourse($course->getId(), $nchapter->getId());
        }

        //add user
        CourseService::getInstance()->addStudent($course->getId(), $this->getProfile()->getId());
      }

    }

  }
}
