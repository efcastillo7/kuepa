<!-- Content -->
<?php $resourceData = $resource->getResourceData()->getFirst();
      $exercise = $resourceData->getExercise();
      $questions = $exercise->getQuestions();
?>

<form action="<?php echo url_for("exercise/validate") ?>" method="post" id="exercise_form">
  <section class="data-exercise two-columns clearpadding" data-spy="scroll" data-target="#navbar-scroll">

    <div class="content">
      <h2><?php echo $exercise->getTitle() ?></h2>

      <section class="breadcrum gray">
        <div class="icon bg-<?php echo $course->getColor()?>-alt-1">
          <img src="<?php echo $course->getThumbnailPath() ?>">
        </div>

        <span>Ejercitación</span>
        <i class="spr ico-arrow-breadcrum"></i>

        <span>Contesta a continuación las preguntas 1 a <?php echo $exercise->getQuestions()->count() ?></span>
      </section>
    </div>

    <div class="content questions">
      <?php for ($i=0; $i < $questions->count(); $i++): ?>
      <h4 id="ex-question-<?php echo $i+1?>">
        <i class="dot8 orange"></i> Pregunta <?php echo $i+1 ?>
      </h4>
      <?php include_partial("type_" . $questions[$i]->getType(), array('exercise' => $exercise, 'question' => $questions[$i]))?>
      <?php endfor ?>

    </div><!-- /content questions -->

  </section>


  <input type="hidden" name="exercise_id" value="<?php echo $exercise->getId() ?>">
  <div class="row">
    <section class="correct">
      <div class="left">
        <span class="subject"><?php echo $resource->getName() ?></span>
      </div>
      <div class="right">
        <span class="send">Enviar respuestas y corregir</span>
        <button type="submit" class="send-square blue">
          <i class="spr ico-arrows-right"></i>
          <i class="spr ico-arrows-right"></i>
        </button>
      </div>
    </section>
  </div>
</form>

<!-- Modals -->

<script>
    var init_time = new Date().getTime();;
    var options = {
        success: function(response, statusText, xhr, $form) {
            var exercise = response.data.exercise;
            var answers = response.data.questions;
            var questions = response.data.questions;
            var total_time = new Date().getTime() - init_time;
            total_time = (total_time/60000).toFixed(1);

            for (var key in answers){
              var objs = $("span#answer_" + exercise.id + "_" + key);
              for(var i=0;i<answers[key]['answers'].length;i++){
                $(objs[i]).html("<img src='/images/icons/" + (answers[key]['answers'][i].correct ? "ok-icon.jpg" : "error-icon.png") + "'>");
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
                      alert('Listo, ya hemos armado tu camino de aprendizaje. Empieza a estudiar ahora!');
                      addItemsToPath(item);
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

    $(document).ready(function(){
        
    });


</script>