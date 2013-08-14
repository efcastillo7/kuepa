<div id="" class="container">
    <div id="productos" class="row">
        <div class="span10 offset1">
            <p class="title3">¡Bienvenido, usuario.alumno!</p>
            <p class="title3 HelveticaLt clearmargin">pregunta.principal</p>
        </div>

        <!-- Grilla -->
        <div class="subject-grid span10 offset1 margintop white">
            <ul id="eg-grid" class="eg-grid">
                <?php foreach ($courses as $course): ?>
                    <li class="subject-item">
                        <a class="subject-link" href="<?php echo url_for('course/expanded?course_id=' . $course->getId()) ?>">
                            <div class="subject-buttonbox subject-biology txt-center">
                                <div class="subject-title">
                                    <p class="title4 HelveticaMd clearmargin"><?php echo $course->getName() ?></p>
                                    <p class="small1 HelveticaLt">40% Completado</p>
                                </div>
                                <div class="pbar-circle">
                                    <input class="knob" value="26" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                    <?php foreach ($courses as $course): ?>
                    <li class="subject-item">
                        <a class="subject-link" href="<?php echo url_for('course/expanded?course_id=' . $course->getId()) ?>">
                            <div class="subject-buttonbox subject-biology txt-center">
                                <div class="subject-title">
                                    <p class="title4 HelveticaMd clearmargin"><?php echo $course->getName() ?></p>
                                    <p class="small1 HelveticaLt">40% Completado</p>
                                </div>
                                <div class="pbar-circle">
                                    <input class="knob" value="26" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                    <?php foreach ($courses as $course): ?>
                    <li class="subject-item">
                        <a class="subject-link" href="<?php echo url_for('course/expanded?course_id=' . $course->getId()) ?>">
                            <div class="subject-buttonbox subject-biology txt-center">
                                <div class="subject-title">
                                    <p class="title4 HelveticaMd clearmargin"><?php echo $course->getName() ?></p>
                                    <p class="small1 HelveticaLt">40% Completado</p>
                                </div>
                                <div class="pbar-circle">
                                    <input class="knob" value="26" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>