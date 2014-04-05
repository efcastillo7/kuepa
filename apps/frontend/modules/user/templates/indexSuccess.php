<div class="container margintop40">
	<form action="<?php echo url_for("user/update") ?>" method="POST" enctype='multipart/form-data'>
	    <div class="row">
			<div class="col-xs-12">
		        <p class="title2">
					Mi Perfil
		        </p>
			</div>
	    </div>
		<?php echo $form->renderGlobalErrors()?>
		<div class="row margintop40">
			    <div class="col-xs-12 col-md-6">
			        <?php echo $form['avatar']->renderRow(array('class' => 'form-avatar btn btn-gray')); ?>
				</div>
	    </div>
	    <div class="row">
			    <div class="col-xs-12 col-md-6">
			        <?php echo $form['nickname']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['first_name']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['last_name']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['email_address']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['culture']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['timezone']->renderRow(array('class' => 'input-big')); ?>
			    </div><!-- /col-md-6 -->
				<div class="col-xs-12 col-md-6">
			        <?php echo $form['password']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['repassword']->renderRow(array('class' => 'input-big')); ?>
			        <?php echo $form['sex']->renderRow(array('class' => 'selectpicker')); ?>
					<?php echo $form['birthdate']->renderRow(array('class' => 'selectpicker select-sm')); ?>
				</div>
	    </div>
	    <?php echo $form->renderHiddenFields()?>
	    <div class="row margintop40">
	    	<div class="col-xs-12">
				<button type="submit" class="btn btn-large btn-orange">Guardar</button>
				<button class="btn btn-large btn-gray">Cancelar</button>
			</div>
	    </div>
	</form>
	<div class="clear margintop60"></div>
</div>
