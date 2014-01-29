<div class="tab-pane video_session-tab_container" id="tab-<?php echo $type; ?>_video_sessions">

    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#pane-<?php echo $type; ?>_video_sessions_next" data-toggle="tab">Próximas</a>
            </li>
            <li class="">
                <a href="#pane-<?php echo $type; ?>_video_sessions_prev" data-toggle="tab">Anteriores</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="pane-<?php echo $type; ?>_video_sessions_next">
                <?php include_partial('list', array('type' => 'next', 'video_sessions' => $next, 'pid' => $pid)); ?>
            </div>
            <div class="tab-pane" id="pane-<?php echo $type; ?>_video_sessions_prev">
                <?php include_partial('list', array('type' => 'prev', 'video_sessions' => $prev, 'pid' => $pid)); ?>
            </div>

        </div>
    </div>
</div>