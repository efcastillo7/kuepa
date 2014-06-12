<!-- Content -->
<?php $resourceData = $resource->getResourceData()->getFirst();
      $exercise = $resourceData->getExercise();
      $questions = $exercise->getQuestionsByLevel();
?>

<form action="<?php echo url_for("exercise/validate") ?>" method="post" id="exercise_form">
  <section class="data-exercise two-columns clearpadding" data-spy="scroll" data-target="#navbar-scroll">

    <div class="content margintop100">
    <?php if ($sf_user->hasCredential("editor")): ?>
    <a href="<?php echo url_for("@exercise_edit?exercise_id=" . $exercise->getId()) ?>" class="btn btn-primary btn-orange">Editar</a>
    <?php endif; ?>
      <h2>
        <?php echo $exercise->getTitle() ?>
      </h2>
      <section class="breadcrum gray">
        <div class="icon bg-<?php echo $course->getColor()?>-alt-1">
          <img src="<?php echo $course->getThumbnailPath() ?>">
        </div>
        <span>Ejercitación</span>
        <i class="spr ico-arrow-breadcrum"></i>
        <span>Contesta a continuación las preguntas 1 a <?php echo ($exercise->getTotal()) ?></span>
      </section>
    </div>

    <div class="content questions">
      <?php include_partial("content_questions", array('questions' => $questions, 'exercise' => $exercise, 'type' => "", 'numero' => 0)) ?>
      <button type="submit" class="btn btn-large btn-orange">Enviar respuestas y corregir</button>

    </div>
    
  </section>
  <input type="hidden" name="exercise_id" value="<?php echo $exercise->getId() ?>">

</form>
<div class="clear"></div>

<!-- Modals -->

<script>
    var init_time = new Date().getTime();;
    var options = {
        success: function(response, statusText, xhr, $form) {
            var exercise = response.data.exercise;
            var questions = response.data.questions;
            var total_time = new Date().getTime() - init_time;
            total_time = (total_time/60000).toFixed(1);

            for (var key in questions){
              var objs = $("div#answer_" + exercise.id + "_" + key);
              var span = $("span#answer_" + exercise.id + "_" + key);

              $(objs).addClass(questions[key].correct ? "correct" : "incorrect");
              $(objs).removeClass(!questions[key].correct ? "correct" : "incorrect");


              //iterate answers for display (for types choose)
              for(var i=0;i<span.length;i++){
                $(span[i]).addClass(questions[key]['answers'][i].correct ? "correct" : "incorrect");
                $(span[i]).removeClass(!questions[key]['answers'][i].correct ? "correct" : "incorrect");
              }
            }

            var score = (exercise.score.value/exercise.score.total*100).toFixed(2);

            if(response.data.dependencies.length > 0){
              var question_ids = [];

              for(var question_id in questions){
                if(!questions[question_id].correct){
                  question_ids.push(question_id);
                }
              }

              classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
              lpService.addDependenciesForExam({
                  exercise_id: exercise.id,
                  question_ids: question_ids,
                  onSuccess: function(item){
                     // Cambiado mensaje a peticion de Jorge Garcia
                     if ( item.length > 0 ){
                      alert('Listo, hemos usado tus resultados para agregar algunas lecciones a tu camino de aprendizaje');
                      addItemsToPath(item);
                     }else{
                      alert('Muy bien, no es necesario agregar ninguna lección a tu camino por ahora');
                     }
                  },
                  onError: function(data){
                      // alert('Ya tiene esa lección');
                  }
              });
            }
        },
        dataType: 'json'
  };

  $("#exercise_form").ajaxForm(options);
</script>