<form action="<?php echo url_for("video_session/create") . ($form->isNew() ? "" : "?id=" . $form->getObject()->getId()) ?>" method="POST" id="create-video_session-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>">
    <?php echo $form; ?>
    <input type="hidden" class="chapter_id" name="chapter_id" value="<?php echo $form->getObject()->getChapterId(); ?>" />
    <input type="hidden" class="students_ids" name="students_ids" value="<?php echo VideoSessionService::getInstance()->getParticipantsIds($form->getObject()->getId()); ?>" />
    <div class="usersSelection">
        <h5>Seleccione los participantes</h5>
        <div class="contUsers"></div>
    </div>
    <button type="submit" class="btn">Guardar</button>
</form>