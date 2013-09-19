<div id="" class="container">
    <div id="" class="row">
        <div class="span8 offset1">
            <p class="title3">¡Bienvenido, usuario.alumno!</p>
            <p class="title3 HelveticaLt clearmargin">pregunta.principal</p>
        </div>
        <div class="span2">
            <div class="view-mode">
                <a href="#" class="vm-grid active" target="subject-grid" rel="tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modo grilla">Grilla</a>
                <a href="#" class="vm-list" target="subject-list" rel="tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modo Lista">Lista</a>
            </div>
        </div>

        <!-- Grilla -->
        <div class="main">
            <?php include_partial("views/main/grid", array('courses' => $courses)) ?>
            <?php include_partial("views/main/list", array('courses' => $courses)) ?>
        </div>
    </div>
</div>
<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('course', 'Modalform') ?>
<?php endif; ?>