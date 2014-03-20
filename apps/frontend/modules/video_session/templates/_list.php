<?php use_helper('Date'); ?>

<table class="table table-hover">
    <thead>
        <tr>
            <th></th>
            <?php if ($sf_user->hasCredential("docente")): ?>
            <th></th>
            <?php endif; ?>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Curso - Temática</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($video_sessions) > 0):
            foreach ($video_sessions as $video_session):

                $storedUrl      = $video_session->getUrl();
                $storedColor    = $video_session->getCourse()->getColor();
                $color          = empty($storedColor) ? "default" : $storedColor;
                $chapter        = $video_session->getChapter()->getName();
                $isOwner        = $video_session->getProfileId() == $pid;

                //Adds the profile_id to the url
                $storedUrl      =  $video_session->getPlatform() == VideoSessionService::PLATFORM_HANGOUTS ? VideoSessionService::getInstance()->injectProfileId($storedUrl,$pid) : $storedUrl;

                ?>
                <tr class="video-session-tr" data-id="<?php echo $video_session->getId() ?>" data-scheduled_for="<?php echo $video_session->getScheduledFor() ?>">
                    <td><div class="list_icon video_session_status <?php echo $video_session->getStatus(); ?>" data-toggle="tooltip" title="<?php echo VideoSessionService::$status_es[$video_session->getStatus()]; ?>">&nbsp;</div></td>
                    <?php if ($sf_user->hasCredential("docente")): ?>
                    <td><div class="list_icon video_session_visibility <?php echo $video_session->getVisibility(); ?>" data-toggle="tooltip" title="<?php echo VideoSessionService::$visibility_es[$video_session->getVisibility()]; ?>">&nbsp;</div></td>
                    <?php endif; ?>
                    <td><?php echo format_date($video_session->getScheduledFor(), 'dd-MM-yyyy HH:mm'); ?> hs</td>
                    <td><?php echo format_date($video_session->getScheduledEnd(), 'dd-MM-yyyy HH:mm'); ?> hs</td>
                    <td></td>
                    <td><?php echo $video_session->getTitle() ?></td>
                    <td><?php echo $video_session->getDescription() ?></td>
                    <td class="text-<?php echo $color ?>"><?php echo $video_session->getCourse()->getName().(empty($chapter) ? "" : " - {$chapter}"); ?></td>
                    <?php if($type==="next"): ?>
                    <td>
                        <div class="btn-group">
                        <?php if($isOwner): ?>
                            <a class="editVideoSession-button btn btn-mini" href="<?php echo url_for('video_session/edit?id=' . $video_session->getId()) ?>">Editar</a>
                            <a class="btn btn-mini btn-warning <?php echo $video_session->getStatus() != "started" ? "disabled" : "finishVideoSession-trigger" ?>">Finalizar</a>
                            <?php if(empty($storedUrl)): ?>
                            <span class="hangout_actions">
                                <div class="g-hangout" data-render="createhangout" data-initial_apps="[{ app_id : '36700081185', start_data : {'video_session_id':'<?php echo $video_session->getId(); ?>','type':'<?php echo $video_session->getType(); ?>','profile_id':'<?php echo $pid; ?>'}, 'app_type' : 'ROOM_APP' }]" data-widget_size="72"></div>
                            </span>
                            <?php else: ?>
                            <a target="_blank" class="access-button-<?php echo $video_session->getId() ?>  btn btn-mini btn-success <?php echo $video_session->getStatus() != "started" ? "disabled" : "" ?>" href="<?php echo $storedUrl; ?>">Acceder</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a target="_blank" class="access-button-<?php echo $video_session->getId() ?> btn btn-mini btn-success <?php echo ($video_session->getStatus() != "started" || empty($storedUrl)) ? "disabled" : "" ?>" href="<?php echo $storedUrl; ?>">Acceder</a>
                        <?php endif; ?>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr class="">
                <td colspan="8">
                    <div class="margintop txt-center title5">
                        No se encontraron sesiones de video
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>