<!-- <div class="course">
    <ul>
        <?php foreach ($course->getChildren() as $child): ?>
            <?php include_partial('course_Component', Array('component' => $child)); ?>
        <?php endforeach; ?>
    </ul>
</div> --->

<div class="eg-expander expanded">
    <div class="eg-expander-inner">
        <div class="eg-close-container"><span class="eg-close"></span></div>
        <div class="eg-thumb">
            <img src="img/subject-icons/subject-icn-biology.png">
        </div>
        <div class="eg-details">
            <p class="title3 clearmargin"><?php echo $course->getName() ?></p>
            <p class="title5 gray2">40% Completado</p>
            <p class="small1 gray4">7 Unidades  /  32 Lecciones  /  2h 40’52’’ / 5 Ejercicios  /  1 Evaluación</p>
            <p class="margintop">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="eg-multimenu">
            <ul class="unstyled eg-back">
                <li>
                    <a href="">
                        <span>Atrás</span> Unidad 1
                    </a>
                </li>
            </ul>
            <ul class="unstyled">
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev"></div>
                            <div class="lp-bar-post viewed"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="100" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.01. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev viewed"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="63" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.02. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="0" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.03. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev viewed"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="44" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.04. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="0" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.05. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev viewed"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="10" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.06. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev viewed"></div>
                            <div class="lp-bar-post viewed"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="100" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.07. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="0" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.08. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="lp-node">
                            <div class="lp-bar-prev"></div>
                            <div class="lp-bar-post"></div>
                            <span class="lp-node-play"></span>
                            <input class="knob knob-small" value="0" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                        </div>
                        01.09. Lección lorem uno
                        <span class="lp-time">10'32''</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>