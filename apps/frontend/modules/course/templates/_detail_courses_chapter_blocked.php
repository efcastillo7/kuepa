<li class="subject-item a-son-li" id="<?php echo $chapter->getId() ?>" current_id="<?php echo $chapter->getId()?>">
    <a href="#" class="unit-tooltip" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $chapter->getCacheCompletedStatus(); ?>% completado" style="width:<?php echo $chapter->getCacheCompletedStatus(); ?>%;"><div></div></a>
    <div id="<?php echo $chapter->getNameSlug() ?>" class="black" type="button" data-toggle="" data-target="#lv-chapter-<?php echo $chapter->getId() ?>">
        <p class="title5 HelveticaRoman clearmargin">
            <?php echo $chapter->getName() ?> 
        </p>
        <span class="unit-time"><?php echo gmdate("Hº i'",$chapter->getDuration()) ?></span>
     </div>
     <div id="lv-chapter-<?php echo $chapter->getId() ?>" class="">
        <p class="gray4 italic">Contenido bloqueado por el docente.</p>
     </div>
</li>
<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('chapter', 'Modalform', array('course_id' => $course->getId(), 'id' => $chapter->getId())) ?>
<?php endif; ?>