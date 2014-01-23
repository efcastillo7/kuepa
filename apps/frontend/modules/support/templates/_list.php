<?php use_helper('Date'); ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th width="24"></th>
            <th width="140">Creada</th>
            <th>Alumno</th>
            <th>Atendido por</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($video_sessions) > 0):
            foreach ($video_sessions as $video_session):

                //If the hangout has already been created it's joined, otherwise it's created
                $storedUrl      = $video_session->getUrl();
                $supportName    = trim($video_session->getProfile()->getLastName()." ".$video_session->getProfile()->getFirstName());
                $storedUrl      = VideoSessionService::getInstance()->injectProfileId($storedUrl,$pid);

                ?>
                <tr data-id="<?php echo $video_session->getId() ?>" data-scheduled_for="<?php echo $video_session->getScheduledFor() ?>">
                    <td><div class="video_session_status <?php echo $video_session->getStatus(); ?>" data-toggle="tooltip" title="<?php echo VideoSessionService::$status_es[$video_session->getStatus()]; ?>">&nbsp;</div></td>
                    <td><?php echo format_date($video_session->getScheduledFor(), 'dd-MM-yyyy, HH:mm'); ?>hs</td>
                    <td><?php echo $video_session->getStudent()->getLastName()." ".$video_session->getStudent()->getFirstName() ?></td>
                    <td><?php echo empty($supportName) ? "Sin ateneder" : $supportName; ?></td>
                    <?php if($type==="pending"): ?>
                    <td>
                        <div class="btn-group hangout_actions">
                        <a class="btn btn-mini btn-warning <?php echo $video_session->getStatus() != "started" ? "disabled" : "finishSupport-trigger" ?>">Finalizar</a>
                        <a target="_blank" class="btn btn-mini btn-success accessSupport-button <?php echo empty($storedUrl) ? "disabled" : "" ?>" href="<?php echo $storedUrl; ?>" data-toggle="tooltip" title="<?php echo empty($storedUrl) ? "El usuario aún debe cargar la URL del hangout" : "Acceder ahora" ; ?>">Acceder</a>
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
                    No se encontraron sesiones de soporte
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>