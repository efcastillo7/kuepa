<form action="/mail/create" method="POST" id="mail-form">
  <input type="hidden" name="mail[id]" id="mail_id" value="<?php echo $mail->getId(); ?>"/>
  <div class="row">
    <div class="span3">
      <label for="mail_content">Usuario(Profile id)</label>
      <input type="text" name="mail[user_id]" value="<?php echo $mail->getProfileId(); ?>" readonly tabindex="1">
      <label for="mail_email">Email</label>
      <input type="text" name="mail[email]" value="<?php echo $mail->getEmail(); ?>"  tabindex="3">
    </div>
    <div class="span2">
      <label for="mail_content">Nombre </label>
      <input type="text" name="mail[name]" value="<?php echo $mail->getName(); ?>"  tabindex="2">
      <label for="mail_subject">Asunto</label>
      <input type="text" name="mail[subject]" value="<?php echo $mail->getSubject(); ?>"  tabindex="4">
    </div>
  </div>

  <label for="mail_content">Contenido</label>
  <textarea name="mail[content]" id="mail_content">
    <?php echo $mail->getContent(); ?>
  </textarea>

  <label for="mail_priority">Prioridad</label></th>
  <select name="mail[priority]" id="mail_priority">
    <?php foreach ($mail->getPriorities() as $key => $value) {
        $selected = ( $mail->getPriority() == $value ) ? 'selected="selected"': '' ; 
     ?>
        <option <?php echo $selected ?> value="<?php echo $value ?>"> <?php echo $value  ?></option>
    <?php }  ?>
  </select>

  <div class="row-fluid">
    <div class="span3">
      <button type="submit" class="btn">Guardar</button>
    </div>
    <div class="span3">
      <button type="button" class="md-close" onClick="modalClose(jQuery('#form-mail-wrapper') )">Cerrar</button>
    </div>
  </div>
</form>