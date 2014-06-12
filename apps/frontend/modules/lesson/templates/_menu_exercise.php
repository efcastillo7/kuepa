<?php $resourceData = $resource->getResourceData()->getFirst(); ?>
<?php $exercise = $resourceData->getExercise() ?>

<section class="wrapper-aside-exercise clearpadding">
  <aside class="aside-exercise">
    <div class="lessons">
      <a href="<?php echo url_for("resource/expanded2?course_id={$course->getId()}&chapter_id={$chapter->getId()}&lesson_id={$lesson->getId()}") ?>" class="arrow-hover-left navigation-menu">
        <i class="spr ico-arrow-left10"></i>
        Recursos
      </a>
    </div>
    <ul class="list-aside-exercise">
      <li>
        <a class="title-arrow" data-toggle="collapse" data-target="#node1">Ejercitación <i class="spr ico-arrow-down-aside"></i></a>
        <div id="node1" class="in">
          <ul class="section">
            <li>

              <a class="first title-arrow" data-toggle="collapse" data-target="#node1-1">
                <div class="back-icon active">
                  <i class="spr ico-star"></i>
                </div>
                <div class="after active"></div>

                <span>
                  Preguntas 1 a <?php echo $exercise->getTotal() ?>
                  <i class="spr ico-arrow-down-aside"></i>
                </span>
              </a>


              <div id="node1-1" class="in">
                <ul class="questions">
                  <?php for($i=1; $i<=$exercise->getTotal();$i++): ?>
                  <li>
                    <a href="#ex-question-<?php echo $i ?>">
                      <span class="line"></span>
                      <span class="dot8"></span>
                      Pregunta <?php echo $i ?>
                      <i class="spr ico-arrow-orange"></i>
                    </a>
                  </li>
                  <?php endfor ?>
                </ul>
              </div>
            </li>            
          </ul>
        </div>
      </li>

    </ul>
  </aside>
</section>