<div class="tab-pane video_session-tab_container" id="tab-support">

    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#pane-own_video_sessions_next" data-toggle="tab">Pendientes</a>
            </li>
            <li class="">
                <a href="#pane-own_video_sessions_prev" data-toggle="tab">Finalizadas</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="pane-own_video_sessions_next">
                <?php include_partial('list', array('type' => 'pending', 'video_sessions' => $pending, "pid" => $pid)); ?>
            </div>
            <div class="tab-pane" id="pane-own_video_sessions_prev">
                <?php include_partial('list', array('type' => 'historic', 'video_sessions' => $historic, "pid" => $pid)); ?>
            </div>

        </div>
    </div>
</div>