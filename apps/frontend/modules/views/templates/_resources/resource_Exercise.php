<?php $exercise = $resource->getExercise() ?>

<h3><?php echo $exercise->getTitle() ?></h3>
<p><?php echo $exercise->getRaw('description') ?></p>

<form action="<?php echo url_for("exercise/validate") ?>" method="post" id="exercise_form">
<?php foreach ($exercise->getQuestions() as $question): ?>
  <hr>
  <?php include_partial("views/exercise/type_" . $question->getType(), array('exercise' => $exercise, 'question' => $question))?>
<?php endforeach ?>
<input type="hidden" name="exercise_id" value="<?php echo $exercise->getId() ?>">
<input type="submit" value="Validar">
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

	$("#exercise_form").ajaxForm(options);
	$('#exercise_form').bind('form-pre-serialize', function(e) {
        tinyMCE.triggerSave();
    });

    $(document).ready(function(){
        
    });


</script>

