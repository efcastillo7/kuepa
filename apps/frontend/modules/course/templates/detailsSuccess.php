<?php use_javascript("/assets/tinymce/tinymce.min.js") ?>
<?php use_javascript("/assets/tinymce/jquery.tinymce.min.js") ?>
<!-- UI TOUCH for drag & drop for ios -->
<?php use_javascript("/assets/jquery-ui-touch/jquery.ui.touch-punch.min.js") ?>

<div class="unit-view">
    <div id="" class="container margintop60">
        <div id="" class="row">
            <div class="span12">
                <div class="unit-hd">
                    <div class="lv-icon bg-<?php echo $course->getColor() ?>-alt-1">
                        <img src="<?php echo $course->getThumbnailPath() ?>">
                    </div>
                    <p class="title3 HelveticaBd clearmargin"><i class="icon-chevron-right"></i><?php echo $course->getName() ?></p>
                    <p class="small1 HelveticaLt"><?php echo $course->getCacheCompletedStatus(); ?>% Completado</p>
                </div>
            </div>
            <div class="span12">
                <div class="unit-container">
                    <p class="gray4">
                        <?php echo $course->getRaw('description'); ?>
                    </p>
                </div>
            </div>

            <!-- Lista -->
            <div class="span12 margintop">
                <div class="unit-container">
                    <ul id="myCollapsible" class="lv-container unstyled" current_id="<?php echo $course->getId() ?>">
                        <!-- Add chapter if has privilege -->
                        <?php if ($sf_user->hasCredential("docente")): ?>
                        <li class="subject-item addchapter-button unsortable">
                            <div id="" class="black" type="button">
                                <p class="title5 HelveticaMd clearmargin">+ Agrear unidad al curso</p>
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
                        <?php endif; ?>
                        <!-- courses list    -->
                        <?php foreach ($course->getChapters() as $chapter): ?>
                            <?php if($sf_user->hasCredential("estudiante") && !$chapter->isEnabled()): ?>
                            <?php include_partial("detail_courses_chapter_blocked", array('course' => $course, 'chapter' => $chapter, 'profile' => $profile)) ?>
                            <?php else: ?>
                            <?php include_partial("detail_courses_chapter", array('course' => $course, 'chapter' => $chapter, 'profile' => $profile)) ?>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- /container -->
</div>

<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('chapter', 'Modalform', array('course_id' => $course->getId())) ?>
<?php include_component('lesson', 'Modalform') ?>
<?php include_component('resource', 'Modalform') ?>

<script>
    //chapters
    $("#myCollapsible").sortable({
        items: "li:not(.unsortable)",
        stop: sortStopped
    });

    //lessons
    $(".lv-lvlone").sortable({
        items: "li:not(.unsortable)",
        stop: sortStopped
    });

    //resources
    $(".lv-lvltwo").sortable({
        items: "li:not(.unsortable)",
        stop: sortStopped
    });

    function sortStopped(event, ui) {
        var parent_id = $(this).attr("current_id");
        var ordered_children_ids = new Array();
        $(this).children(".a-son-li").each(function() {
            ordered_children_ids.push($(this).attr("current_id"));
        });

        $.ajax('<?php echo url_for("component/reorder") ?>', {
            data: {parent_id: parent_id, ordered_children_ids: ordered_children_ids.join(",")},
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                if (data.status === "success") {
                    alert("ok");
                } else {
                    alert("error");
                }
            }
        });
    }
</script>
<?php endif; ?>