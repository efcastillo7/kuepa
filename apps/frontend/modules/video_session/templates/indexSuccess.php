<script type="text/javascript">
    var googleID = "<?php echo $google_id; ?>";
</script>

<div id="" class="container">
    <?php if ($sf_user->hasCredential("docente")): ?>
    <a href="#" class="pull-right btn btn-default addVideoSession-button" data-platform="hangouts"><img src="img/hangout.png" alt="H" />Crear Hangout</a>
    <?php endif; ?>
    <p class="title3">Sesiones de video</p>
    <div class="tabbable">
        <ul class="nav nav-tabs video_session-nav">
            <?php if ($sf_user->hasCredential("docente")): ?>
            <li class="active"><a href="#tab-own_video_sessions" data-toggle="tab">Creadas por mi</a></li>
            <?php endif; ?>
            <li><a href="#tab-related_video_sessions" data-toggle="tab">Referentes a mis cursos</a></li>
        </ul>
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
    </div>
</div>

<?php
echo include_component('video_session', 'Modalform');
echo include_component('video_session', 'Modalurl');
echo include_partial('Modalform_edit');
echo include_partial('Modalfinish');
echo include_partial('ModalLogin');
?>

<script src="/js/video_session.js"></script>