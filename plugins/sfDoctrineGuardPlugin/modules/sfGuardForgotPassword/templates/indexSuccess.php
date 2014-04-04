<?php use_helper('I18N') ?>
<h2><?php echo __('Forgot your password?', null, 'sf_guard') ?></h2>

<p>
	No te preocupes, podemos ayudarte a que puedas volver a entrar a tu cuenta. <br>
	Completá tu dirección de e-mail a continuación para poder reestablecer tu contarseña.
</p>

<form action="<?php echo url_for('@sf_guard_forgot_password') ?>" method="post">
  <table>
    <tbody>
      <?php echo $form ?>
    </tbody>
    <tfoot><tr><td><input type="submit" name="change" value="<?php echo __('Reestablecer', null, 'sf_guard') ?>" /></td></tr></tfoot>
  </table>
</form>