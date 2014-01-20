<!-- Content -->
<?php $resourceData = $resource->getResourceData()->getFirst();
      $exercise = $resourceData->getExercise();
      $questions = $exercise->getQuestions();
?>

<form action="<?php echo url_for("exercise/validate") ?>" method="post" id="exercise_form">
  <section class="data-exercise two-columns clearpadding" data-spy="scroll" data-target="#navbar-scroll">

    <div class="content">
      <h2><?php echo $exercise->getDescription() ?></h2>

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
<?php include_partial("views/modals/exercise") ?>

<script>
    var init_time = new Date().getTime();;
  var options = {
        success: function(response, statusText, xhr, $form) {
            var exercise = response.data.exercise;
            var answers = response.data.answers;
            var total_time = new Date().getTime() - init_time;
            total_time = (total_time/60000).toFixed(1);

            for (var key in answers){
              var objs = $("span#answer_" + exercise.id + "_" + key);
              for(var i=0;i<answers[key].length;i++){
                $(objs[i]).html("<img src='/images/icons/" + (answers[key][i].correct ? "ok-icon.jpg" : "error-icon.png") + "'>");
              }
            }

            var score = (exercise.score.value/exercise.score.total*100).toFixed(2);

            triggerModalExercise({
                id: "modal-exercise", 
                title: "Resultado de su ejercitación", 
                count_questions: exercise.questions.count,
                score: score + " %",
                time: total_time,
                text: "", 
                effect: "md-effect-17"});

            $(".dial").knob({
                'readOnly': true,
                'width': 150,  
            });

            $({value: 0}).animate({value: score}, {
                duration: 1500,
                easing:'swing',
                step: function() 
                {
                    $('.dial').val(Math.ceil(this.value)).trigger('change');
                }
            });

            var atts = [];
            for(var i =0; i< response.data.attemps.length; i++){
                atts[i] = parseFloat(response.data.attemps[i]);
            }

            $('#graph').highcharts({
                title: {
                    text: 'Historial de notas',
                    x: -20 //center
                },
                tooltip: {
                    valueSuffix: ''
                },
                yAxis: {
                    title: {
                        text: 'Nota '
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'Ejercicio',
                    data: atts
                }]
            });

            //add dependencies if score
            if(score < 70){
                var ans = confirm('desea agregar dependencias?');
                if(ans){
                    classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
                    lpService.addDependencies({
                        course_id: course_id, lesson_id: lesson_id, chapter_id: chapter_id,
                        onSuccess: function(item){
                            addItemsToPath(item);
                        },
                        onError: function(data){
                            alert('Ya tiene esa lección');
                        }
                    });
                }
            }
        },
        dataType: 'json'
  };

  function triggerModalExercise(data){
  //redo
  el = $("#"+data.id);
  $("#title", el).html(data.title);
  $("#text", el).html(data.text);
  $("#count_questions", el).html(data.count_questions);
  $("#time", el).html(data.time);
  $("#score", el).html(data.score);
  el.show();

  el.addClass("md-show");
  el.addClass(data.effect);

  var overlay = $('.md-overlay');

  $('.md-close',el).click(function(e){
    e.stopPropagation();
    el.removeClass('md-show');
  });

}

  $("#exercise_form").ajaxForm(options);
  
    $(document).ready(function(){
        
    });


</script>