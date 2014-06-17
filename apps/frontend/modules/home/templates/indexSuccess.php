<?php include_component('layout', 'messages') ?>
<div class="container margintop60">
    <div class="row">
        <div class="col-xs-12">
            <p class="title3">¡Bienvenido, <?php echo $sf_user->getProfile()->getFirstName() ?>!</p>
        </div>
    </div>
    <div class="row mrg-btm-40">
        <?php include_partial("views/main/grid", array('enabled_courses' => $enabled_courses, 'display_courses' => $display_courses)) ?>
    </div>
</div>

<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('course', 'Modalform') ?>
<?php endif; ?>