<div class="container">
<?php echo link_to("Nuevo","mail/new",array("class" => 'addMail-button')) ?>
<br>
<table class="table table-striped table-condensed table-hover">
   <thead>
    <tr>
      <td>Id</td>
      <td>Prioridad</td>
      <td>Status</td>
      <td>Email</td>
      <td>Subject</td>
      <td>Acciones</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($mails as $key => $mail) { ?>
      <tr>
        <td><?php echo $mail->getId() ?></td>
        <td><?php echo $mail->getPriority() ?></td>
        <td><?php echo $mail->getStatus() ?></td>
        <td><?php echo $mail->getEmail() ?></td>
        <td><?php echo substr( strip_tags($mail->getRaw('subject')), 0, 20 ) ?></td>
        <?php if( $mail->getStatus() != "sent"): ?>
        <td><?php echo link_to("Editar","mail/edit?id=".$mail->getId(),array("class" => 'editMail-button')) ?></td>
        <td><?php echo link_to("Enviar Ahora","mail/send?id=".$mail->getId()) ?></td>
        <td><?php echo link_to("Eliminar","mail/delete?id=".$mail->getId()) ?></td>
      <?php else: ?>
        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        <?php endif; ?>
        <td><?php echo link_to("Previsualizar","mail/preview?id=".$mail->getId()) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

</div> 

<!-- Form Add/Remove Profiles from groups -->
<div class="md-modal" id="form-mail-wrapper">
  <div class="md-content">
    <h3 id="title"></h3>
    <div id="md-subcontent">

    </div>
   </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    // Add Mail
    $("body").delegate(".addMail-button", "click", function(e) {
      var url = $(this).attr('href');
      $.get(url, {}, function(data){
        jQuery("#form-mail-wrapper > .md-content > #md-subcontent").html(data.template);
        tinyMCE.execCommand('mceRemoveEditor', false, 'mail_content');
        tinyMCE.execCommand('mceAddEditor', false, 'mail_content');
        tinyMCE.get('mail_content').setContent('');

      },'json');

      triggerModalSuccess({id: "form-mail-wrapper", title: "Crear Mail", effect: "md-effect-17"});
      return(false);
    });

   $("body").delegate(".editMail-button", "click", function(e) {
      var url = $(this).attr('href');
      $.get(url, {}, function(data){
        jQuery("#form-mail-wrapper > .md-content > #md-subcontent").html(data.template);
        tinyMCE.execCommand('mceRemoveEditor', false, 'mail_content');
        tinyMCE.execCommand('mceAddEditor', false, 'mail_content');
        tinyMCE.get('mail_content').setContent( data.mail_content );

      },'json');

      triggerModalSuccess({id: "form-mail-wrapper", title: "Crear Mail", effect: "md-effect-17"});
      return(false);
    });

  });
</script>