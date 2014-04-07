<section class="wrapper-aside-lesson clearpadding">
  <aside class="aside-lesson">
    <div class="lessons">
      <a href="<?php echo url_for("chapter/expanded2?course_id={$course->getId()}&chapter_id={$chapter->getId()}&lesson_id={$chapter->getId()}") ?>" class="arrow-hover-left navigation-menu">
        <i class="spr ico-arrow-left10"></i>
        Unidades
      </a>
    </div>
    <ul class="list-aside-lesson">
      <li class="head-list">
        <h3><?php echo $chapter->getName() ?></h3>
        <h4><?php echo $chapter->getChildren()->count() ?> recursos, <?php echo round($chapter->getDuration()/60,2) ?> minutos</h4>
      </li>
      
      <?php $previous_percentage = 0; foreach ($chapter->getChildren() as $child): ?>
          <?php $current_percentage = $child->getCacheCompletedStatus(); ?>
          <li>
            <div class="icon">
              <?php if($current_percentage == 100): ?>
              <div class="back-full"></div>
              <div class="spr ico-full"></div>
              <?php else: ?>
              <div class="spr ico-triangle-gray"></div>
              <?php endif; ?>

              <div class="lp-node">
                <div class="lp-bar-prev <?php echo ($previous_percentage!=null && $previous_percentage==100? "full":"") ?>"></div>
                <div class="lp-bar-post <?php echo ($current_percentage!=null && $current_percentage==100?"full":"") ?>"></div>
                <span class="lp-node-play"></span>
                <input class="knob" value="<?php echo $current_percentage ?>" data-fgColor="#ff671b" data-bgColor="#c7c7cc" data-width="28" data-height="28" data-thickness=".28" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
              </div>
            </div>
            <a class="<?php echo $child->getId() == $lesson->getId() ? "orange" : "" ?> navigation-menu navigation-menu-in" href="<?php echo url_for("resource/expanded2?course_id={$course->getId()}&chapter_id={$chapter->getId()}&lesson_id={$child->getId()}") ?>">
                <?php echo $child->getName() ?>
            </a>
          </li>
          <?php $previous_percentage = $current_percentage; ?>
      <?php endforeach; ?>

    </ul>
  </aside>
</section>