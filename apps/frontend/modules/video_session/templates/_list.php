<?php use_helper('Date'); ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th width="24"></th>
            <th width="80">Fecha</th>
            <th width="60">Horario</th>
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

                //If the hangout has already been created it's joined, otherwise it's created
                $storedUrl = $video_session->getHangoutUrl();
                if(empty($storedUrl)){
                    $hangout_url    = "https://plus.google.com/hangouts/_?gid=".VideoSessionService::APP_ID;
                }else{
                    $hangout_url    = $storedUrl;
                }

                $storedColor    = $video_session->getCourse()->getColor();
                $color          = empty($storedColor) ? "default" : $storedColor;
                $chapter        = $video_session->getChapter()->getName();
                $isOwner        = $video_session->getProfileId() == $pid;

                ?>
                <tr data-id="<?php echo $video_session->getId() ?>" data-scheduled_for="<?php echo $video_session->getScheduledFor() ?>">
                    <td><div class="video_session_status <?php echo $video_session->getStatus(); ?>" data-toggle="tooltip" title="<?php echo VideoSessionService::$status_es[$video_session->getStatus()]; ?>">&nbsp;</div></td>
                    <td><?php echo format_date($video_session->getScheduledFor(), 'dd-MM-yyyy'); ?></td>
                    <td><?php echo format_date($video_session->getScheduledFor(), 'HH:mm'); ?>hs</td>
                    <td><?php echo $video_session->getTitle() ?></td>
                    <td><?php echo $video_session->getDescription() ?></td>
                    <td class="text-<?php echo $color ?>"><?php echo $video_session->getCourse()->getName().(empty($chapter) ? "" : " - {$chapter}"); ?></td>
                    <?php if($type==="next"): ?>
                    <td>
                        <div class="btn-group hangout_actions">
                        <?php if($isOwner): ?>
                            <a class="editVideoSession-button btn btn-mini" href="<?php echo url_for('video_session/edit?id=' . $video_session->getId()) ?>">Editar</a>
                            <a class="btn btn-mini btn-warning <?php echo $video_session->getStatus() != "started" ? "disabled" : "finishVideoSession-trigger" ?>">Finalizar</a>
                            <?php if(empty($storedUrl)): ?>
                            <div class="g-hangout" data-render="createhangout" data-initial_apps="[{ app_id : '36700081185', start_data : 'dQw4w9WgXcQ', 'app_type' : 'ROOM_APP' }]" data-widget_size="72"></div>
                            <?php else: ?>
                            <a target="_blank" class="btn btn-mini btn-success <?php echo $video_session->getStatus() != "started" ? "disabled" : "" ?>" href="<?php echo $hangout_url; ?>">Acceder</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a target="_blank" class="btn btn-mini btn-success <?php echo ($video_session->getStatus() != "started" || empty($storedUrl)) ? "disabled" : "" ?>" href="<?php echo $hangout_url; ?>">Acceder</a>
                        <?php endif; ?>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr class="warning">
                <td colspan="7">
                    <span class='icon-warning-sign'></span>
                    No se encontraron sesiones de video
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>