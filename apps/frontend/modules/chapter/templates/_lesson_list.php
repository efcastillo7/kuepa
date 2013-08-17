<div class="lesson_list" >
    <ul class="unstyled eg-back">
        <li>
            <a href="javascript:void()" class="go-back">
                <span>Atrás</span> Volver a la Unidad
            </a>
        </li>
    </ul>
    <ul class="unstyled">
        <?php foreach ($lessons as $lesson): ?>
        <li>
            <a href="">
                <div class="lp-node">
                    <div class="lp-bar-prev"></div>
                    <div class="lp-bar-post viewed"></div>
                    <span class="lp-node-play"></span>
                    <input class="knob knob-small" value="100" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                </div>
                <?php echo $lesson->getName() ?>
                <span class="lp-time">10'32''</span>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div> 