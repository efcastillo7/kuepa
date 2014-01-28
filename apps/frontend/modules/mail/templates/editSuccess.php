<div class="container">
<?php
  include_partial("mail/form",array("mail" => $mail));
?>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    tinyMCE.execCommand('mceAddEditor', false, 'mail_content');
  });
</script>