<?php use_javascript("/assets/tinymce/tinymce.min.js") ?>
<?php use_javascript("/assets/tinymce/jquery.tinymce.min.js") ?>
<?php use_javascript("https://raw.github.com/furf/jquery-ui-touch-punch/master/jquery.ui.touch-punch.min.js") ?>
<?php use_javascript("/assets/smartspin/smartspinner.js") ?>
<?php use_stylesheet("/assets/smartspin/smartspinner.css") ?>



<div class="unit-view">
    <div id="" class="container margintop60">
        <div id="" class="row">
            <div class="span12">
                <div class="unit-hd">
                    <div class="lv-icon lvs-biology">
                       <img src="img/subject-icons/subject-icn-biology.png">
                    </div>
                    <p class="title3 HelveticaBd clearmargin"><i class="icon-chevron-right"></i><?php echo $course->getName() ?></p>
                    <p class="small1 HelveticaLt"><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $course->getId()) ?>% Completado</p>
                </div>
            </div>
            <div class="span12">
                <div class="unit-container">
                    <p class="gray4 italic">
                        <?php echo $course->getDescription() ?>
                    </p>
                </div>
            </div>

            <!-- Lista -->
            <div class="span12 margintop">
                <div class="unit-container">
                    <ul id="myCollapsible" class="lv-container unstyled">
                        <!-- Add chapter if has privilege -->
                        <li class="subject-item addchapter-button">
                            <div id="" class="black" type="button">
                                <p class="title5 HelveticaRoman clearmargin">+ Agrear unidad al curso</p>
                             </div>
                             <div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <p class="gray4 italic">
                                            Agregar una nueva unidad al curso
                                        </p>
                                    </div>
                                </div>
                             </div>
                        </li>
                        <!-- courses list    -->
                        <?php foreach ($course->getChapters() as $chapter): ?>
                        <?php include_partial("detail_courses_chapter", array('course' => $course, 'chapter' => $chapter, 'profile' => $profile)) ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- /container -->
</div>
<?php include_component('chapter', 'Modalform', array('course_id' => $course->getId())) ?>
<?php include_component('lesson', 'Modalform') ?>
<?php include_component('resource', 'Modalform') ?>
<script>
    $('.spinner').spinit({min:1, max:200, stepInc:1, pageInc:20, height: 22, width: 100 });
    $( "#myCollapsible" ).sortable();
    $( ".lv-lvlone" ).sortable();
    $( ".lv-lvltwo" ).sortable();
</script>