
<div class="container">
	<div class="row">
		<div class="span12">
			<?php use_helper('I18N') ?>
			<p class="title3"><?php echo __('Ingresar', null, 'sf_guard') ?></p>
			<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
		</div>
	</div>
</div>
