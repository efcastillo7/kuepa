<?php use_helper('I18N') ?>

<p>Este e-mail es enviado por que has pedido información sobre cómo reestablecer tu contraseña.</p>

<p>Puedes cambiar tu contraseña haciendo click en el link que está a continuación. Recuerda que tiene validez por 24hs.</p>

<?php echo link_to(__('Reestablecer mi contraseña', null, 'sf_guard'), '@sf_guard_forgot_password_change?unique_key='.$forgot_password->unique_key, 'absolute=true') ?>