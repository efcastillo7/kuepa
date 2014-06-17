<script type="text/javascript">
    var googleID = "<?php echo $google_id; ?>";
</script>

<div id="" class="container margintop60">
    <div class="row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <p class="title3">Sesiones de video</p>
                </div>
                <?php if ($sf_user->hasCredential("docente")): ?>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="btn btn-default btn-primary addVideoSession-button col-xs-12" data-platform="external"><img src="img/hangout.png" alt="H" />Crear Tutoría Externa</a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="btn btn-default btn-success addVideoSession-button col-xs-12" data-platform="hangouts"><img src="img/hangout.png" alt="H" />Crear Hangout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="tabbable">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs video_session-nav">
                    <?php if ($sf_user->hasCredential("docente")): ?>
                    <li class="active"><a href="#tab-own_video_sessions" data-toggle="tab">Creadas por mi</a></li>
                    <?php endif; ?>
                    <li><a href="#tab-related_video_sessions" data-toggle="tab">Referentes a mis cursos</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="tab-content">
    <?php
    if ($sf_user->hasCredential("docente")){
        include_partial(
            'list_container',
            array(
                'type'  => 'own',
                'pid'   => $profile_id,
                'prev'  => $prev_own_video_sessions,
                'next'  => $next_own_video_sessions
            )
        );
    }

    include_partial(
        'list_container',
        array(
            'type'  => 'related',
            'pid'   => $profile_id,
            'prev'  => $prev_related_video_sessions,
            'next'  => $next_related_video_sessions
        )
    );

    ?>
</div>


<?php
echo include_component('video_session', 'Modalform');
echo include_component('video_session', 'Modalurl');
echo include_partial('Modalform_edit');
echo include_partial('Modalfinish');
echo include_partial('ModalLogin');
echo include_partial('ModalParticipants');
?>

<script src="/js/video_session.js"></script>